<?php
require("config.php");
$decoded = getJson();
$mysqli = fDoc_con();
mysqli_select_db($mysqli,"flatteredDoc");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$answers = $mysqli->prepare("DELETE FROM UmfrageAns WHERE um_id=?");
$answers->bind_param("i", $decoded['id']);
$answers->execute();

$answersText = $mysqli->prepare("DELETE FROM UmfrageAnsText WHERE um_id=?");
$answersText->bind_param("i", $decoded['id']);
$answersText->execute();

$answersOptions = $mysqli->prepare("DELETE FROM UmfrageAnsOption WHERE um_id=?");
$answersOptions->bind_param("i", $decoded['id']);
$answersOptions->execute();

$questions = $mysqli->prepare("DELETE FROM UmfrageQuestions WHERE um_id=?");
$questions->bind_param("i", $decoded['id']);
$questions->execute();

$config = $mysqli->prepare("DELETE FROM UmfrageConfig WHERE id=?");
$config->bind_param("i", $decoded['id']);
$config->execute();