<?php
declare (strict_types = 1);

namespace Modules\Developer;

require "../../vendor/autoload.php";

use Modules\Database\Database;
use PDO;

class Developer
{
    private int $id;
    private string $nickname;
    private string $name;
    private string $email;
    private $error;

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
            $this->error = "No developer under that id found.";
        }
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

    public function getError()
    {
        $error = $this->error;
        $this->error = null;
        return $error;
    }
}
