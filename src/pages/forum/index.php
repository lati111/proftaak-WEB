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
        <div id="forumTableContainer">
            <table id="forum">

            </table>
            <div id="pageNav">
                <span><button name="navButton" value="-1">&#60;</button></span>
                <span id="pageButton1"><button>1</button></span>
                <span id="pageButton2">...</span>
                <span id="pageButton3"><button>14</button></span>
                <span id="pageButton4"><button>15</button></span>
                <span id="pageButton5"><button>16</button></span>
                <span id="pageButton6">...</span>
                <span id="pageButton7"><button>44</button></span>
                <span><button name="navButton" value="+1">&#62;</button></span>
            </div>
        </div>
    </section>

</body>

<script src="../../scripts/ajax.js"></script>
<script src="scripts/forum.js"></script>

</html>