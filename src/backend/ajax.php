<?php

declare(strict_types=1);

use Monolog\Level as Level;
use Monolog\Logger as Logger;
use Monolog\Handler\StreamHandler as StreamHandler;
use Modules\Forum\Question\Question as Question;

session_start();

require "../../vendor/autoload.php";

include "functions/developerFunctions.php";
include "functions/forumFunctions.php";

$log = new Logger('name');
$log->pushHandler(new StreamHandler('../log.txt', Level::Warning));

$parameters = [];
try {
    $parameters = json_decode($_POST["parameters"], true, 512, JSON_THROW_ON_ERROR);
    unset($_POST["parameters"]);
} catch (JsonException $e) {
    $response = "An error has occured, please try again later";
    $log->error($e->getMessage());
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
        if (is_null($parameters["repeatPassword"])) {
            $response = "Parameter 'repeatPassword' is required";
            $valid = false;
        } else if ($parameters["password"] !== $parameters["repeatPassword"]) {
            $response = "Passwords must match";
            $valid = false;
        }

        if ($valid) {
            try {
                $result = registerDeveloper($parameters["name"], $parameters["email"], $parameters["password"], $parameters["nickname"]);
            } catch (Exception | TypeError $e) {
                switch ($e->getCode()) {
                    case "23000":
                        $response = "E-23000";
                        break;
                    default:
                    $log->error($e->getMessage());
                        $response = "An error has occured, please try again later";
                        break;
                }
                $log->error($e->getMessage());
            }
            $response = true;
        }
        break;
    case "developerLogin":
        if (is_null($parameters["email"])) {
            $response = "Parameter 'email' cannot be empty";
        } else if (is_null($parameters["password"])) {
            $response = "Parameter 'password' cannot be empty";
        } else {
            try {
                $response = login($parameters["email"], $parameters["password"]);
            } catch (Exception | TypeError $e) {
                switch ($e->getCode()) {
                    default:
                        $log->error($e->getMessage());
                        $response = "An error has occured, please try again later";
                        break;
                }
            }
        }
        break;
    case "getQuestionCount":
        $response = getQuestionCount();
        break;
    case "getQuestions":
        if (!is_null($parameters["offset"])) {
            if (!is_int($parameters["offset"])) {
                $response = "Parameter 'offset' must be an int";
            break;
            }
        } else {
            $response = "Parameter 'offset' cannot be empty";
            break;
        }

        if (!is_null($parameters["amount"])) {
            if (!is_int($parameters["amount"])) {
                $response = "Parameter 'amount' must be an int";
                break;
            }
        } else {
            $response = "Parameter 'amount' cannot be empty";
            break;
        }

        $questions = getQuestions($parameters["offset"], $parameters["amount"]);
        $response = [];
        foreach ($questions as $questionArray) {
            $data = [];
            $data["ID"] = $questionArray["idQuestion"];
            $data["vraag"] = $questionArray["vraag"];

            $question = new Question($data["ID"]);
            $data["answerCount"] = count($question->getAnswers());
            $response[] = $data;
        }
        break;
    default:
        $response = "No such function available";
        break;
}
try {
    echo json_encode($response, JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
    $response = "An error has occured, please try again later";
    $log->error($e->getMessage());
}
