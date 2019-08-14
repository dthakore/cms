<?php

namespace App\Http\Controllers;

use App\CaseEntries;
use App\Cases;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
        $caseEntries = CaseEntries::where('case_id',$case['id'])->count();
        $next_date = '';
        if($caseEntries>0){
            $caseEntryLast = CaseEntries::where('case_id',$case['id'])->get()->last();
            $next_date = $caseEntryLast->next_date;
        }
        return view('entries.create',['case' => $case,'next_date'=>$next_date]);
    }

    /*
     * Save cases
     */

    public function store(Request $request)
    {
        //dd($request->all());
        $date = Carbon::parse($request->input('date'))->format('Y-m-d H:i:s');
        if ($request->input('next_date')){
            $nextdate = Carbon::parse($request->input('next_date'))->format('Y-m-d H:i:s');
        }else{
            $nextdate = null;
        }
        //$nextdate = Carbon::parse($request->input('next_date'))->format('Y-m-d H:i:s');

        $case = Cases::where('id',$request->input('case_id'))->first();
        $model = new CaseEntries();
        $model->date = $date;
        $model->coram = $request->input('coram');
        $model->stage = $request->input('stage');

//        if ($nextdate > $case->next_date){
//            $case->next_date = $nextdate;
//        }
            $case->stage = $request->input('stage');
            $case->save();


        $model->next_date = $nextdate;
        $model->comments = $request->input('comments');
        $model->case_id = $request->input('case_id');
        $model->created_at = Carbon::now()->format('Y-m-d H:i:s');



        if ($request->hasFile('attachment')) {
            $imageName = $request->file('attachment')->getClientOriginalName();
            $filename = pathinfo($imageName, PATHINFO_FILENAME);
            $extension = pathinfo($imageName, PATHINFO_EXTENSION);

            $attachment = $filename . '-' . time() . "." . $extension; // 'qwe jpg'

            $model->attachment = $attachment;
        }

        if ($model->save()){
            if ($request->hasFile('attachment')) {
                $request->file('attachment')->move(public_path('attachment'), $attachment);
            }
            return redirect('/admin/cases/view/'.$request->input('case_id'));
        }

    }

    /*
     * update case
     */

    public function update(Request $request, CaseEntries $entries)
    {
        if ($request->isMethod('post')) {

            //dd($request->all());

            $date = Carbon::parse($request->input('date'))->format('Y-m-d');
            //$nextdate = Carbon::parse($request->input('next_date'))->format('Y-m-d');

            if ($request->input('next_date')){
                $nextdate = Carbon::parse($request->input('next_date'))->format('Y-m-d H:i:s');
            }else{
                $nextdate = null;
            }

            $case = $entries->cases;
            $entries->date = $date;
            $entries->coram = $request->input('coram');
            $entries->stage = $request->input('stage');
            if ($nextdate > $case->next_date){
                $case->next_date = $nextdate;
                $case->save();
            }
            $entries->next_date = $nextdate;
            $entries->comments = $request->input('comments');
            $entries->case_id = $request->input('case_id');
            $entries->updated_at = Carbon::now()->format('Y-m-d H:i:s');



            if($request->hasFile('attachment')) {


                File::delete('attachment/'.$entries->attachment);

                $imageName = $request->file('attachment')->getClientOriginalName();

                $filename = pathinfo($imageName, PATHINFO_FILENAME);
                $extension = pathinfo($imageName, PATHINFO_EXTENSION);

                $attachment = $filename . '-' . time() . "." . $extension; // 'qwe jpg'

                $entries->attachment = $attachment;

            }

            if ($entries->save()){
                if ($request->hasFile('attachment')) {
                    $request->file('attachment')->move(public_path('attachment'), $attachment);
                }
                return redirect('/admin/cases/view/'.$entries->case_id);
            }
        }

        return view('entries.update', ['entries' => $entries]);
    }

    public function view(Request $request, CaseEntries $entries){
            return view('entries.view', ['entries' => $entries]);
    }

    public function delete(Request $request){
        $filename = CaseEntries::find($request->input('id'))->attachment;
        CaseEntries::find($request->input('id'))->delete();
        File::delete('attachment/'.$filename);
        return response()->json([
           'token' => 1
        ]);
    }

    public function searchEntry(Request $request){
        return view('entries.search');
    }
}
