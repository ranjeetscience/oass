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
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('login');
});
Route::post('/login','rController@login');
Route::post('/signup','rController@signup');


Route::get('/student',function(){
    return view('student');
});
Route::get('/logout',function(){
    session_start();
    session_destroy();
    return view('login');
});

Route::get('/student_view','rController@assignment_view_student');

Route::get('/student_submit/{id}',function($id){


    $assignment=\DB::table('assignment')->where('ass_id',$id)->get();
    return view('student_submit',compact('assignment'));
});

Route::post('/submitted_assignment','rController@submitted_assignment');
Route::get('/assignment_submitted','rController@assignment_submitted');
Route::get('/getFile/{filename}','rController@getFile');
Route::get('/student_view1','rController@assignment_view_student1');



//faculty
Route::get('/faculty',function()
{
    return view('faculty');
});

//view 
Route::get('/f_view','f_controller@view_projects');

//Route::get('/f_uploaddoc','f_controller@view_projects');
Route::post('/download','f_controller@getDownload');
Route::post('/submitted','f_controller@submitted');
Route::post('/update_marks','f_controller@update_marks');
Route::post('/filter_v','f_controller@filter_v');

Route::post('/filter_e','f_controller@filter_e');

Route::get('/f_result','f_controller@evaluate');

Route::post('/f_upload',function(Request $request){

    $post = $request->all();
    $id=$post['f_course'];
    return view('f_upload',compact('id'));
});

