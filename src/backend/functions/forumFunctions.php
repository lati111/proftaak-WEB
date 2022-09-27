<?php

declare(strict_types=1);

require "../../vendor/autoload.php";

use Modules\Database\Database;
use Modules\Forum\Answer\Answer;
use Modules\Forum\Question\Question;

function getQuestionCount() {
    $q_a = new Database("q&a");
    $db = $q_a->getConn();

    $sql = "SELECT count(idQuestion) FROM question";
}