<?php

namespace App\Http\Controllers;

use App\CaseAttachments;
use App\CaseEntries;
use App\Cases;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AttachmentController extends Controller
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
        return view('attachments.index');
    }

    /*
     * Case create
     */

    public function create(Cases $case)
    {
        return view('attachments.create',['case' => $case]);
    }

    /*
     * Save attachments
     */

    public function store(Request $request)
    {
        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $key => $value){
                $imageName = $value->getClientOriginalName();
                $filename = pathinfo($imageName, PATHINFO_FILENAME);
                $extension = pathinfo($imageName, PATHINFO_EXTENSION);

                $attachment = $filename . '-' . time() . "." . $extension; // 'qwe jpg'
                $model = new CaseAttachments();
                $model->attachment = $attachment;
                $model->case_id = $request->input('case_id');

                if ($model->save()){
                    $value->move(public_path('attachment'), $attachment);
                }
            }

            return redirect('/admin/cases/view/'.$request->input('case_id'));
        }



    }

    /*
     * update attachment
     */

    public function update(Request $request, CaseEntries $attachments)
    {
        if ($request->isMethod('post')) {

            //dd($request->all());

            $date = Carbon::parse($request->input('date'))->format('Y-m-d');
            $nextdate = Carbon::parse($request->input('next_date'))->format('Y-m-d');

            $attachment = $attachments->attachments;
            $attachments->date = $date;
            $attachments->coram = $request->input('coram');
            $attachments->stage = $request->input('stage');
            if ($nextdate > $attachment->next_date){
                $attachment->next_date = $nextdate;
                $attachment->save();
            }
            $attachments->next_date = $nextdate;
            $attachments->comments = $request->input('comments');
            $attachments->attachment_id = $request->input('attachment_id');
            $attachments->updated_at = Carbon::now()->format('Y-m-d H:i:s');



            if($request->hasFile('attachment')) {


                File::delete('attachment/'.$attachments->attachment);

                $imageName = $request->file('attachment')->getClientOriginalName();

                $filename = pathinfo($imageName, PATHINFO_FILENAME);
                $extension = pathinfo($imageName, PATHINFO_EXTENSION);

                $attachment = $filename . '-' . time() . "." . $extension; // 'qwe jpg'

                $attachments->attachment = $attachment;

            }

            if ($attachments->save()){
                if ($request->hasFile('attachment')) {
                    $request->file('attachment')->move(public_path('attachment'), $attachment);
                }
                return redirect('/admin/attachments/view/'.$attachments->attachment_id);
            }
        }

        return view('attachments.update', ['attachments' => $attachments]);
    }

    public function view(Request $request, CaseEntries $attachments){
            return view('attachments.view', ['attachments' => $attachments]);
    }

    public function delete(Request $request){
        $filename = CaseAttachments::find($request->input('id'))->attachment;
        CaseAttachments::find($request->input('id'))->delete();
        File::delete('attachment/'.$filename);
        return response()->json([
           'token' => 1
        ]);
    }
}
