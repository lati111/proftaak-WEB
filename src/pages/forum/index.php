<?php

declare(strict_types=1);

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

<body onload="init()">
    <audio id="audio2" controls autoplay loop class="hidden">
        <source src="../../music/wii_but_fucked.mp3" type="audio/mp3">
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
                $currUser = new Developer($_SESSION["userID"]);
            } catch (Exception | Error | TypeError $e) {
                if ($e->getCode() === 5) {
                    echo "<a href='../login/'>log in</a>";
                }
            }
            echo "<a href='../login/index.php?logout=true'>log out</a>";
            ?>
        </div>
    </section>
    <ul id="errors"></ul>
    <section id="mainBody">
        <div id="forumTableContainer">
            <div>
                <a href="newQuestion.php"><button>+</button></a>
            </div>
            <table id="forum">

            </table>
            <div id="pageNav">
                <span><button name="navButton" value="-1" onclick="setQuestionPage('-1')">&#60;</button></span>
                <span id="pageQuestionButton1"></span>
                <span id="pageQuestionButton2"></span>
                <span id="pageQuestionButton3"></span>
                <span id="pageQuestionButton4"></span>
                <span id="pageQuestionButton5"></span>
                <span id="pageQuestionButton6"></span>
                <span id="pageQuestionButton7"></span>
                <span><button name="navButton" value="+1" onclick="setQuestionPage('+1')">&#62;</button></span>
            </div>
        </div>
    </section>

    <section id="questionBody" class="hidden">
        <button onclick="closeQuestion()">&#9166</button>
        <div id="question"></div>
        <table id="bestAnswer"></table>
        <form id="answerInput" answerInput>
            <input type="hidden" id="questionID" name="questionID">
            <textarea name="antwoord" cols="60" rows="7" placeholder="Your answer..."></textarea>
            <br>
            <button id="anwswerSubmit" type="submit" name="submit" value="answerPost">Submit</button>
        </form>
        <div id="answerContainer">
            <table id="answerForum">

            </table>
        </div>
        <div id="answerNav">
            <table id="answerTable">
                <span><button name="navButton" value="-1" onclick="setAnswerPage('-1')">&#60;</button></span>
                <span id="pageAnswerButton1"></span>
                <span id="pageAnswerButton2"></span>
                <span id="pageAnswerButton3"></span>
                <span id="pageAnswerButton4"></span>
                <span id="pageAnswerButton5"></span>
                <span id="pageAnswerButton6"></span>
                <span id="pageAnswerButton7"></span>
                <span><button name="navButton" value="+1" onclick="setAnswerPage('+1')">&#62;</button></span </table>
        </div>

    </section>

</body>

<script src=" ../../scripts/ajax.js"></script>
<script src="../../scripts/general.js"></script>
<script src="scripts/forum.js"></script>

</html>