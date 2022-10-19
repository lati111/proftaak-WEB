<?php

declare(strict_types=1);

namespace Modules\Forum;

require "/xampp/htdocs/proftaak-WEB/vendor/autoload.php";

use Exception;
use Modules\Database\Database as Database;
use Modules\Developer\Developer;
use PDO;

class Question
{
    private int $id;
    private Developer $developer;
    private string $vraag;

    function __construct(int $id)
    {
        $this->id = $id;
        $q_a = new Database("q&a");
        $db = $q_a->getConn();

        $sql = "SELECT vraag, idDeveloper FROM question WHERE idQuestion = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $developerData = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->developer = new Developer($developerData["idDeveloper"]);
            $this->vraag = $developerData["vraag"];
        } else {
            throw new Exception("No developer under that id found", 1);
        }
    }

    public function getAnswers(int $offset = null, int $amount = null): array
    {
        $q_a = new Database("q&a");
        $db = $q_a->getConn();

        $sql = "SELECT idAnswer, antwoord, (SELECT count(votelog.idAnswer) FROM votelog WHERE votelog.idAnswer = answer.idAnswer) 
            as votes FROM answer WHERE idQuestion = :ID  ORDER BY votes DESC
        ";
        if ($offset !== null && $amount !== null) {
            $sql .= " LIMIT :amount OFFSET :offset";
        }
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":ID", $this->id);
        if ($offset !== null && $amount !== null) {
            $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
            $stmt->bindValue(":amount", $amount, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function postAnswer(string $antwoord): bool
    {
        $q_a = new Database("q&a");
        $db = $q_a->getConn();

        $sql = "INSERT INTO answer VALUES (DEFAULT, :antwoord, :idQuestion)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":antwoord", $antwoord);
        $stmt->bindParam(":idQuestion", $this->id);
        return $stmt->execute();
    }

    public function getVraag(): string
    {
        return $this->vraag;
    }

    public function getDeveloper(): Developer
    {
        return $this->developer;
    }
}
