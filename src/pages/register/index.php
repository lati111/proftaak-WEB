<?php
session_start();
?>
<!doctype html>

<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Q&A - register</title>
</head>

<body>
    <h1>Register a developer account</h1>
    <ul id="regTableError"></ul>
    <table id="registerTable">
        <tbody>
            <tr>
                <td style="font-size: 0.7em;">Fields marked with * are required</td>
            </tr>
            <tr>
                <td>Username:</td>
                <td><input type="text" name="nickname"></td>
            </tr>
            <tr>
                <td>Full name: *</td>
                <td><input type="text" name="name"></td>
            </tr>
            <tr>
                <td>Email address: *</td>
                <td><input type="email" name="email"></td>
            </tr>
            <tr>
                <td>Password: *</td>
                <td><input type="password" name="password1"></td>
            </tr>
            <tr>
                <td>Repeat password: *</td>
                <td><input type="password" name="password2"></td>
            </tr>
            <tr>
                <td colspan="2"><button onclick="registerDeveloper()">registreer</button></td>
            </tr>
        </tbody>
    </table>
</body>

<script src="../../scripts/ajax.js"></script>
<script src="scripts/register.js"></script>

</html>