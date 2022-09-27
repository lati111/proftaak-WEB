<?php
declare(strict_types = 1);

namespace Modules\Database;
use PDO;

class Database {
    private $PDO;

    public function __construct($dbname)
    {
        $this->PDO = new PDO("mysql:host=localhost;dbname=$dbname", "root", "");
    }

    public function getConn(): PDO
    {
        return $this->PDO;
    }
}