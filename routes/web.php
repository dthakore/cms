<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


Auth::routes();
Route::get('/', 'HomeController@index')->name('home')->middleware(['role:admin|super_admin']);
Route::group(['prefix' => '/admin', 'middleware' => ['role:admin|super_admin'],'auth'], function (){

    Route::get('/cases', 'CaseController@index');
    Route::get('/cases/create', 'CaseController@create');
    Route::post('/cases/create', 'CaseController@store');
    Route::get('/cases/update/{case}', 'CaseController@update');
    Route::post('/cases/save/{case}', 'CaseController@update');
    Route::get('/cases/view/{case}', 'CaseController@view');
    Route::post('/cases/delete', 'CaseController@delete');


    Route::get('/clients', 'ClientController@index');
    Route::get('/clients/create', 'ClientController@create');
    Route::post('/clients/create', 'ClientController@store');
    Route::get('/clients/update/{user}', 'ClientController@update');
    Route::post('/clients/save/{user}', 'ClientController@update');
    Route::get('/clients/view/{user}', 'ClientController@view');
    Route::post('/clients/delete', 'ClientController@delete');

    Route::get('/adminlist', 'AdminController@adminlist');
    Route::get('/create', 'AdminController@create');
    Route::post('/create', 'AdminController@store');
    Route::get('/update/{user}', 'AdminController@update');
    Route::post('/save/{user}', 'AdminController@update');
    Route::get('/view/{user}', 'AdminController@view');
    Route::post('/delete', 'AdminController@delete');

    Route::get('/entries', 'EntriesController@index');
    Route::get('/entries/create/{case}', 'EntriesController@create');
    Route::post('/entries/create', 'EntriesController@store');
    Route::get('/entries/update/{entries}', 'EntriesController@update');
    Route::post('/entries/save/{entries}', 'EntriesController@update');
    Route::get('/entries/view/{entries}', 'EntriesController@view');
    Route::post('/entries/delete', 'EntriesController@delete');
    Route::get('/search/entry', 'EntriesController@searchEntry');

    Route::get('/attachments', 'AttachmentController@index');
    Route::get('/attachments/create/{case}', 'AttachmentController@create');
    Route::post('/attachments/create', 'AttachmentController@store');
    Route::get('/attachments/update/{attachment}', 'AttachmentController@update');
    Route::post('/attachments/save/{attachment}', 'AttachmentController@update');
    Route::get('/attachments/view/{attachment}', 'AttachmentController@view');
    Route::post('/attachments/delete', 'AttachmentController@delete');

});

Route::get('/permissions', function (){
    //Role::create(['name'=>'user']);
    $role = Role::findById(5);
    auth()->user()->assignRole($role);
});

Route::get('/update/password/{user}', 'ClientController@updatepass');
Route::post('/clients/pass/save/{user}', 'ClientController@updatepassword');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/case/search', 'CaseController@search');
Route::get('/case/search/{case}', 'CaseController@result');
Route::get('/case/entries/search/{entries}', 'CaseController@entriesresult');
