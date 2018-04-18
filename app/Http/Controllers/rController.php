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
use App\submitted;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
session_start();

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
      	    foreach ($check as $key)
            {
                $_SESSION['email_id']=$key->email_id;
            }

      	    if($key->hasrole==1)
      		    return Redirect::to('/student')->with('alert','Login Successful');
      	    elseif($key->hasrole==2)
                return Redirect::to('/faculty')->with('alert','Login Successful');
      	    else
                return Redirect::to('/faculty')->with('alert','Login Successful');

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
      if(Input::get('type')=="student")
      {
          $user->hasrole=1;
      }
      elseif (Input::get('type')=="faculty")
      {
          $user->hasrole=2;
      }
      else
      {
          $user->hasrole=3;
      }
      $user->passwd=Input::get('password');
      $user->save();
      $error ='SuccessFully Registed';
      return Redirect::to('/')->with('alert', $error);
    }

    public function assignment_view_student()
    {

        $email_id=$_SESSION["email_id"];
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
        return view('assignment_view_student',compact('assignment_posted','student_submitted_assignment'));
    }

    public function submitted_assignment(Request $request)
    {
        $post = $request->all();
        $user = new submitted;
        $user->email_id =$_SESSION["email_id"];
        $email_id=$_SESSION["email_id"];

        $file = request()->file('file');
        $user->ass_id= $post["assignment_id"];
        $user->original_filename =$file->getClientOriginalName();
        Storage::disk('public')->put($file->getClientOriginalName(),  File::get($file));
        $user->save();
        $assignment=\DB::table('assignment')->where('ass_id',$post["assignment_id"])->get();



        $result=\DB::table('ftp_data')->where('email_id',"lalitkumar@iiitdmj.ac.in")->get();

        $a="open -u ".$result[0]->username.",".$result[0]->password." sftp://172.27.16.19; put -O ./public_html/submitted . ".$file->getClientOriginalName();

        $output =shell_exec('cd /home/ranjeet/Desktop/oass_l/storage/app/public && lftp -c  "'.$a.'"');
        echo $a;

        echo "<pre>$output</pre>";

        return Redirect::to('/student')->with('alert','Assignment submitted successfully');

    }

    public function assignment_submitted()
    {
        $email_id=$_SESSION["email_id"];
        $student_submitted_assignment=\DB::table('submitted')
                                        ->where('email_id',$email_id)
                                        ->orderBy('submitted_time','desc')
                                        ->get();
        $assignment_staus=[''];
        $course_id=[''];
        $ass_name=[''];
        foreach ($student_submitted_assignment as $key)
        {
            $result=\DB::table('result')->where('email_id',$email_id)->where('ass_id',$key->ass_id)->get();
            $course=\DB::table('assignment')->where('ass_id',$key->ass_id)->pluck('course_id');
            $ass=\DB::table('assignment')->where('ass_id',$key->ass_id)->pluck('ass_name');
            array_push($course_id,$course);
            array_push($ass_name,$ass);

            if(count($result)!=0)
            {
                array_push($assignment_staus,$result[0]->marks);
            }
            else{
                array_push($assignment_staus,-1);

            }
        }

        return view('submitted_assignment_student',compact('student_submitted_assignment','assignment_staus','course_id','ass_name'));
    }

    public function getFile($filename)
    {

        return response()->file(storage_path("app/public/{$filename}"));
    }
}
