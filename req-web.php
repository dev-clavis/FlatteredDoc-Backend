<?php
require("config.php");
$mysqli = fDoc_con();
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

// Perform queries
mysqli_select_db($mysqli, "flatteredDoc");

$result_info = mysqli_query($mysqli, "SELECT id FROM `UmfrageConfig`;");
$ums = array();
if (mysqli_num_rows($result_info) > 0) {
    while ($um = mysqli_fetch_array($result_info, MYSQLI_NUM)) {
        $ums[] = $um[0];
    }
} else {
    die();
}
mysqli_free_result($result_info);

$svs  = array();

foreach ($ums as $i) {


    $survey = array("name" => "", "author" => "", "id" => $i);
    $questions =  array();


    //Select name,author
    $result_base = mysqli_query($mysqli, "SELECT name, author FROM `UmfrageConfig` WHERE `id` = " . $survey['id'] . ";");

    if (mysqli_num_rows($result_base) > 0) {
        while ($row = mysqli_fetch_assoc($result_base)) {
            $survey['name'] = $row['name'];
            $survey['author'] = $row['author'];
        }
    } else {
        //die();
    }
    mysqli_free_result($result_base);
    $result_questions = mysqli_query($mysqli, "SELECT q_id, q_content, q_type  FROM `UmfrageQuestions` WHERE `um_id` = " . $survey['id'] . ";");
    if (mysqli_num_rows($result_questions) > 0) {
        while ($row = mysqli_fetch_assoc($result_questions)) {
            $questions[$row['q_id']] = array(
                "qId" => $row['q_id'],
                "name" => $row['q_content'],
                "type" => $row['q_type']
            );
        }
    } else {
        
    }
    mysqli_free_result($result_questions);

    $result_answers = mysqli_query($mysqli, "SELECT q_id, a_id, content  FROM `UmfrageAnsOption` WHERE `um_id` = " . $survey['id'] . ";");
    if (mysqli_num_rows($result_answers) > 0) {
        while ($row = mysqli_fetch_assoc($result_answers)) {

            $a = array(
                "optionId" => $row['a_id'],
                "optionName" => $row['content']
            );
            $questions[$row['q_id']]['ans'][] = $a;
        }
    } else {
        
    }
    mysqli_free_result($result_answers);
    $survey[] = $questions;
    $svs[] = $survey;
    
}
//var_dump($svs);
echo json_encode($svs);
 mysqli_close($mysqli);