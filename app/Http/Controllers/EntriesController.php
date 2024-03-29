<?php

namespace App\Http\Controllers;

use App\CaseEntries;
use App\Cases;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class EntriesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('entries.index');
    }

    /*
     * Case create
     */

    public function create(Cases $case)
    {
        $caseEntries = CaseEntries::where('case_id', $case['id'])->count();
        $next_date = '';
        if ($caseEntries > 0) {
            $caseEntryLast = CaseEntries::where('case_id', $case['id'])->orderBy('next_date', 'desc')->first();
            $next_date = $caseEntryLast->next_date;
        }
        return view('entries.create', ['case' => $case, 'next_date' => $next_date]);
    }

    /*
     * Save cases
     */

    public function store(Request $request)
    {
        $date = Carbon::parse($request->input('date'))->format('Y-m-d H:i:s');
        if ($request->input('next_date')) {
            $nextdate = Carbon::parse($request->input('next_date'))->format('Y-m-d H:i:s');
        } else {
            $nextdate = null;
        }
        //$nextdate = Carbon::parse($request->input('next_date'))->format('Y-m-d H:i:s');

        $case = Cases::where('id', $request->input('case_id'))->first();
        $to = \App\User::where('id', $case->user_id)->first()->email;
        $model = new CaseEntries();
        $model->date = $date;
        //$model->coram = $request->input('coram');
        $model->stage = $request->input('stage');

//        if ($nextdate > $case->next_date){
//            $case->next_date = $nextdate;
//        }
        $case->stage = $request->input('stage');
        $case->save();
        $model->next_date = $nextdate;
        $model->bench = $request->input('bench');
        $model->is_order = ($request->input('is_order') == 'on') ? 1 : 0;
        $model->comments = $request->input('comments');
        $model->case_id = $request->input('case_id');
        $model->created_at = Carbon::now()->format('Y-m-d H:i:s');
        if ($request->input('send_mail') == "on") {
            $this->sendMail($to, $request->input('content'));
        }
        if ($request->hasFile('attachment')) {
            $imageName = $request->file('attachment')->getClientOriginalName();
            $filename = pathinfo($imageName, PATHINFO_FILENAME);
            $extension = pathinfo($imageName, PATHINFO_EXTENSION);

            $attachment = $filename . '-' . time() . "." . $extension; // 'qwe jpg'

            $model->attachment = $attachment;
        }

        if ($model->save()) {
            if ($model->next_date != null) {
                $this->createNextEntry($model);
            }
            if ($request->hasFile('attachment')) {
                $request->file('attachment')->move(public_path('attachment'), $attachment);
            }
            return redirect('/admin/cases/view/' . $request->input('case_id'));
        }

    }

    public function createNextEntry($oldEntry)
    {
        $model = new CaseEntries();
        $model->date = $oldEntry->next_date;
        $model->bench = $oldEntry->bench;
        $model->stage = $oldEntry->stage;
        $model->case_id = $oldEntry->case_id;
        $model->created_at = Carbon::now()->format('Y-m-d H:i:s');
        $model->save();
    }

    /*
     * update case
     */

    public function update(Request $request, CaseEntries $entries)
    {
        $nextdateEntry = $entries->next_date;

        if ($request->isMethod('post')) {

            //dd($request->all());

            $date = Carbon::parse($request->input('date'))->format('Y-m-d');
            $nextdate = Carbon::parse($request->input('next_date'))->format('Y-m-d');
            $nextEntry = CaseEntries::where('case_id', $request->input('case_id'))->where('date', $nextdateEntry)->first();


//            if ($request->input('next_date')) {
//                $nextdate = Carbon::parse($request->input('next_date'))->format('Y-m-d H:i:s');
//            } else {
//                $nextdate = $request->input('next_date');
//            }

//            $case = $entries->cases;
            $entries->date = $date;
            $entries->bench = $request->input('bench');
            $entries->stage = $request->input('stage');

//            if ($nextdate > $case->next_date) {
//                $case->next_date = $nextdate;
//                $case->save();
//            }
            $entries->next_date = $nextdate;
            $entries->comments = $request->input('comments');
            $entries->case_id = $request->input('case_id');
            $entries->updated_at = Carbon::now()->format('Y-m-d H:i:s');


            if ($request->hasFile('attachment')) {


                File::delete('attachment/' . $entries->attachment);

                $imageName = $request->file('attachment')->getClientOriginalName();

                $filename = pathinfo($imageName, PATHINFO_FILENAME);
                $extension = pathinfo($imageName, PATHINFO_EXTENSION);

                $attachment = $filename . '-' . time() . "." . $extension; // 'qwe jpg'

                $entries->attachment = $attachment;

            }

            if ($entries->save()) {
                if ($nextEntry == null) {
                    $this->createNextEntry($entries);
                } else {
                    $nextEntry->date = $entries->next_date;
                    $nextEntry->bench = $entries->bench;
                    $nextEntry->stage = $entries->stage;
                    $nextEntry->updated_at = Carbon::now()->format('Y-m-d H:i:s');
                    $nextEntry->save();
                }
                if ($request->hasFile('attachment')) {
                    $request->file('attachment')->move(public_path('attachment'), $attachment);
                }
                return redirect('/admin/cases/view/' . $entries->case_id);
            }
        }

        return view('entries.update', ['entries' => $entries]);
    }

    public function view(Request $request, CaseEntries $entries)
    {
        return view('entries.view', ['entries' => $entries]);
    }

    public function delete(Request $request)
    {
        $filename = CaseEntries::find($request->input('id'))->attachment;
        CaseEntries::find($request->input('id'))->delete();
        File::delete('attachment/' . $filename);
        return response()->json([
            'token' => 1
        ]);
    }

    public function updateItemNumber(Request $request)
    {
        $data = $request->input('data');
        foreach ($data as $id => $itemNumber) {
            $caseEntry = CaseEntries::where('id', $id)->first();
            $caseEntry->item_number = $itemNumber;
            $caseEntry->save();
        }
        Session::flash('success', 'Item Numbers are successfully updated.');

        return response()->json([
            'result' => 1
        ]);
    }

    public function searchEntry(Request $request)
    {
        return view('entries.search');
    }

    public function sendMail($to, $message)
    {
//        $to = 'devangi.thakore@gmail.com';
        $subject = 'Case Status';
        $from = 'support@nachiketa.com';
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: ' . $from . "\r\n" .
            'Reply-To: ' . $from . "\r\n";
        if (mail($to, $subject, $message, $headers)) {
            return true;
        } else {
            return false;
        }
    }
}
