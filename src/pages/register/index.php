<?php

declare(strict_types=1);
session_start();

use Modules\Developer\Developer;

if (isset($_SESSION["userID"])) {
    try {
        $currUser = new Developer($_SESSION["userID"]);
    } catch (Exception | Error | TypeError $e) {
        if ($e->getCode() !== 5) {
            header("Location: http://localhost/proftaak-WEB/src/pages/forum/");
        }
    }
}

?>
<!doctype html>

<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Q&A - register</title>

    <link rel="stylesheet" href="../../styles/main.css">
</head>

<body onload="init()">
    <audio id="audio2" controls autoplay loop class="hidden">
        <source src="../../music/wii_but_fucke3.mp3" type="audio/mp3">
    </audio>

    <div id="skullDuggeryCoffin">
        <img id="skullduggery" src="https://media.tenor.com/g1bZgt4-tL4AAAAC/skull.gif">
    </div>

    <section id="registerSection">
        <h1>Register a developer account</h1>
        <ul id="regTableError"></ul>
        <table id="registerTable">
            <tbody>
                <tr>
                    <td style="font-size: 0.7em;">Fields marked with * are required</td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" class="input" name="username"></td>
                </tr>
                <tr>
                    <td>Full name: *</td>
                    <td><input type="text" class="input" name="name"></td>
                </tr>
                <tr>
                    <td>Email address: *</td>
                    <td><input type="email" class="input" name="email"></td>
                </tr>
                <tr>
                    <td>Password: *</td>
                    <td><input type="password" class="input" name="password1"></td>
                </tr>
                <tr>
                    <td>Repeat password: *</td>
                    <td><input type="password" class="input" name="password2"></td>
                </tr>
                <tr>
                    <td colspan="2"><button onclick="registerDeveloper()">registreer</button></td>
                </tr>
            </tbody>
        </table>
    </section>

    <section id="registeredSection" style="display: none;">
        <h1>Registratie succesvol!</h1>
        <div>
            <span>Click </span>
            <span><a href="../login">here</a></span>
            <span> to log in</span>
        </div>
    </section>

</body>

<script src="../../scripts/ajax.js"></script>
<script src="../../scripts/general.js"></script>
<script src="scripts/register.js"></script>

</html>