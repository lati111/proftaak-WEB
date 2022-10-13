<?php

declare(strict_types=1);

namespace Modules\Forum\Answer;

require "../../vendor/autoload.php";

use Exception;
use Modules\Database\Database;
use Modules\Forum\Question\Question;
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

    public function getVraag()
    {
        return $this->vraag;
    }

    public function getDeveloper()
    {
        return $this->developer;
    }
}
