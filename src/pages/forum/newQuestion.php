<?php

declare(strict_types=1);

require "/xampp/htdocs/proftaak-WEB/vendor/autoload.php";

use Modules\Developer\Developer;

session_start();
?>
<!doctype html>

<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proftaak forum</title>

    <link rel="stylesheet" href="../../styles/main.css">
</head>

<body onload="init2()">
    <audio id="audio2" controls autoplay loop class="hidden">
        <source src="../../music/wii_but_fucked4.mp3" type="audio/mp3">
    </audio>

    <div>
        <img id="skullduggery" src="https://media.tenor.com/g1bZgt4-tL4AAAAC/skull.gif">
    </div>
    <section id="header">
        <div id="bannerSection">
            <h1>Proftaak forums</h1>
        </div>


        <div id="accountSection">
            <?php
            try {
                $user = new Developer($_SESSION["userID"]);
            } catch (Exception | TypeError $e) {
                header("Location: http://localhost/proftaak-WEB/src/pages/login");
                die();
            }
            ?>
        </div>
    </section>

    <ul id="errors"></ul>
    <a href="index.php"><button>&#9166</button></a>
    <div id="question"></div>
    <table id="bestAnswer"></table>
    <form id="questionInput">
        <textarea name="question" cols="60" rows="7" placeholder="Your question..."></textarea>
        <br>
        <button id="questionSubmit" type="submit" name="submit">Submit</button>
    </form>

</body>

<script src=" ../../scripts/ajax.js"></script>
<script src="../../scripts/general.js"></script>
<script src="scripts/forum.js"></script>
<script src="scripts/newQuestion.js"></script>

</html>