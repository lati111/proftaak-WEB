<?php

declare(strict_types=1);

require "../../vendor/autoload.php";

use Modules\Database\Database;
use Modules\Forum\Answer\Answer;
use Modules\Forum\Question\Question;

function getQuestionCount(): int {
    $q_a = new Database("q&a");
    $db = $q_a->getConn();

    $sql = "SELECT count(idQuestion) as count FROM question";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC)["count"];
}