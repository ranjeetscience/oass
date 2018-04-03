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
                    <img src="images/office.jpg">
                    <span class="card-title">New Assignment</span>
                </div>
                <div class="card-content">
                    <p>I am a very simple card. I am good at containing small bits of information.
                        I am convenient because I require little markup to use effectively.</p>
                </div>
                <div class="card-action">
                    <a href="/student_view">This is a link</a>
                </div>
            </div>
        </div>
        <div class="col s12 m7 l6">
            <div class="card small">
                <div class="card-image">
                    <img src="images/office.jpg">
                    <span class="card-title">Old Assignment</span>
                </div>
                <div class="card-content">
                    <p>I am a very simple card. I am good at containing small bits of information.
                        I am convenient because I require little markup to use effectively.</p>
                </div>
                <div class="card-action">
                    <a href="assignment_submitted">This is a link</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

    </div>
</div>

@endsection