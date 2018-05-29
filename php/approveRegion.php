<?php
include("../db/dbConfig.php");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = mysqli_real_escape_string($db, $_GET['id']);

    $approve_region_sql = "UPDATE disaster_info SET status=(SELECT id from status WHERE name='OPENED') WHERE id='$id'";
    $result = mysqli_query($db, $approve_region_sql);

    header("location:../home.php");
}
?>