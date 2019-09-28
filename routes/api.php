<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
                $query->where('complainant_name', 'like', '%' . $request->input('term') . '%')
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
//        $case_ids = App\CaseEntries::with(['cases'])->whereNull('next_date')->where('date','=',$nextdate)->get()->pluck('cases.case_id')->toArray();
//        $allCasesEntries = App\CaseEntries::with(['cases'])
//            ->whereNull('next_date')->where('date','=',$nextdate);
        $casesEntriesWithNextDate = App\CaseEntries::with(['cases','cases.client'])->where('next_date','=', $nextdate);

        return \Yajra\DataTables\DataTables::of($casesEntriesWithNextDate)->addIndexColumn()->make(true);
    }
]);

Route::get('/case/entry/export', [
    'as'   => 'serverSide',
    'uses' => function (Request $request) {
        ini_set('memory_limit','1024M');

        $nextdate = \Carbon\Carbon::parse($request->input('next_date'))->format('Y-m-d');
        $formattedNextDate = \Carbon\Carbon::parse($request->input('next_date'))->format('d-m-Y');
        $casesEntries = App\CaseEntries::with(['cases','cases.client'])->where('next_date','=', $nextdate)->get();
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
