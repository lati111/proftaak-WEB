<?php

declare(strict_types=1);
session_start();

use Modules\Developer\Developer;

$loggedIn = true;
if (isset($_GET["logout"])) {
    if ($_GET["logout"] === "true") {
        session_destroy();
        $loggedIn = false;
    } 
}

if (isset($_SESSION["userID"]) && $loggedIn) {
    try {
        $currUser = new Developer($_SESSION["userID"]);
    } catch (Exception | Error | TypeError $e) {
    }
    header("Location: http://localhost/proftaak-WEB/src/pages/forum/");
}

?>
<!doctype html>

<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Q&A - login</title>

    <link rel="stylesheet" href="../../styles/main.css">
</head>

<body onload="init()">
    <audio id="audio2" controls autoplay loop class="hidden">
        <source src="../../music/wii_but_fucked2.mp3" type="audio/mp3">
    </audio>

    <div>
        <img id="skullduggery" src="https://media.tenor.com/g1bZgt4-tL4AAAAC/skull.gif">
    </div>

    <section id="loginSection">
        <h1>Log in</h1>
        <ul id="loginError"></ul>
        <div id="loginForm">
            <div><input type="email" name="email" placeholder="Email..." style="width: 16em;"></div>
            <div><input type="password" name="password" placeholder="Password..." style="width: 21em;"></div>
            <div><button onclick="login()">Log in</button></div>
            <a href="../register/">Or register an account</a>
        </div>
    </section>

</body>

<script src="../../scripts/ajax.js"></script>
<script src="../../scripts/general.js"></script>
<script src="scripts/login.js"></script>