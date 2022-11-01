<?php

declare(strict_types=1);

namespace Modules\Forum;

require "/xampp/htdocs/proftaak-WEB/vendor/autoload.php";

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

    function __construct(int $id, Question $question = null)
    {
        $this->id = $id;
        if (!is_null($question)) {
            $this->question = $question;
        }
        $q_a = new Database("q&a");
        $db = $q_a->getConn();

        $sql = "SELECT antwoord, idQuestion FROM answer WHERE idAnswer = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $developerData = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->antwoord = $developerData["antwoord"];
            if (is_null($question)) {
                $this->question = new Question($developerData["idQuestion"]);
            }
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
        $sql = "INSERT INTO votelog VALUES (:idAnswer, :idDeveloper)";
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
        $sql = "DELETE FROM votelog WHERE idDeveloper = :idDeveloper AND idAnswer = :idAnswer";
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
        $sql = "SELECT * FROM votelog WHERE idDeveloper = :idDeveloper AND idAnswer = :idAnswer";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":idDeveloper", $developerID);
        $stmt->bindParam(":idAnswer", $this->id);
        $stmt->execute();
        return ($stmt->rowCount() > 0);
    }

    public function getVotes(): int
    {
        $q_a = new Database("q&a");
        $db = $q_a->getConn();

        $sql = "SELECT count(idAnswer) as votes FROM votelog WHERE idAnswer = :idAnswer";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":idAnswer", $this->id);
        $stmt->execute();
        return ($stmt->fetch(PDO::FETCH_ASSOC)["votes"]);
    }

    public function getID(): int
    {
        return $this->ID;
    }

    public function getAntwoord(): string
    {
        return $this->antwoord;
    }

    public function getQuestion(): Question
    {
        return $this->question;
    }
}
