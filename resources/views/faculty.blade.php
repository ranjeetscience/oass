@extends('master_f')

@section('title','faculty')
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
    @if($alert = Session::get('alert'))
        <script type="text/javascript">alert("{{$alert}}");</script>
    @endif

<div class="container ">
<div class="row " style="padding-top:100px">
<div><h4 class="center-align">Select </h4></div>

        <form class="col s12" action="/f_upload" method="post">

          {{csrf_field()}}
            <input type='hidden' name="_token" value="{{csrf_token()}}">
        
              <div class="row">
                <div class="col l5 m6" style="margin-left:30%" >
                    <select name="f_course" required="true">
                        <option value="" disabled selected >Choose your course</option>
                        <?php
                        $check = \DB::table('teaches')->where('email_id','lalitkumar@iiitdmj.ac.in')->pluck('course_id');
                        for($i=0;$i<count($check);$i++){
                        ?>
                        <option value="{{$check[$i]}}">{{$check[$i]}} </option>
                        <?php } ?>
                    </select>
                    <label>Status</label>
                </div>
              </div>
            
              <br><br>
              <div class="col l5 m6" style="margin-left:45%">
                  <button class="btn" name="submit" type="submit">Submit</button>
          </div>

        </form>
  </div>


 </div>
 

@stop

@section('script')

    <script>


        $(document).ready(function(){
            $('select').formSelect();
        });
    </script>

@stop