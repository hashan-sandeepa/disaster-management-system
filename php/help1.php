<?php
include("../db/dbConfig.php");
session_start();
?>
<html>
<head>
    <title>Hazard360 | DISASTER REGION</title>
    <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="../resources/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../resources/css/style.css">
    <script src="../resources/js/jquery.min.js"></script>
    <script src="../resources/js/bootstrap.min.js"></script>
</head>
<body>
<div class="row" style="width: 100%">
    <div class="col-sm-10"><p style="padding:10px;font-size: 25px;margin-bottom: 0px;"><b>Hazard360 | DISASTER REGION</b></p></div>
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
<center>
    <h1>STORM</h1>
    <p>XXXXXXXXXX bjd bjdb fbmd mf mdmdfmd fdm </p>
    <p>XXXXXXXXXX bjd bjdb fbmd mf mdmdfmd fdm </p>
    <p>XXXXXXXXXX bjd bjdb fbmd mf mdmdfmd fdm </p>
    <p>XXXXXXXXXX bjd bjdb fbmd mf mdmdfmd fdm </p>
    <p>XXXXXXXXXX bjd bjdb fbmd mf mdmdfmd fdm </p>
    <p>XXXXXXXXXX bjd bjdb fbmd mf mdmdfmd fdm </p>
    <p>XXXXXXXXXX bjd bjdb fbmd mf mdmdfmd fdm </p>
    <p>XXXXXXXXXX bjd bjdb fbmd mf mdmdfmd fdm </p>
    <p>XXXXXXXXXX bjd bjdb fbmd mf mdmdfmd fdm </p>
    <p>XXXXXXXXXX bjd bjdb fbmd mf mdmdfmd fdm </p>
    <h1>STORM</h1>
    <p>XXXXXXXXXX bjd bjdb fbmd mf mdmdfmd fdm </p>
    <p>XXXXXXXXXX bjd bjdb fbmd mf mdmdfmd fdm </p>
    <p>XXXXXXXXXX bjd bjdb fbmd mf mdmdfmd fdm </p>
    <p>XXXXXXXXXX bjd bjdb fbmd mf mdmdfmd fdm </p>
    <p>XXXXXXXXXX bjd bjdb fbmd mf mdmdfmd fdm </p>
    <p>XXXXXXXXXX bjd bjdb fbmd mf mdmdfmd fdm </p>
    <p>XXXXXXXXXX bjd bjdb fbmd mf mdmdfmd fdm </p>
    <p>XXXXXXXXXX bjd bjdb fbmd mf mdmdfmd fdm </p>
    <p>XXXXXXXXXX bjd bjdb fbmd mf mdmdfmd fdm </p>
    <p>XXXXXXXXXX bjd bjdb fbmd mf mdmdfmd fdm </p>
</center>
</body>
</html>