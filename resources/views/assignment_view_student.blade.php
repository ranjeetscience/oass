@extends('master')
@section('title', 'Student Page')
@section('css')
@endsection

@section('body')

    <div class="container">
        <h4 class="center blue-text text-darken-2"><u>New Assignments</u></h4>

        <div class="row">
            <table class="striped table-bordered highlight">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Course Id</th>
                        <th>Assignment Name</th>
                        <th>Assignment File</th>
                        <th>Posted Time</th>
                        <th>DeadLine</th>
                        <th>Action</th>
                    </tr>
                </thead>
             <?php $i=1;
                if(sizeof($assignment_posted)>1){

                for($j=1;$j<sizeof($assignment_posted);$j++){
                ?>
                <tbody>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td>{{$assignment_posted[$j]->course_id}}</td>
                        <td>{{$assignment_posted[$j]->ass_name}}</td>

                        <?php

                                $teaches=\DB::table('teaches')->where('course_id',$assignment_posted[$j]->course_id)->get();
                                $url=\DB::table('ftp_data')->where('email_id',$teaches[0]->email_id)->pluck('username');

                                $assignment=\DB::table('assignment')->where('ass_id',$assignment_posted[$j]->ass_id)->pluck('assignment_url');

                        ?>

                        <td><a href="http://web.iiitdmj.ac.in/~{{$url[0]}}/{{$assignment[0]}}/{{$assignment_posted[$j]->filename}}"> {{$assignment_posted[$j]->filename}}</a></td>
                        <td>{{$assignment_posted[$j]->posted_time}}</td>
                        <td>{{$assignment_posted[$j]->deadline}}</td>
                        <td>
                            <?php
                                date_default_timezone_set('Asia/Kolkata');
                                $t=time();
                                $deadline=strtotime($assignment_posted[$j]->deadline);
                                if($t<$deadline){
                            ?>
                            <a class="waves-effect waves-light btn-small" href="student_submit/{{$assignment_posted[$j]->ass_id}}">
                                <i class="material-icons right">send</i>Submit</a>
                            <?php
                                }
                                else{
                                    echo " <span class='red-text'> Deadline Over</span>";
                                }
                                ?>
                        </td>
                    </tr>
                </tbody>
                <?php } }
                else{
                ?>
                <tr class="center">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="center-align">
                        <h5 class="center">No Assignment!</h5>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php } ?>
            </table>

        </div>
    </div>

@endsection