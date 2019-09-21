<?php
require("config.php");
$json = getJson();

//If json_decode failed, the JSON is invalid.



var_dump($json);

if (!isset($json['uId']) || !isset($json['umId']) || !isset($json['qId'])) {
    die();
}
$mysqli = fDoc_con();
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
mysqli_select_db($mysqli, "flatteredDoc");

if (isset($json['aId'])) {

    $db_answer = $mysqli->prepare("insert into UmfrageAns (`u_id`,`um_id`,`q_id`,`a_id`) VALUES (?,?,?,?);");
    $db_answer->bind_param("siii", $json['uId'], $json['umId'], $json['qId'], $json['aId']);
    if (!$db_answer->execute()) {
        JsonError("Schon beantwortet!");
    };



    mysqli_close($mysqli);
} else if (isset($json['value'])) {
    $db_answer = $mysqli->prepare("insert into UmfrageAnsText (`u_id`,`um_id`,`q_id`,`content`) VALUES (?,?,?,?);");
    $db_answer->bind_param("siii", $json['uId'], $json['umId'], $json['qId'], $json['value']);
    if (!$db_answer->execute()) {
        JsonError("Schon beantwortet!");
    };
    mysqli_close($mysqli);
} else {
    mysqli_close($mysqli);
    die();
}
