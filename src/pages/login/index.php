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
    <title>Q&A - login</title>
</head>

<body>
    <section id="loginSection">
        <h1>Log in</h1>
        <ul id="loginError"></ul>
        <div id="loginForm">
            <div><input type="email" name="email" placeholder="Email..."></div>
            <div><input type="password" name="password" placeholder="Password..."></div>
            <div><button onclick="login()">Log in</button></div>
        </div>
    </section>

</body>

<script src="../../scripts/ajax.js"></script>
<script src="scripts/login.js"></script>