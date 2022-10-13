<?php

declare(strict_types=1);

namespace Modules\Developer;

require "../../vendor/autoload.php";

use Exception;
use Modules\Database\Database;
use Modules\Forum\Answer\Answer;
use PDO;

class Developer
{
    private int $id;
    private string $nickname;
    private string $name;
    private string $email;

    function __construct(int $id)
    {
        $this->id = $id;
        $q_a = new Database("q&a");
        $db = $q_a->getConn();

        $sql = "SELECT naam, nickname, email FROM developer WHERE idDeveloper = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $developerData = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->name = $developerData["naam"];
            $this->nickname = $developerData["nickname"];
            $this->email = $developerData["email"];
        } else {
            throw new Exception("No developer under that id found");
        }
    }

    public function hasVoted(Answer $answer): bool
    {
        $q_a = new Database("q&a");
        $db = $q_a->getConn();

        $answerID = $answer->getID();
        $sql = "SELECT * FROM voteLog WHERE idDeveloper = :idDeveloper AND idAnswer = :idAnswer";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":idDeveloper", $this->id);
        $stmt->bindParam(":idAnswer", $answerID);
        $stmt->execute();
        return ($stmt->rowCount() > 0);
    }

    public function vote(Answer $answer): bool
    {
        if ($this->hasVoted($answer)) {
            throw new Exception("You already voted on this!", 2);
        }

        $q_a = new Database("q&a");
        $db = $q_a->getConn();

        $answerID = $answer->getID();
        $sql = "INSERT INTO voteLog VALUES (:idAnswer, :idDeveloper)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":idDeveloper", $this->id);
        $stmt->bindParam(":idAnswer", $answerID);
        return $stmt->execute();
    }

    public function unvote(Answer $answer): bool
    {
        if (!$this->hasVoted($answer)) {
            throw new Exception("You cannot delete something you haven't voted on!", 3);
        }

        $q_a = new Database("q&a");
        $db = $q_a->getConn();

        $answerID = $answer->getID();
        $sql = "DELETE FROM voteLog WHERE idDeveloper = :idDeveloper AND idAnswer = :idAnswer";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":idDeveloper", $this->id);
        $stmt->bindParam(":idAnswer", $answerID);
        return $stmt->execute();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNickname()
    {
        if ($this->nickname === null) {
            return $this->nickname;
        } else {
            $name = $this->getName();
            return $name;
        }
    }

    public function getEmail()
    {
        return $this->email;
    }
}
