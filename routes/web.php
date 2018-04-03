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

Route::get('/', function () {
    return view('login');
});
Route::post('/login','rController@login');
Route::post('/signup','rController@signup');


Route::get('/student',function(){
    return view('student');
});

Route::get('/student_view','rController@assignment_view_student');

Route::get('/student_submit/{id}',function($id){


    $assignment=\DB::table('assignment')->where('ass_id',$id)->get();
    return view('student_submit',compact('assignment'));
});

Route::post('/submitted_assignment','rController@submitted_assignment');
Route::get('/assignment_submitted','rController@assignment_submitted');
Route::get('/getFile/{filename}','rController@getFile');