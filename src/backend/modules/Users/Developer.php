<?php

declare(strict_types=1);

namespace Modules\Developer;

require "/xampp/htdocs/proftaak-WEB/vendor/autoload.php";

use Exception;
use Modules\Database\Database;
use Modules\Forum\Answer;
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
            throw new Exception("No developer under that id found", 5);
        }
    }

    public function getID(): int {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNickname(): string
    {
        if ($this->nickname === null) {
            return $this->nickname;
        } else {
            $name = $this->getName();
            return $name;
        }
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
