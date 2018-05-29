<?php
include("../db/dbConfig.php");
session_start();
?>
<html>
<head>
    <title>Hazard360</title>
    <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="../resources/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../resources/css/style.css">
    <script src="../resources/js/jquery.min.js"></script>
    <script src="../resources/js/bootstrap.min.js"></script>
</head>
<body>
<div class="row" style="width: 100%">
    <div class="col-sm-10"><p style="padding:10px;font-size: 25px;margin-bottom: 0px;"><b>Hazard360</b></p></div>
    <div class="col-sm-2" style="padding-right: 0px"><?php $logged_user = isset($_SESSION['login_user'])?$_SESSION['login_user']:'';
        if (!empty($logged_user)) {
            $ses_sql = mysqli_query($db, "select name from user where user_name = '$logged_user' ");
            $row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);
            $logged_name = $row['name'];
            echo '<p style="padding:18px;padding-right: 0px;font-size: 15px;margin-bottom: 0px;float: right;"><b>Welcome '.$logged_name.'!</b></p>';
        }
        ?></div>
</div>
<ul id="nav">
    <?php
    if (!empty($_SESSION['login_user'])) {
        echo '<li><a href="../home.php">HOME</a></li>
        <li style="float:right"><a href="../home.php?signout=1">SIGN OUT</a></li>';
    }else{
        echo '<li style="float:right"><a href="javascript:$(\'#loginModal\').modal(\'show\');">SIGN IN</a></li>';
    }
    ?>
    <li style="float:right"><a href="about-us.php">ABOUT US</a></li>
    <li class="active" style="float:right"><a href="help.php">HELP</a></li>
</ul>


    <table id="t02">
	<tr> 
	  <th style="text-align:center"><font size="5">STORM</font></th>
	  </tr>
    <tr>  
		<td>A thunderstorm is a type of storm that generates
	lightning and the attendant thunder. It is normally accompanied by
	heavy precipitation. ... These storms occur when high levels
	of condensation form in a volume of unstable air that generates deep,
	rapid, upward motion in the atmosphere.</td>

</tr>
  <tr>  <th><font size="5">Earthquake</font></th>  </tr>
  <tr>  <td>An earthquake (or quakes, tremors) is shaking of the surface
ofearth, caused by sudden movement in the Earth's crust. They can be
extremely violent or cannot be felt by anyone. Earthquakes are usually
quite brief, but may repeat. They are the result of a sudden release
of energy in the Earth's crust.</td>
  </tr>

  <tr>  <th><font size="5">Floods</font></th>  </tr>
  <tr>  <td>A flood is an overflow of water that submerges land that is usually dry.
The European Union (EU) Floods Directive defines a flood as a covering by water of
land not normally covered by water. In the sense of "flowing water",
the word may also be applied to the inflow of the tide.</td>
  </tr>

  <tr>  <th><font size="5">Landslides</font></th>  </tr>
  <tr>  <td>When earthquakes occur on areas with steep slopes, many times
the soil slips causing landslides. Furthermore, ashen debris flows caused by
earthquakes can also trigger mass movement of soil. Heavy Rainfall: When sloped areas become
completely saturated by heavy rainfall many times landslides can occur</td>
  </tr>

  <tr>  <th><font size="5">Fires</font></th>  </tr>
  <tr>  <td>The dominant color in a flame changes with temperature.
The photo of the forest fire in Canada is an excellent example of this
variation. Near the ground, where most burning is occurring, the fire is white,
the hottest color possible for organic material in general, or yellow. Above the
yellow region, the color changes to orange</td>
  </tr>

  <tr>  <th><font size="5">Road Accidents</font></th>  </tr>
  <tr>  <td>Accident is an undesired or unintended happening.
	Inevitable accident falls within the concept of ACT OF GOD OR
	DAMNUM FATALE OR AN Unfortunate harmful event, event without
	apparent cause unexpected occurring.</td>
  </tr>
</body>
</html>
