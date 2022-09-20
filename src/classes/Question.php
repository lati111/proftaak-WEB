<?php

namespace Question;

use Database\Database;
use Developer\Developer;
use PDO;

class Question {
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
            $this->error = "No developer under that id found.";
        }
    }

    public function getVraag() {
        return $this->vraag;
    }

    public function getDeveloper() {
        return $this->developer;
    }
}