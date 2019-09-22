<?php
require("config.php");
$mysqli = fDoc_con();

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

// Perform queries
mysqli_select_db($mysqli, "flatteredDoc");

$decoded = getJson();

if (isset($decoded['uId']) && isset($decoded['umId'])) {
    $setRows = mysqli_query($mysqli, "SELECT count(a_id) as 'is_true' FROM `UmfrageAns` WHERE `u_id` = " . $decoded['uId'] . " and `um_id` = " . $decoded['umId']);

    var_dump($decoded['uId']);

    if (mysqli_num_rows($setRows) > 0) {
        $isSet = mysqli_fetch_assoc($setRows);
        echo $isSet['is_true'];
    }

}else {
    die('Nicht die richtigen Daten übermittelt');
}
