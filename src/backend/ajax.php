<?php

declare(strict_types=1);

use Monolog\Level as Level;
use Monolog\Logger as Logger;
use Modules\Developer\Developer;
use Monolog\Handler\StreamHandler as StreamHandler;
use Modules\Forum\QuestionHandler as QuestionHandler;
use Modules\Forum\Question as Question;
use Modules\Forum\Answer;


session_start();

require "../../vendor/autoload.php";

include "functions/authenticate.php";

$log = new Logger('AJAX');
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
            } catch (Exception | TypeError | Error $e) {
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
            } catch (Exception | TypeError | Error $e) {
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
        try {
            $questionHandler = new QuestionHandler();
            $response = $questionHandler->getQuestionCount();
        } catch (Exception | TypeError | Error $e) {
            $response = "An error has occured, please try again later";
            $log->error($e->getMessage());
        }
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

        try {
            $questionHandler = new QuestionHandler();
            $questions = $questionHandler->getQuestions($parameters["offset"], $parameters["amount"]);
        } catch (Exception | TypeError $e) {
            $response = "An error has occured, please try again later";
            $log->error($e->getMessage());
        }
        $response = [];
        foreach ($questions as $questionArray) {
            $data = [];
            $data["ID"] = $questionArray["idQuestion"];
            $data["vraag"] = $questionArray["vraag"];

            try {
                $question = new Question($data["ID"]);
            } catch (Exception | TypeError | Error $e) {
                switch ($e->getCode()) {
                    case 1:
                        $response = $e->getMessage();
                        $log->warning("user searched for answer with ID" . $data["ID"] . ", no answer with that ID found");
                    default:
                        $response = "An error has occured, please try again later";
                        $log->error($e->getMessage());
                        break;
                }   
            }
            try {
                $data["answerCount"] = count($question->getAnswers());
            } catch (Exception $e) {
                $response = "An error has occured, please try again later";
                $log->error($e->getMessage());
            }
            $response[] = $data;
        }
        break;

    case "getAnswers":
        if (!is_null($parameters["offset"])) {
            if (!is_int($parameters["offset"])) {
                $response = "Parameter 'offset' must be an int";
                break;
            } else if ($parameters["offset"] === 0) {
                $parameters["offset"] = 1;
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

        if (!is_null($parameters["questionID"])) {
            if (!is_int($parameters["questionID"])) {
                $response = "Parameter 'questionID' must be an int";
                break;
            }
        } else {
            $response = "Parameter 'questionID' cannot be empty";
            break;
        }

        try {
            $response = [];
            $question = new Question($parameters["questionID"]);
            $answers = $question->getAnswers($parameters["offset"], $parameters["amount"]);

                    
            foreach ($answers as $answerData) {
                $data = [];
                $data["ID"] = $answerData["idAnswer"];
                $data["antwoord"] = $answerData["antwoord"];
                $data["votes"] = $answerData["votes"];

                $answer = new Answer($answerData["idAnswer"], $question);
                if(isset($_SESSION["userID"])) {
                    $developer = new Developer($_SESSION["userID"]);
                    if ($answer->HasVoted($developer)) {
                        $data["hasVoted"] = true;
                    } else {
                        $data["hasVoted"] = false;
                    }
                } else {
                    $data["hasVoted"] = false;
                }

                $response[] = $data;
            }
        } catch (Exception | TypeError | Error $e) {
            switch ($e->getCode()) {
                case 1:
                    $response = $e->getMessage();
                    $log->warning("user searched for question with ID " . $data["ID"] . ", no question with that ID found");
                    break;
                default:
                    $response = "An error has occured, please try again later";
                    $log->error($e->getMessage());
                    break;
            }
        }
        break;
    case "getBestAnswer":
        if (!is_null($parameters["questionID"])) {
            if (!is_int($parameters["questionID"])) {
                $response = "Parameter 'questionID' must be an int";
                break;
            }
        } else {
            $response = "Parameter 'questionID' cannot be empty";
            break;
        }

        try {
            $response = [];
            $question = new Question($parameters["questionID"]);
            $answers = $question->getAnswers(0, 1);


            foreach ($answers as $answerData) {
                $data = [];
                $data["ID"] = $answerData["idAnswer"];
                $data["antwoord"] = $answerData["antwoord"];
                $data["votes"] = $answerData["votes"];

                $answer = new Answer($answerData["idAnswer"], $question);
                if (isset($_SESSION["userID"])) {
                    $developer = new Developer($_SESSION["userID"]);
                    if ($answer->HasVoted($developer)) {
                        $data["hasVoted"] = true;
                    } else {
                        $data["hasVoted"] = false;
                    }
                } else {
                    $data["hasVoted"] = false;
                }

                $response = $data;
            }
        } catch (Exception | TypeError | Error $e) {
            switch ($e->getCode()) {
                case 1:
                    $response = $e->getMessage();
                    $log->warning("user searched for question with ID " . $data["ID"] . ", no question with that ID found");
                    break;
                default:
                    $response = "An error has occured, please try again later";
                    $log->error($e->getMessage());
                    break;
            }
        }
        break;
    case "vote":
        if (!is_null($parameters["answerID"])) {
            if (!is_int($parameters["answerID"])) {
                $response = "Parameter 'answerID' must be an int";
                break;
            }
        } else {
            $response = "Parameter 'answerID' cannot be empty";
            break;
        }

        try {
            $answer = new Answer($parameters["answerID"]);
            $developer = new Developer($_SESSION["userID"]);
            $answer->vote($developer);
        } catch (Exception | TypeError | Error $e) {
            switch ($e->getCode()) {
                case 2:
                    $response = $e->getMessage();
                    $log->warning("User tried to vote on an anwer they voted on already");
                    break;
                case 1:
                    $response = $e->getMessage();
                    $log->warning("user searched for answer with ID " . $parameters["answerID"] . ", no answer with that ID found");
                    break;
                default:
                    $response = "An error has occured, please try again later";
                    $log->error($e->getMessage());
                    break;
            }
        }
        $response = true;
        break;
    case "unvote":
        if (!is_null($parameters["answerID"])) {
            if (!is_int($parameters["answerID"])) {
                $response = "Parameter 'answerID' must be an int";
                break;
            }
        } else {
            $response = "Parameter 'answerID' cannot be empty";
            break;
        }

        try {
            $answer = new Answer($parameters["answerID"]);
            $developer = new Developer($_SESSION["userID"]);
            $answer->unvote($developer);
        } catch (Exception | TypeError | Error $e) {
            switch ($e->getCode()) {
                case 3:
                    $response = $e->getMessage();
                    $log->warning("User tried to unvote on an anwer they haven't voted on already");
                    break;
                case 1:
                    $response = $e->getMessage();
                    $log->warning("user searched for answer with ID " . $parameters["answerID"] . ", no answer with that ID found");
                    break;
                default:
                    $response = "An error has occured, please try again later";
                    $log->error($e->getMessage());
                    break;
            }
        }
        $response = true;
        break;
    case "postAnswer":
        if (!is_null($parameters["antwoord"]) && $parameters["antwoord"] !== "") {
            if (!is_string($parameters["antwoord"])) {
                $response = "Parameter 'antwoord' must be an string";
                break;
            }
        } else {
            $response = "Parameter 'antwoord' cannot be empty";
            break;
        }

        if (!is_null($parameters["questionID"])) {
            if (!is_int($parameters["questionID"])) {
                $response = "Parameter 'questionID' must be an int";
                break;
            }
        } else {
            $response = "Parameter 'questionID' cannot be empty";
            break;
        }

        try {
            $currUser = new Developer($_SESSION["userID"]);
            $question = new Question(intval($parameters["questionID"]));
            $question->postAnswer($parameters["antwoord"]);
        } catch (Exception | TypeError | Error $e) {
            switch ($e->getCode()) {
                case 1:
                    $response = $e->getMessage();
                    break;
                case 5:
                    $response = "E-002";
                    break;
                default:
                    $log->error($e->getMessage());
                    $response = "An error has occured, please try again later";
            }
        }
        $response = true;
        break;
    case "postQuestion":
        if (!is_null($parameters["question"]) && $parameters["question"] !== "") {
            if (!is_string($parameters["question"])) {
                $response = "Parameter 'question' must be an string";
                break;
            }
        } else {
            $response = "Parameter 'question' cannot be empty";
            break;
        }

        try {
            $currUser = new Developer($_SESSION["userID"]);
            $questionHandler = new QuestionHandler();
            $questionHandler->postQuestion($parameters["question"], $currUser);
        } catch (Exception | TypeError | Error $e) {
            switch ($e->getCode()) {
                case 1:
                    $response = $e->getMessage();
                    break;
                case 5:
                    $response = "E-002";
                    break;
                default:
                    $log->error($e->getMessage());
                    $response = "An error has occured, please try again later";
            }
        }
        $response = true;
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
