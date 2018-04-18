
@extends('master_f')
@section('css_f')
	<style>
		body{
			background-image: url('images/light-red-NR.jpg');
			width: 100%;
			height: 100%;
			background-repeat: no-repeat;
			background-size: cover;
		}





	</style>
@stop
@section('title','f_view')

@section('body_f')
	<div class="container">
		<br><br><br>

		<ul id="slide-out" class="sidenav">

			<form action="/filter_v" method="post">
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<br>
				<a href="#"><b>Course:</b></a>
				<div style="font-size:35px;color: black;margin-left:13%;margin-right:13%;">
					<select name='f_course'>
						<option value="no_course_selected" disabled selected >Choose your course</option>
                        <?php
                        $check = \DB::table('teaches')->where('email_id',$_SESSION['email_id'])->pluck('course_id');
                        for($i=0;$i<count($check);$i++){
                        ?>
						<option value="{{$check[$i]}}">{{$check[$i]}}</option>
                        <?php } ?>
					</select>
				</div>
				<div style="margin-left:30%;color:gray;">
					<button class="btn">Go</button>
				</div>
			</form>

			</li>

		</form>



		</ul>
		<a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>




		<table class="centered responsive-table highlight">
			<tr>
				<td><b>COURSE </b></td>
				<td><b>ASSIGNMENT NAME</b></td>
				<td><b>DEADLINE</b></td>
				<td><b>URL</b></td>
			</tr>
			@foreach($res as $user)
				<tr>
					<td>{{$user->course_id}}</td>
					<td>{{$user->ass_name}}</td>
					<td>{{ date('F d, Y', strtotime($user->deadline)) }}</td>

                    <?php
                    $url=\DB::table('ftp_data')->where('email_id','a@b')->pluck('username');

                    $assignment=\DB::table('assignment')->where('ass_id',$user->ass_id)->pluck('assignment_url');
                    ?>

					<td><a href="http://web.iiitdmj.ac.in/~{{$url[0]}}/{{$assignment[0]}}/{{$user->filename}}"> {{$user->filename}}</a></td>

				</tr>
			@endforeach

		</table>
@stop


@section('script')

<script>


    $(document).ready(function(){
        $('.sidenav').sidenav();
        $('select').formSelect();
    });
	</script>

@stop

