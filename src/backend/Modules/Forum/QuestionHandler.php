<?php

declare(strict_types=1);

namespace Modules\Forum;

require "/xampp/htdocs/proftaak-WEB/vendor/autoload.php";

use Modules\Database\Database;
use PDO;

class QuestionHandler {
    function getQuestionCount(): int
    {
        $q_a = new Database("q&a");
        $db = $q_a->getConn();

        $sql = "SELECT count(idQuestion) as count FROM question";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)["count"];
    }

    function getQuestions(int $offset, int $amount): array
    {
        $q_a = new Database("q&a");
        $db = $q_a->getConn();

        $sql = "SELECT * FROM question ORDER BY idQuestion DESC LIMIT :amount OFFSET :offset";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindValue(":amount", $amount, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}