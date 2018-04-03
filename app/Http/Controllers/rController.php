<?php

namespace App\Http\Controllers;

use App\assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\login;

class rController extends Controller
{
    public function login(Request $request)
    {
    	$user=new login;
      	$username=Input::get('email');
      	$password=Input::get('password');
    	
      	$check = \DB::table('login')->where('email_id',$username)->where('passwd',$password)->get();
      	echo count($check);
      	if(count($check)==1)
      	{
      		return Redirect::to('/dashboard')->with('alert','Login Successful for ');

      	}
      	else
      	{
			return Redirect::to('/')->with('alert','Login Error!! Please check your Credentials');
      	}

    }

    public function signup(Request $request)
    {
      $user=new login;
      $check = \DB::table('login')->where('email_id',Input::get('email'))->get();

      if(count($check)==1)
      	{
			return Redirect::to('/')->with('alert','Email Already Exists');

      	}
      $user->email_id=Input::get('email');
      $user->hasrole=Input::get('type');
      $user->passwd=Input::get('password');
      $user->save();
      $error ='SuccessFully Registed';
      return Redirect::to('/')->with('alert', $error);
    }

    public function assignment_view_student()
    {
        $email_id="a@a";
        $student_registered_courses=\DB::table('enrolled_in')->where('email_id',$email_id)->pluck('course_id');
        $student_submitted_assignment=\DB::table('submitted')->where('email_id',$email_id)->pluck('ass_id');

        $assignment_posted=[''];
        for($i=0;$i<count($student_registered_courses);$i++)
        {
            $x=\DB::table('assignment')->where('course_id', $student_registered_courses[$i])
                ->whereNotIn('ass_id',$student_submitted_assignment)
                ->orderBy('deadline',' DESC')
                ->get();

            for($j=0;$j<sizeof($x);$j++)
               array_push($assignment_posted,$x[$j]);
        }
      /*  $string_version = implode(',', $assignment_posted);

        echo $string_version;*/
        return view('assignment_view_student',compact('assignment_posted','student_submitted_assignment'));
    }

    public function submitted_assignment(Request $request)
    {
        $post = $request->all();
        $user = new assignment;
        $user->email_id ='a@a';

        $file = request()->file('file');
        //$user->type=$file->getMimeType();

        $user->ass_id= $post["assignment_id"];
        $user->original_filename =$file->getClientOriginalName();

        $extension = $file->getClientOriginalExtension();
        /*$user->filename =*/// echo $file->getFilename().'.'.$extension;
        /*        $user->description=$post["description"];*/
        Storage::disk('public')->put($file->getClientOriginalName(),  File::get($file));
        $user->save();
        return Redirect::to('/student')->with('alert','Assignment submitted successfully');


    }

    public function assignment_submitted()
    {
        $email_id="a@a";
        $student_submitted_assignment=\DB::table('submitted')
                                        ->where('email_id',$email_id)
                                        ->orderBy('submitted_time','desc')
                                        ->get();
        $assignment_staus=[''];
        $course_id=[''];
        foreach ($student_submitted_assignment as $key)
        {
            $result=\DB::table('result')->where('email_id',$email_id)->where('ass_id',$key->ass_id)->get();
            $course=\DB::table('assignment')->where('ass_id',$key->ass_id)->pluck('course_id');
            array_push($course_id,$course);
            if(count($result)!=0)
            {
                array_push($assignment_staus,$result[0]->marks);
            }
            else{
                array_push($assignment_staus,-1);

            }
        }

        return view('submitted_assignment_student',compact('student_submitted_assignment','assignment_staus','course_id'));
    }

    public function getFile($filename)
    {
        $filename='printTicket.pdf';
        $file = Storage::disk('local')->get($filename);
        return response()->download(storage_path("app/public/{$filename}"));    }
}
