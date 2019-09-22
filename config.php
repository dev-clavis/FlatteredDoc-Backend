<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json; charset=utf-8");
function fDoc_con()
{
    $mysqli = mysqli_connect("172.16.0.1", "hackathon", "hackathon", "flatteredDoc");

    if (!$mysqli->set_charset("utf8")) {
        printf("Error loading character set utf8: %s\n", $mysqli->error);
        exit();
    } else {
    }
    return $mysqli;
}

function getJson()
{
    if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0) {
        throw new Exception('Request method must be POST!');
    }

    //Make sure that the content type of the POST request has been set to application/json
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    if (strpos($contentType, 'application/json') === false) {
        var_dump($_SERVER);
        throw new Exception('Content type must be: application/json');
    }

    //Receive the RAW post data.
    $content = trim(file_get_contents("php://input"));

    //Attempt to decode the incoming RAW post data from JSON.
    $json = json_decode($content, true);
    if (!is_array($json)) {
        throw new Exception('Received content contained invalid JSON!');
    }
    return $json;
}


function JsonError($msg)
{
    $obj = array(
        "error" => $msg
    );
    die(json_encode($obj));
    return;
}

function JsonId($pid)
{
    $obj = array(
        "id" => $pid
    );
    die(json_encode($obj));
    return;
}
