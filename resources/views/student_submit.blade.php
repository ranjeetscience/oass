@extends('master')
@section('title', 'Student Page')
@section('css')
@endsection

@section('body')
<div class="container">
    <h4 class="center blue-text text-darken-2"><u>Assignment Submission</u></h4>
    <div class="row">
        <div class="col s12 m6 l4">
            <h6>Course Id: {{ $assignment[0]->course_id }}</h6>
        </div>
        <div class="col s12 m6 l4">
            <h6>Course Name:</h6>
        </div>
        <div class="col s12 m6 l4">
            <h6>Deadline: {{ $assignment[0]->deadline }}</h6>
        </div>
    </div>
    <form class="col s7" action="/submitted_assignment" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type='hidden' name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="assignment_id" value="{{ $assignment[0]->ass_id }}">
            <div class="file-field input-field">
                <div class="btn">
                    <span>File</span>
                    <input type="file" name="file" required>
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                </div>
            </div>
            <div class="center">
                <button class="btn" name="submit" type="submit">Submit</button>
            </div>
    </form>
</div>
@endsection