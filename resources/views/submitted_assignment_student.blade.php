@extends('master')
@section('title', 'Student Page')
@section('css')
@endsection

@section('body')

<div class="container">
    <h4 class="center blue-text text-darken-2"><u>Submitted Assignment</u></h4>
    <div class="row">
        <table class="striped table-bordered">
            <thead>
            <tr>
                <th>S.No</th>
                <th>Course Id</th>
                <th>Assignment Name</th>
                <th>Submitted Time</th>
                <th>File Name</th>
                <th>Marks</th>
            </tr>
            </thead>
            <?php $i=1;?>
            @foreach($student_submitted_assignment as $key)
                <tbody>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td>{{$course_id[$i-1][0]}}</td>
                    <td>{{$ass_name[$i-1][0]}}</td>
                    <td>{{$key->submitted_time}}</td>
                    <td><a href="/getFile/{{$key->original_filename}}"> {{$key->original_filename}}</a></td>
                    @if($assignment_staus[$i-1]==-1)
                        <td class="orange-text"><i> Processing </i></td>
                    @else
                        <td class="green-text"> {{ $assignment_staus[$i-1]  }}</td>
                    @endif
                </tr>
                </tbody>
           @endforeach
        </table>

    </div>
</div>

@endsection