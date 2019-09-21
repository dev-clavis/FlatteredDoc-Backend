<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require("config.php");
$decoded = getJson();
$mysqli = fDoc_con();
mysqli_select_db($mysqli,"flatteredDoc");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

if (!isset($decoded['id'])) {

    $config = $mysqli->prepare("INSERT INTO UmfrageConfig (name, author) VALUES (?, ?)");
    $config->bind_param("ss", $decoded['name'], $decoded['author']);
    $config->execute();

    $id = mysqli_insert_id($mysqli);

    foreach ($decoded['questions'] as $question) {
        $db_question = $mysqli->prepare("INSERT INTO UmfrageQuestions (um_id, q_id,q_content, q_type) VALUES (?, ?, ?, ?)");
        $db_question->bind_param("iisi", $id, $question['qId'], $question['name'], $question['type']);
        $db_question->execute();
        foreach ($question['ans'] as $answer) {
            $db_answer = $mysqli->prepare("INSERT INTO UmfrageAnsOption (um_id, q_id, a_id, content) VALUES (?, ?, ?, ?)");
            $db_answer->bind_param("iiis", $id, $question['qId'], $answer['optionId'], $answer['optionName']);
            $db_answer->execute();
        }
    }

    echo JsonId($id);
} elseif ($decoded['id']) {

    $config = $mysqli->prepare("UPDATE UmfrageConfig SET name=?, author=? WHERE id=? ");
    $config->bind_param("ssi", $decoded['name'], $decoded['author'], $decoded['id']);
    $config->execute();

    $id = mysqli_insert_id($mysqli);

    foreach ($decoded['questions'] as $question) {
        $db_question = $mysqli->prepare("UPDATE UmfrageQuestions SET q_id=?, q_content=?, q_type=? WHERE um_id=?");
        $db_question->bind_param("isii",$question['qId'], $question['name'], $question['type'], $decoded['id']);
        $db_question->execute();
        foreach ($question['ans'] as $answer) {
            $db_answer = $mysqli->prepare("UPDATE UmfrageAnsOption SET content=? WHERE um_id=? AND q_id=? AND a_id=?");
            $db_answer->bind_param("siii", $answer['optionName'], $decoded['id'], $question['qId'], $answer['optionId']);
            $db_answer->execute();
        }
    }
}