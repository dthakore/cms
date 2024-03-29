<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade as PDF;


use Illuminate\Database\Eloquent\Collection;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/cases/serverside', [
    'as'   => 'serverSide',
    'uses' => function (Request $request) {
        $cases = App\Cases::with(['entry', 'attachment','client']);


//        $query = "select id from cases where case_id in (select case_id from case_entries GROUP BY case_id DESC)";
//        $data = DB::select( DB::raw($query));
//        foreach ($data as $item) {
//            $cases[] = $item->id;
//        }
//        $cases = App\Cases::with(['entry', 'attachment','client'])->whereIn('id', $cases)->get();
        return \Yajra\DataTables\DataTables::of($cases)->addIndexColumn()->make(true);
    }
]);

Route::get('/clients/serverside', [
    'as'   => 'serverSide',
    'uses' => function (Request $request) {
        $query = "select model_id from model_has_roles where model_type = 'App\\\User' and role_id = (select id from roles where name = 'user')";
        $data = DB::select( DB::raw($query));
        foreach ($data as $item) {
            $user[] = $item->model_id;
        }
        $users = \App\User::whereIn('id', $user)->get();
        return \Yajra\DataTables\DataTables::of($users)->addIndexColumn()->make(true);
    }
]);
Route::get('/export/cases', [
    'as'   => 'serverSide',
    'uses' => function (Request $request) {
        $nextdate = \Carbon\Carbon::parse($request->input('next_date'))->format('Y-m-d');

        if($request->input('totaldays') !=0){
            $nextdates = next3days();
            $casesEntriesWithNextDate = App\CaseEntries::with(['cases','cases.client'])->whereIn('next_date', $nextdates)->get();
        } else {
            $casesEntriesWithNextDate = App\CaseEntries::with(['cases','cases.client'])->where('date','=', $nextdate)->get();
        }
        $case=array();
        foreach ($casesEntriesWithNextDate as $entry){

            $case[] = array(
                'case_number'=>$entry->cases->case_number,
                'court'=>$entry->cases->court,
                'bench'=>$entry->bench,
                'client'=>$entry->cases->client->name,
                'opponent_name'=>$entry->cases->opponent_name,
                'opponent_advocate'=>$entry->cases->opponent_advocates,
                'stage'=>$entry->stage,
                'item_number'=>$entry->item_number
                );
        }
        $data = ['title'=>'CAUSELIST OF '.date('d-m-Y',strtotime($nextdate)),'case_entries' => $case];
        $pdf = PDF::loadview('casePDF', $data);
        return $pdf->download('CAUSELIST-'.$nextdate.'.pdf');
    }
]);

Route::get('/admin/serverside', [
    'as'   => 'serverSide',
    'uses' => function (Request $request) {
        $query = "select model_id from model_has_roles where model_type = 'App\\\User' and role_id = (select id from roles where name = 'admin')";
        $data = DB::select( DB::raw($query));
        foreach ($data as $item) {
            $user[] = $item->model_id;
        }

        $users = \App\User::whereIn('id', $user)->get();
        return \Yajra\DataTables\DataTables::of($users)->addIndexColumn()->make(true);
    }
]);

Route::get('/entries/serverside', [
    'as'   => 'serverSide',
    'uses' => function (Request $request) {
        $casesEntries = App\CaseEntries::with(['cases'])->where('case_id',$request->input('case_id'));
        return \Yajra\DataTables\DataTables::of($casesEntries)->addIndexColumn()->make(true);
    }
]);

Route::get('/entries/dashboard', [
    'as'   => 'serverSide',
    'uses' => function (Request $request) {
        $casesEntries = App\CaseEntries::with(['cases'])->where('next_date','>=', date('Y-m-d')." 00:00:00");

        return \Yajra\DataTables\DataTables::of($casesEntries)->addIndexColumn()->make(true);
    }
]);

Route::get('/entries/dashboard2', [
    'as'   => 'serverSide',
    'uses' => function (Request $request) {
        $casesEntries = App\Cases::with(['entry','attachment'])->where('next_date','>=', date('Y-m-d')." 00:00:00")->where('stage','<>','Closed')->orderBy('created_at','desc')->take(10)->get();

        return \Yajra\DataTables\DataTables::of($casesEntries)->addIndexColumn()->make(true);
    }
]);

Route::post('/check/email', [
    'as'   => 'serverSide',
    'uses' => function (Request $request) {
       $user = \App\User::where('email', $request->input('email'))->first();
       if ($user){
           echo 'false';
       }else{
           echo 'true';
       }
    }
]);

Route::post('/check/email/update', [
    'as'   => 'serverSide',
    'uses' => function (Request $request) {
        $user = \App\User::where('email', $request->input('email'))->where('id','<>',$request->input('user'))->first();
        if ($user){
            echo 'false';
        }else{
            echo 'true';
        }
    }
]);

Route::post('/check/pass/update', [
    'as'   => 'serverSide',
    'uses' => function (Request $request) {
        $user = \App\User::where('id',$request->input('user'))->first();
        $currpass =  Hash::check($request->input('oldpassword'), $user->password);

        if ($currpass){
            echo 'true';
        }else{
            echo 'false';
        }
    }
])

;

Route::get('/case/search/serverside', [
    'as'   => 'serverSide',
    'uses' => function (Request $request) {
        if ($request->has('term') && $request->input('term') != '' ){

            $case = \App\Cases::with(['entry','attachment'])->where(function ($query) use ($request) {
                $query->where('case_number','like','%'.$request->input('term').'%')
                    ->where('user_id', $request->input('user'));
            })->orWhere(function ($query) use ($request) {
                $query->where('opponent_name', 'like', '%' . $request->input('term') . '%')
                    ->where('user_id', $request->input('user'));
            })->get();

        }else{
            $case = [];
        }
        return \Yajra\DataTables\DataTables::of($case)->addIndexColumn()->make(true);
    }
]);


Route::get('/case/search/entry', [
    'as'   => 'serverSide',
    'uses' => function (Request $request) {
        $nextdate = \Carbon\Carbon::parse($request->input('next_date'))->format('Y-m-d');

        if($request->input('totaldays') !=0){
            $nextdates = next3days();
            $casesEntriesWithNextDate = App\CaseEntries::with(['cases','cases.client'])->whereIn('next_date', $nextdates);
        } else {
            $casesEntriesWithNextDate = App\CaseEntries::with(['cases','cases.client'])->where('date','=', $nextdate);
        }
//        $case_ids = App\CaseEntries::with(['cases'])->whereNull('next_date')->where('date','=',$nextdate)->get()->pluck('cases.case_id')->toArray();
//        $allCasesEntries = App\CaseEntries::with(['cases'])
//            ->whereNull('next_date')->where('date','=',$nextdate);
        return \Yajra\DataTables\DataTables::of($casesEntriesWithNextDate)->addIndexColumn()->make(true);
    }
]);

Route::get('/get/cases', [
    'as'   => 'serverSide',
    'uses' => function (Request $request) {
        $cases = array();
        $nextdate = \Carbon\Carbon::parse($request->input('next_date'))->format('Y-m-d');
        $query = "select `case_number`,item_number,case_entries.id from cases,case_entries where case_entries.date='".$nextdate."' and case_entries.case_id=cases.id";
        $data = DB::select( DB::raw($query));
        foreach ($data as $item) {
            $cases[$item->id] = array('case_number'=>$item->case_number,'item_number'=>$item->item_number);
        }
        return json_encode($cases);
    }
]);

Route::get('/case/entry/export', [
    'as'   => 'serverSide',
    'uses' => function (Request $request) {
        ini_set('memory_limit','1024M');
        $nextdate = \Carbon\Carbon::parse($request->input('next_date'))->format('Y-m-d');
        $formattedNextDate = \Carbon\Carbon::parse($request->input('next_date'))->format('d-m-Y');
        if($request->input('totaldays') !=0){
            $nextdates = next3days();
            $casesEntries = App\CaseEntries::with(['cases','cases.client'])->whereIn('date', $nextdates)->get();
        } else {
            $casesEntries = App\CaseEntries::with(['cases','cases.client'])->where('date','=', $nextdate)->get();
        }
        $fileName =  \App\Helpers\GenerateCsv::createCsv($casesEntries,$formattedNextDate);

        echo json_encode([
            'token' => 1,
            'filename' => $fileName
        ]);
    }
]);

Route::post('/entries/delete/csv', [
    'as'   => 'serverSide',
    'uses' => function (Request $request) {
        $token = unlink(base_path('public/'.$request->input('file')));
        echo $token; die;
    }
]);

function next3days(){
    $nextdates = array();
    $date = time();
    $next = strtotime('+3 days');
    $count = 1;
    while ($count <= 3) { // loop until next six
        $date = strtotime('+1 day', $date);
        $weekOfdays = date('l', $date);
        if (strtolower($weekOfdays) == 'sunday') {
            continue;
        }
        $nextdates[] = date('Y-m-d',$date);
        $count ++;
    }
    return $nextdates;
}
