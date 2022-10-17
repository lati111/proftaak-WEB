<?php

declare(strict_types=1);

require "../../vendor/autoload.php";

use Modules\Database\Database;
use Modules\Developer\Developer;

function login(string $email, string $password): bool
{
    $q_a = new Database("q&a");
    $db = $q_a->getConn();

    $sql = "SELECT idDeveloper, password FROM developer WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (sodium_crypto_pwhash_str_verify($row["password"], $password)) {
        $_SESSION["user"] = new Developer($row["idDeveloper"]);
        return true;
    } else {
        return false;
    }
}

function registerDeveloper(string $name, string $email, string $password, string $nickname = null): bool
{
    $q_a = new Database("q&a");
    $db = $q_a->getConn();

    $sql = "INSERT INTO developer VALUES (DEFAULT, :username, ";
    if (!is_null($nickname)) {
        $sql .= ":nickname";
    } else {
        $sql .= "NULL";
    }
    $sql .= ", :email, :password)";

    try {
        $password = sodium_crypto_pwhash_str(
            $password,
            SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE
        );
    } catch (SodiumException $e) {
        throw $e;
        return false;
    }


    try {
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":username", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        if (!is_null($nickname)) {
            $stmt->bindParam(":nickname", $nickname);
        }
        $stmt->execute();
    } catch (PDOException $e) {
        throw $e;
        return false;
    }
    return true;
}
