<?php

declare(strict_types=1);

namespace Modules\Forum;

require "../../vendor/autoload.php";

use Exception;
use Modules\Database\Database;
use Modules\Developer\Developer;
use Modules\Forum\Question;
use PDO;

class Answer
{
    private int $id;
    private Question $question;
    private string $antwoord;
    private int $votes;

    function __construct(int $id, Question $question)
    {
        $this->id = $id;
        $this->question = $question;
        $q_a = new Database("q&a");
        $db = $q_a->getConn();

        $sql = "SELECT antwoord, votes FROM answer WHERE idAnswer = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $developerData = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->antwoord = $developerData["antwoord"];
            $this->votes = $developerData["votes"];
        } else {
            throw new Exception("No answer under that id found", 1);
        }
    }

    public function vote(Developer $developer): bool
    {
        if ($this->hasVoted($developer)) {
            throw new Exception("You already voted on this!", 2);
        }

        $q_a = new Database("q&a");
        $db = $q_a->getConn();

        $developerID = $developer->getID();
        $sql = "INSERT INTO voteLog VALUES (:idAnswer, :idDeveloper)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":idDeveloper", $developerID);
        $stmt->bindParam(":idAnswer", $this->id);
        return $stmt->execute();
    }

    public function unvote(Developer $developer): bool
    {
        if (!$this->hasVoted($developer)) {
            throw new Exception("You cannot delete something you haven't voted on!", 3);
        }

        $q_a = new Database("q&a");
        $db = $q_a->getConn();

        $developerID = $developer->getID();
        $sql = "DELETE FROM voteLog WHERE idDeveloper = :idDeveloper AND idAnswer = :idAnswer";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":idDeveloper", $developerID);
        $stmt->bindParam(":idAnswer", $this->id);
        return $stmt->execute();
    }

    public function hasVoted(Developer $developer): bool
    {
        $q_a = new Database("q&a");
        $db = $q_a->getConn();

        $developerID = $developer->getID();
        $sql = "SELECT * FROM voteLog WHERE idDeveloper = :idDeveloper AND idAnswer = :idAnswer";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":idDeveloper", $developerID);
        $stmt->bindParam(":idAnswer", $this->id);
        $stmt->execute();
        return ($stmt->rowCount() > 0);
    }

    public function getID()
    {
        return $this->ID;
    }

    public function getVraag()
    {
        return $this->vraag;
    }

    public function getDeveloper()
    {
        return $this->developer;
    }
}
