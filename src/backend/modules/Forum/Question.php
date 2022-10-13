<?php

declare(strict_types=1);

namespace Modules\Forum\Question;

require "../../vendor/autoload.php";

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

    public function getAnswers(): array
    {
        $q_a = new Database("q&a");
        $db = $q_a->getConn();

        $sql = "SELECT * FROM answer WHERE idQuestion = :ID";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":ID", $this->id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
