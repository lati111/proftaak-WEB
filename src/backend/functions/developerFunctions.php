<?php

use Database\Database as Database;;

function registerDeveloper(string $name, string $email, string $password, string $nickname = null) {
    $q_a = new Database("q&a");
    $db = $q_a->getConn();
    

    $sql = "INSERT INTO developer (DEFAULT, :naam, ";
    if (!is_null($nickname)) {
        $sql .= ":nickname";
    } 
    else {
        $sql .= "NULL"; 
    }
    $sql .= ", :email, :password";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $password);
    if (!is_null($nickname)) {
        $stmt->bindParam(":nickname", $$nickname);
    }
    if (!$stmt->execute()) {
        return $db->errorInfo();
    } 
    else {
        return $db->lastInsertId();
    }
    
}