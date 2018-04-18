
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
@section('title','view_doc')

@section('body_f')
<div class="container">
<br><br><br>



	<ul id="slide-out" class="sidenav">

		<form action="/filter_e" method="post">
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
		<td><b>ROLL NO</b></td>
		<td><b>NAME </b></td>
		<td><b>COURSE </b></td>
		<td><b> File </b></td>
		<td><b>MARKS</b></td>
	</tr>


	<form class="col s7" action="/update_marks" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type='hidden' name="_token" value="{{csrf_token()}}">

			 	@foreach($res as $user)
				<?php

					//student detail 
					$st = \DB::table('student')->where('email_id',$user->email_id)->get();
					$assignment= \DB::table('assignment')->where('ass_id',$user->ass_id)->get();
					//print_r($assignment[0]) ;
					//echo $assignment;
					//for accessing course_id
				?>
					<input type='hidden' name="ass_id" value="{{$user->ass_id}}">
					<input type='hidden' name="course_id" value="{{$assignment[0]->course_id}}">
					<tr>
					<td><?php echo $st[0]->roll_no ?> </td>
					<td><?php echo $st[0]->name ?> </td>
					<td><?php echo $assignment[0]->course_id ?> </td>	<!---write course id-->
					<td><a href="http://web.iiitdmj.ac.in/~lalitkumar/submitted/{{$user->original_filename}}"><?php echo $user->original_filename ?> </a>	<!---write course id-->
			   		<td><input required="true" type="number" name="{{$user->email_id}}{{$user->ass_id}}" min="0" placeholder="Marks" style="height:35px; width:60px">
					</td>
				</tr>
				@endforeach
		<tr>
			<td> </td>
			<td> </td>
			<td> </td>
			<td></td>

			<td><button class="btn" name="submit" type="submit">Submit</button></td>
		</tr>
	</form>

</table>

@stop

	@section('script')

		<script type="text/javascript">

            $(document).ready(function(){
                $('select').formSelect();
                $('.sidenav').sidenav();
            });

		</script>

		<script type="text/javascript">
            //for drop down

            $('.dropdown-trigger').dropdown();

		</script>

@stop
