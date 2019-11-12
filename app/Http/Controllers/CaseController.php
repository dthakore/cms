<?php

namespace App\Http\Controllers;

use App\CaseAttachments;
use App\CaseEntries;
use App\Cases;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CaseController extends Controller
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

        return view('cases.index');
    }

    /*
     * Case create
     */

    public function create()
    {
        $query = "select model_id from model_has_roles where model_type = 'App\\\User' and role_id = (select id from roles where name = 'user')";
        $data = DB::select( DB::raw($query));
        foreach ($data as $item) {
            $user[] = $item->model_id;
        }
        $users = \App\User::whereIn('id', $user)->get();
        return view('cases.create',['users' => $users]);
    }

    /*
     * Save cases
     */

    public function store(Request $request)
    {
        $date_of_filing = Carbon::parse($request->input('date_of_filing'))->format('Y-m-d H:i:s');
        $forum =  \App\Helpers\Courts::getCourtName($request->input('forum'));
        ($request->input('state') == '0')?$state = '':$state = $request->input('state');
        ($request->input('id-Rajasthan') == '0')?$id_raj = '':$id_raj = $request->input('id-Rajasthan');
        ($request->input('id-Gujarat') == '0')?$id_guj = '':$id_guj = $request->input('id-Gujarat');
        if($request->input('state') == 0 && $request->input('court') == null){
            $court = $forum;
        } else {
            if($id_guj == '' && $id_raj == '') {
                $court = $forum.' ['.$request->input('court').' ]';
            } else {
                $court = $forum.' ['.$request->input('court').' -'.$state.' ('.$id_guj.
                    $id_raj.')'.' ]';
            }

        }
        $model = new Cases();
        if($request->input('applicant') == 0){
            $model->type = 1;
        } else {
            $model->type = 2;
        }
        $model->client_role = $request->input('client_role');
        $model->opponent_role = $request->input('opponent_role');
        $model->opponent_advocates = $request->input('opponent_advocate');
        $model->case_number = $request->input('case_number');
        $model->court = $court;
        $model->opponent_name = $request->input('opponent_name');
        $model->complainant_details = $request->input('complainant_details');
        $model->date_of_filing = $date_of_filing;
        $model->case_type = $request->input('case_type');
        $model->stage = $request->input('stage');
        $model->comments = $request->input('comments');
        $model->user_id = $request->input('user_id');
        $model->created_at = Carbon::now()->format('Y-m-d H:i:s');
        if ($model->save()){
            return redirect('/admin/cases');
        }

    }

    /*
     * update case
     */

    public function update(Request $request, Cases $case)
    {
        if ($request->isMethod('post')) {
            $date_of_filing = Carbon::parse($request->input('date_of_filing'))->format('Y-m-d H:i:s');
           $case->case_number = $request->input('case_number');
            $case->opponent_name = $request->input('opponent_name');
            $case->complainant_details = $request->input('complainant_details');
            $case->date_of_filing = $date_of_filing;
            //$case->court = $court;
            $case->stage = $request->input('stage');
            $case->comments = $request->input('comments');
            $case->user_id = $request->input('user_id');
            $case->updated_at = Carbon::now()->format('Y-m-d H:i:s');

            if ($case->save()){
                return redirect('/admin/cases');
            }
        }

        $query = "select model_id from model_has_roles where model_type = 'App\\\User' and role_id = (select id from roles where name = 'user')";
        $data = DB::select( DB::raw($query));
        foreach ($data as $item) {
            $user[] = $item->model_id;
        }
        $users = \App\User::whereIn('id', $user)->get();
        return view('cases.update', ['case' => $case, 'users' => $users]);
    }

    public function view(Request $request, Cases $case){
            $attachment = CaseAttachments::where('case_id', $case->id)->get();
            $caseEntries = CaseEntries::where('case_id', $case->id)->get()->last();

        return view('cases.view', ['case' => $case, "attachment" => $attachment,'caseEntries'=>$caseEntries]);
    }

    public function delete(Request $request){
        Cases::find($request->input('id'))->delete();
        return response()->json([
            'token' => 1
        ]);
    }

    public function search(Request $request){
        return view('cases.search');
    }

    public function result(Request $request, Cases $case){
        return view('cases.result', ['case' => $case]);
    }

    public function entriesresult(Request $request, CaseEntries $entries){
        return view('cases.entriesview', ['entries' => $entries]);
    }
}
