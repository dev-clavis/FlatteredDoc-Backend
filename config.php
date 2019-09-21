<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
function fDoc_con()
{
    return mysqli_connect("172.16.0.1", "hackathon", "hackathon", "flatteredDoc");
}

function getJson()
{
    if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0) {
        throw new Exception('Request method must be POST!');
    }

    //Make sure that the content type of the POST request has been set to application/json
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    if (strcasecmp($contentType, 'application/json') != 0) {
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
