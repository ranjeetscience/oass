@extends('master')
@section('title', 'Student Page')
@section('css')
@endsection

@section('body')

    <div class="container">
        <h4 class="center blue-text text-darken-2"><u>New Assignments</u></h4>

        <div class="row">
            <table class="striped table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Course Id</th>
                        <th>Posted Time</th>
                        <th>DeadLine</th>
                        <th>Action</th>
                    </tr>
                </thead>
             <?php $i=1;


                for($j=1;$j<sizeof($assignment_posted);$j++){
                ?>
                <tbody>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td>{{$assignment_posted[$j]->course_id}}</td>
                        <td>{{$assignment_posted[$j]->posted_time}}</td>
                        <td>{{$assignment_posted[$j]->deadline}}</td>
                        <td>
                            <?php
                                date_default_timezone_set('Asia/Kolkata');
                                $t=time();
                                $deadline=strtotime($assignment_posted[$j]->deadline);
                                if($t<$deadline){
                            ?>
                            <a class="waves-effect waves-light btn-small" href="student_submit/{{$assignment_posted[$j]->ass_id+"\""}}">
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
                <?php } ?>
            </table>

        </div>
    </div>

@endsection