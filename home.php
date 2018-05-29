<?php
include("db/dbConfig.php");
$msg = "";
$_SESSION['login_user'] = null;
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['action'] == 'signin') {
        $username = mysqli_real_escape_string($db, $_POST['userName']);
        $password = mysqli_real_escape_string($db, $_POST['password']);

        $sql = "SELECT id FROM user WHERE user_name = '$username' and password = '$password'";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $count = mysqli_num_rows($result);

        if ($count == 1) {
            $_SESSION['login_user'] = $username;
        } else {
            $_SESSION['login_user'] = null;
            $msg = '<div class="alert alert-danger my-alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Your Username or Password is invalid</div>';
        }
    } else if ($_POST['action'] == 'signup') {
        $name = mysqli_real_escape_string($db, $_POST['name']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $username = mysqli_real_escape_string($db, $_POST['userName']);
        $password = mysqli_real_escape_string($db, $_POST['password']);

        $searchSql = "SELECT id FROM user WHERE user_name = '$username'";
        $result = mysqli_query($db, $searchSql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $count = mysqli_num_rows($result);

        if ($count != 1) {
            $searchEmailSql = "SELECT id FROM user WHERE email = '$email'";
            $resultEmail = mysqli_query($db, $searchEmailSql);
            $rowEmail = mysqli_fetch_array($resultEmail, MYSQLI_ASSOC);

            $countEmail = mysqli_num_rows($resultEmail);

            if ($countEmail != 1) {
                $sql = "INSERT INTO user Values(null,'$name','$username','user','$email','$password')";
                if (mysqli_query($db, $sql) === TRUE) {
                    $msg = '<div class="alert alert-success my-alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Your account has been created successfully</div>';
                } else {
                    $msg = '<div class="alert alert-danger my-alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Your Account creation failed!</div>';
                }
            } else {
                $msg = '<div class="alert alert-warning my-alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Email is already exist!</div>';
            }
        } else {
            $msg = '<div class="alert alert-warning my-alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Username is already exist!</div>';
        }
    } else if ($_POST['action'] == 'update-region') {
        $title = mysqli_real_escape_string($db, $_POST['title']);
        $longitude = mysqli_real_escape_string($db, $_POST['longitude']);
        $latitude = mysqli_real_escape_string($db, $_POST['latitude']);
        $description = mysqli_real_escape_string($db, $_POST['description']);
        $logged_user = $_SESSION['login_user'];

        if (isset($logged_user) && !empty($logged_user)) {
            $get_user_sql = "SELECT id FROM user WHERE user_name = '$logged_user'";
            $result = mysqli_query($db, $get_user_sql);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $user_id=$row['id'];

            $sql = "INSERT INTO disaster_info Values(null,'$title','$longitude','$latitude','$description',$user_id,(SELECT id from status WHERE name='PENDING'))";
            if (mysqli_query($db, $sql) === TRUE) {
                $msg = '<div class="alert alert-success my-alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Disaster Region has been updated!</div>';
            } else {
                $msg = '<div class="alert alert-danger my-alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Failure when updating Region!</div>';
            }
        } else {
            $msg = '<div class="alert alert-warning my-alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>User not logged In!</div>';
        }
    }
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['signout']) && $_GET['signout'] == 1) {
        session_destroy();
        $_SESSION['login_user']=null;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Hazard360 | DISASTER REGION</title>
    <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="resources/css/style.css">
    <script src="resources/js/jquery.min.js"></script>
    <script src="resources/js/bootstrap.min.js"></script>
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
    <?php if (!empty($_SESSION['login_user'])) {
        echo '<li class="active"><a href="home.php">HOME</a></li>
               <li><a data-toggle="modal" data-target="#updateModal" href="#update">UPDATE</a></li>
               <li><a data-toggle="modal" data-target="#regionModal" href="#contact">REGION</a></li>
               <li style="float:right"><a href="home.php?signout=1">SIGN OUT</a></li>';
    }else{
        echo '<li style="float:right"><a href="javascript:$(\'#loginModal\').modal(\'show\');">SIGN IN</a></li>';
    } ?>
    <li style="float:right"><a href="php/about-us.php">ABOUT US</a></li>
    <li style="float:right"><a href="php/help.php">HELP</a></li>
</ul>
<div class="form-group" style="margin-bottom: 0px">
    <div class="col-sm-12" style="padding: 0px">
        <?php echo $msg; ?>
    </div>
</div>
<div id="map"></div>

<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" style="width: 500px;top: 100px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
                <h4 class="modal-title" id="loginModalLabel">
                    Sign In/Sign up</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#Login" data-toggle="tab">Sign In</a></li>
                            <li><a href="#Registration" data-toggle="tab">Sign up</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content" style="padding: 10px">
                            <div class="tab-pane active" id="Login">
                                <form role="form" method="post" action="home.php" class="form-horizontal">
                                    <input type="hidden" name="action" value="signin">
                                    <div class="form-group">
                                        <label for="email" class="col-sm-3 control-label">
                                            User Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="userName" class="form-control" id="userName1"
                                                   placeholder="User Name"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1" class="col-sm-3 control-label">
                                            Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" name="password" class="form-control" id="password1"
                                                   placeholder="Password"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                        </div>
                                        <div class="col-sm-9">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                Submit
                                            </button>
                                            <a style="margin-left: 5px" href="javascript:;">Forgot your password?</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="Registration">
                                <form role="form" method="post" action="home.php" class="form-horizontal">
                                    <input type="hidden" name="action" value="signup">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-3 control-label">
                                            Name</label>
                                        <div class="col-md-9">
                                            <input type="text" name="name" class="form-control" placeholder="Name"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-sm-3 control-label">
                                            Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" name="email" class="form-control" id="email"
                                                   placeholder="Email"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile" class="col-sm-3 control-label">
                                            User Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="userName" id="userName"
                                                   placeholder="User Name"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="col-sm-3 control-label">
                                            Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" name="password" id="password"
                                                   placeholder="Password"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                        </div>
                                        <div class="col-sm-9">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                Create My Account
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="updateModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Region</h4>
            </div>
            <div class="modal-body">
                <div id="map-canvas"></div>
                <br>
                <form role="form" method="post" action="home.php" class="form-horizontal">
                    <input type="hidden" name="action" value="update-region">
                    <input type="hidden" id="longitude" name="longitude" value="">
                    <input type="hidden" id="latitude" name="latitude" value="">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" placeholder="Title" class="form-control" name="title"></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <textarea placeholder="Description" class="form-control" rows="5" name="description"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<div id="regionModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Region</h4>
            </div>
            <div class="modal-body" id="user_maps">

            </div>
        </div>

    </div>
</div>
<script type="text/javascript" src="resources/js/script.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRmMhbgxA5yheCsNx7h3UePytrh66Pwds&callback=initMap"></script>
</body>
</html>