<?php
require("config.php");
$mysqli = fDoc_con();

if(!isset($_GET['id']))
{
    die("No ID.");
}

$id = $_GET['id'];
mysqli_select_db($mysqli,"flatteredDoc");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$answers = $mysqli->prepare("DELETE FROM UmfrageAns WHERE um_id=?");
$answers->bind_param("i", $id);
$answers->execute();

$answersText = $mysqli->prepare("DELETE FROM UmfrageAnsText WHERE um_id=?");
$answersText->bind_param("i", $id);
$answersText->execute();

$answersOptions = $mysqli->prepare("DELETE FROM UmfrageAnsOption WHERE um_id=?");
$answersOptions->bind_param("i", $id);
$answersOptions->execute();

$questions = $mysqli->prepare("DELETE FROM UmfrageQuestions WHERE um_id=?");
$questions->bind_param("i", $id);
$questions->execute();

$config = $mysqli->prepare("DELETE FROM UmfrageConfig WHERE id=?");
$config->bind_param("i", $id);
$config->execute();