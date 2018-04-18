@extends('master')
@section('title', 'Student Page')
@section('css')
    <style media="screen" type="text/css" >
        #cards
        {
            margin-top: 60px;
        }
    </style>
@endsection

@section('body')
    @if($alert = Session::get('alert'))
        <script type="text/javascript">alert("{{$alert}}");</script>
        <?php header("Refresh:0"); ?>
    @endif
<div class="container">
    <div class="row" id="cards">
        <div class="col s12 m7 l6 ">
            <div class="card small">
                <div class="card-image">
                    <img src="images/Books_Bokeh.jpg">
                    <span class="card-title black-text"><b>New Assignment</b></span>
                </div>
                <div class="card-content">
                    <p>All your new assignment are here</p>
                </div>
                <div class="card-action">
                    <a href="/student_view">Click Here</a>
                </div>
            </div>
        </div>
        <div class="col s12 m7 l6">
            <div class="card small">
                <div class="card-image">
                    <img src="images/office.jpg">
                    <span class="card-title black-text" > <b>Old Assignment</b></span>
                </div>
                <div class="card-content">
                    <p>Check Your Progress On Old Assignment.</p>
                </div>
                <div class="card-action">
                    <a href="assignment_submitted">Click Here</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

    </div>
</div>

@endsection