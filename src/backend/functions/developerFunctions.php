<?php

declare(strict_types=1);

require "../../vendor/autoload.php";

use Modules\Database\Database;

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

    $password = sodium_crypto_pwhash_str(
        $password, 
        SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, 
        SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE
    );
    

    $stmt = $db->prepare($sql);
    $stmt->bindParam(":username", $name);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $password);
    if (!is_null($nickname)) {
        $stmt->bindParam(":nickname", $nickname);
    }
    if (!$stmt->execute()) {
        $_SESSION["error"] = $stmt->errorInfo();
        return false;
    } else {
        return true;
    }
}
