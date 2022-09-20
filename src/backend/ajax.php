<?php
session_start();



try {
    $parameters = json_decode($_POST["parameters"], true, 512, JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
}

$response;
switch ($_POST["function"]) {
    default:
    $response = "No such function available";
        break;
}
try {
    echo json_encode($response, JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
}
