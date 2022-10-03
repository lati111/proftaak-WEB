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

</head>

<body onload="init()">
    <section id="header">
        <div id="bannerSection">
            <h1>Proftaak forums</h1>
        </div>
        <div id="accountSection">

        </div>
    </section>

    <section id="mainBody">
        <div id="forumTableContainer"></div>
    </section>

</body>

<script src="../../scripts/ajax.js"></script>
<script src="scripts/forum.js"></script>

</html>