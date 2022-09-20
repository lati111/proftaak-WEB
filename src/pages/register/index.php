<!doctype html>

<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Q&A - register</title>
</head>

<body>
    <h1>Registreer een account</h1>
    <table id="registerTable">
        <tbody>
            <tr>
                <td>Gebruikersnaam:</td>
                <td><input type="text" name="nickname"></td>
            </tr>
            <tr>
                <td>Volledige naam:</td>
                <td><input type="text" name="name"></td>
            </tr>
            <tr>
                <td>Email adres:</td>
                <td><input type="email" name="email"></td>
            </tr>
            <tr>
                <td>Wachtwoord:</td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td colspan="2"><button>registreer</button></td>
            </tr>
        </tbody>
    </table>
</body>

<script src="../../scripts/ajax.js"></script>
<script src="scripts/register.js"></script>

</html>