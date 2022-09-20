<?php

namespace Database;
use PDO;

class Database {
    private $PDO;

    public function __construct($dbname)
    {
        $data = json_decode(file_get_contents("../../config.json"), true, 512, JSON_THROW_ON_ERROR)["database"];
        $this->PDO = new PDO("mysql:host=localhost;dbname=$dbname", "root", "");
    }

    public function getConn()
    {
        return $this->PDO;
    }
}