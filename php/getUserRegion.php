<?php
include("../db/dbConfig.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $logged_user = $_SESSION['login_user'];

    $get_user_sql = "SELECT id,user_name FROM user WHERE user_name = '$logged_user'";
    $result = mysqli_query($db, $get_user_sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $user_id=$row['id'];


    $isAdmin=$row['user_name']=='admin';
    if ($isAdmin){
        $regionSql = "SELECT id,title,latitude,longitude,description,status FROM disaster_info";
    }else{
        $regionSql = "SELECT id,title,latitude,longitude,description,status FROM disaster_info WHERE user = '$user_id'";
    }

    $result = mysqli_query($db, $regionSql);

    while ($row = mysqli_fetch_row($result)) {
        $user_region[] = array("id"=>$row[0],"title" => $row[1],"latitude" => $row[2], "longitude" => $row[3],"description" => $row[4], "isAdmin" =>$isAdmin, "status" => $row[5]);
    }
    if (isset($user_region)) {
        echo json_encode($user_region);
    } else {
        echo '[]';
    }
}
?>