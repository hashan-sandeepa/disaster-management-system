<?php
include("../db/dbConfig.php");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $get_region_sql = "SELECT latitude,longitude,title from disaster_info WHERE status=(SELECT id from status WHERE name='OPENED')";
    $result = mysqli_query($db, $get_region_sql);

    while ($row = mysqli_fetch_row($result)) {
        $region_data[] = array("latitude" => $row[0], "longitude" => $row[1], "title" => $row[2]);
    }
    if (isset($region_data)) {
        echo json_encode($region_data);
    } else {
        echo '[]';
    }
}
?>