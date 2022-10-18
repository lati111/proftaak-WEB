<?php

declare(strict_types=1);
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
    <section id="header">
        <div id="bannerSection">
            <h1>Proftaak forums</h1>
        </div>
        <div id="accountSection">

        </div>
    </section>
    <li id="errors"></li>
    <section id="mainBody">
        <div id="forumTableContainer">
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
        <div id="question"></div>
        <div id="answerContainer">
            <div id="answerForum">

            </div>
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