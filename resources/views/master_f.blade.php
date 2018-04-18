<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>@yield('title')</title>

<!--STYLESHEETS-->


<!--SCRIPTS-->

<!--Slider-in icons-->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="/materialize/css/materialize.css"  media="screen,projection"/>


@yield('css_f')
<style media="screen">

nav
{
  background:rgba(7,99,146,1);
}

</style>
</head>
<body>
<!--Navbar-->
  <nav>
    <div class="nav-wrapper">
      <a href="/faculty" class="brand-logo">OASS</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="/faculty">Upload</a></li>
        <li><a href="/f_view">View</a></li>
        <li><a href="/f_result">Evaluate</a></li>
        <li><a href="/logout"> Logout </a> </li>
      </ul>
    </div>
  </nav>
    @yield('body_f')
    @yield('footer_f')

</body>

 <script src="/materialize/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="/materialize/js/materialize.js"></script>
<script type="text/javascript" src="/materialize/js/materialize.min.js"></script>
 

 <!--  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script src="/js/materialize.js"></script>
  <script src="/js/init.js"></script>
 <!--  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  --> 
 

@yield('script')

</html>
