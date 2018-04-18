<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\login;
use App\assignment;
use App\result;

session_start();

class f_controller extends Controller
{
    //faculty uploads doc
    public function f_uploaddoc(Request $request)
    {

        //  $post = $request->all();
        //$subject[0]=$post['f_course'];
        return view('f_upload');
        //	 return view('f_upload');
    }


    //view document
    public function view_projects()
    {
        $email = $_SESSION['email_id'];
        $teaches = \DB::table('teaches')->where('email_id', $email)->pluck('course_id');
        $res = \DB::table('assignment')->whereIn('course_id', $teaches)->get();
        $subject[0] = 'no_course_selected';
        if (count($res) == 0) {
            $error = 'No results found !';
            return Redirect()->back()->with('alert', 'No Record Found');
        } else {
            return view('/f_view', compact('res', 'subject'));
        }
    }


    //get the file not download only show 
    public function getDownload(Request $request)
    {
        //dd($request->filename);
        $file = storage_path() . '/app/public/' . $request->filename;
        return response()->file($file);
    }

    //evaluate
    public function evaluate()
    {

        $email_id = $_SESSION['email_id'];
        $f_course = \DB::table('teaches')->where('email_id', $email_id)->pluck('course_id');
         // echo count($f_course);
        $result = \DB::table('result')->pluck('ass_id');
        //echo count($result);
        $f_submitted = \DB::table('assignment')->whereIn('course_id', $f_course)->pluck('ass_id');
        //echo count($f_submitted);

        if (count($result) == 0) {
            $res = \DB::table('submitted')->whereIn('ass_id', $f_submitted)->get();
//		echo $res;
        } else {
            $res = \DB::table('submitted')->whereIn('ass_id', $f_submitted)->whereNotIn('ass_id', $result)->get();
//			echo $res;
        }
        if (count($res) == 0) {
            return Redirect()->back()->with('alert', 'No Record Found');

        } else {
            return view('/f_result', compact('res'));
        }
    }


    //submitted
    public function submitted(Request $request)
    {
        $email_id = $_SESSION['email_id'];
        $post = $request->all();
        $user = new assignment;
        echo $post["course"];
        $user->course_id = $post["course"];

        $timestamp = \Carbon\Carbon::createFromFormat('d/m/Y', $post["deadline"]);
        //echo $timestamp;
        $user->deadline = $timestamp;
        $user->ass_name = $post["ass_name"];

        $user->submission_url = $post["submission_url"];
        $user->assignment_url = $post["assignment_url"];

        $file = request()->file('filename');
        $extension = $file->getClientOriginalExtension();
        Storage::disk('public')->put($file->getClientOriginalName(), File::get($file));
        $user->filename = $file->getClientOriginalName();

        $user->save();
        $result = \DB::table('ftp_data')->where('email_id', $email_id)->get();

        $a = "open -u " . $result[0]->username . "," . $result[0]->password . " sftp://172.27.16.19; put -O ./public_html/assignment . " . $file->getClientOriginalName();

        $output = shell_exec('cd /home/ranjeet/Desktop/oass_l/storage/app/public && lftp -c  "' . $a . '"');
        echo $a;
        echo "<pre>$output</pre>";

        return Redirect::to('/faculty')->with('alert', 'Assignment submitted successfully...');
    }


    public function update_marks(Request $request)
    {

        $email_id = $_SESSION['email_id'];
        $post = $request->all();
        $f_course = \DB::table('teaches')->where('email_id', $email_id)->pluck('course_id');
        $result = \DB::table('result')->pluck('ass_id');

        $already_evaluated = \DB::table('assignment')->whereIn('course_id', $f_course)->where('course_id',$post["course_id"])->pluck('ass_id');

        $res = \DB::table('submitted')->whereIn('ass_id', $already_evaluated)->whereNotIn('ass_id', $result)->get();
       // echo count($res);
        for ($i = 0; $i < count($res); $i++) {
            $user = new result;
            $name=$res[$i]->email_id.$res[$i]->ass_id;
        //    print_r($post[str_replace(".", "_", $res[$i]->email_id)]);
            $user->marks = $post[str_replace(".", "_", $name)];
            $user->email_id = $res[$i]->email_id;
            $user->ass_id = $res[$i]->ass_id;
            $user->save();
        }

        return Redirect::to('/faculty')->with('alert', 'Marks Uploaded successfully...');

    }

    public function filter_v(Request $request)
    {
        $post = $request->all();
        $subject[0] = $post['f_course'];
        $email = $_SESSION['email_id'];
        $teaches = \DB::table('teaches')->where('email_id', $email)->pluck('course_id');
//        $res=\DB::table('assignment')->whereIn('course_id',$teaches)->whereIn('course_id',$subject[0])->get();
        $res = \DB::table('assignment')->whereIn('course_id', $teaches)->where('course_id', $subject[0])->get();

        if (count($res) == 0) {
            $error = 'No results found !';
            return Redirect()->back()->with('alert', 'No Record Found');
        } else {
            return view('/f_view', compact('res', 'subject'));
        }
    }

    public function filter_e(Request $request)
    {
        $post = $request->all();
        $subject[0] = $post['f_course'];
        //echo $subject[0];
        $email_id = $_SESSION['email_id'];
        $f_course = \DB::table('teaches')->where('email_id', $email_id)->pluck('course_id');
        //  echo count($f_course);
        $result = \DB::table('result')->pluck('ass_id');
        //echo count($result);
        //$f_submitted = \DB::table('assignment')->whereIn('course_id', $f_course)->pluck('ass_id');
        //echo $f_submitted;
        $f_submitted = \DB::table('assignment')->whereIn('course_id', $f_course)->where('course_id',$subject[0])->pluck('ass_id');
      //  echo count($f_submitted);

        if (count($result) == 0) {
            $res = \DB::table('submitted')->whereIn('ass_id', $f_submitted)->get();
		//echo $res;
        } else {
            $res = \DB::table('submitted')->whereIn('ass_id', $f_submitted)->whereNotIn('ass_id', $result)->get();
		//	echo $res;
        }
        return view('/f_result', compact('res'));

    }

}
