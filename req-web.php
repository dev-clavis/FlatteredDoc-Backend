<?php
require("config.php");
header("Content-Type: application/json");

    $mysqli = fDoc_con();
    $surveys = array();
    /* check connection */
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    
    mysqli_select_db($mysqli,"flatteredDoc");
    
    $result_base = mysqli_query($mysqli, "SELECT * FROM `UmfrageConfig`;");

    if (mysqli_num_rows($result_base) > 0) {
        while ($row = mysqli_fetch_assoc($result_base)) {
           $surveys[] = $row;
        }
    } else {
        die();
    }
    mysqli_free_result($result_base);
    echo json_encode($surveys);

    mysqli_close($mysqli);
