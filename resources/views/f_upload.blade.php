
@extends('master_f')
@section('title','uploaddoc')
@section('css_f')
<style>

body{
  background-image: url('/images/a.jpg');
  width: 100%;
  height: 100%;
  background-repeat: no-repeat;
  background-size: cover;
}


</style>
@stop
@section('body_f')

<center>

    <div class="container">
        <form class="col s7" action="/submitted" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type='hidden' name="_token" value="{{csrf_token()}}">
            <input type='hidden' name="course" value='<?php echo $id?>'>
                <div class="form">
                    <br><br><br>
                    <div class="row">
                        <div class="col s3 "><br/>
                            <input type="text" style="border-style:groove; border-radius:10px;background-color:white;padding:5px;" placeholder="Write topic ..." name="ass_name" required="true">
                        </div>
                        
                         
                    <div class="row">
                        <div class="col s3 offset-s3"><br/>
                           <input type="text" class="datepicker" required="true" name="deadline" placeholder="Enter Deadline">

                        </div>   
                    </div>

                    </div>

                    <br/>

                    <div class="row">
                        <div class="col s3 "><br/>
                            <input type="text" style="border-style:groove; border-radius:10px;background-color:white;padding:5px;" placeholder="Assignment URL ..." name="assignment_url" required="true">
                        </div>


                        <div class="row">
                            <div class="col s3 "><br/>
                                <input type="text" style="border-style:groove; border-radius:10px;background-color:white;padding:5px;" placeholder="Submission URL ..." name="submission_url" required="true">
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="file-field input-field">
                            <div class="btn">
                                <span>File</span>
                                <input type="file" name="filename">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type = "text" placeholder="Upload" required="true">
                            </div>
                        </div>
                        <button class="btn" name="submit" type="submit">Submit</button>


                    </div>
                </div>
        </form>
</div>


</center>

@stop

@section('script')
<script type="text/javascript">
 
 $(document).ready(function(){
    $('.datepicker').datepicker(
      {
        format: 'd/mm/yyyy'
      });
  });
          
</script>

@stop