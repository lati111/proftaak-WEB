<?php

declare(strict_types=1);
session_start();

include "functions/developerFunctions.php";

$parameters = [];
try {
    $parameters = json_decode($_POST["parameters"], true, 512, JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
}

$response = "";
switch ($_POST["function"]) {
    case "registerDeveloper":
        $valid = true;
        if (!is_null($parameters["name"])) {
            if (!preg_match('/^[a-zA-Z ]+$/', $parameters["name"])) {
                $response = "Parameter 'name' may not contain numbers or special characters";
                $valid = false;
            }
        } else {
            $response = "Parameter 'name' is required";
        }
        if (!is_null($parameters["email"])) {
            if (!preg_match('/^[a-zA-Z0-9.!#$%&\'*+\/=?^_\`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/', $parameters["email"],)) {
                $response = "Parameter 'email' is not valid";
                $valid = false;
            }
        } else {
            $response = "Parameter 'email' is required";
            $valid = false;
        }
        if (is_null($parameters["password"])) {
            $response = "Parameter 'password' is required";
            $valid = false;
        }

        if ($valid) {
            $result = registerDeveloper($parameters["name"], $parameters["email"], $parameters["password"], $parameters["nickname"]);
        }

        break;
    default:
        $response = "No such function available";
        break;
}
try {
    echo json_encode($response, JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
}
