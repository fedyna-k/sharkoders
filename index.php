<?php

session_start();
// Preload member names in order to avoir multiple database calls

if (!isset($_SESSION["members"])) {
    include("backend/config.php");
    $db = new PDO("mysql:host=" . $server . ";dbname=" . $database . ";charset=UTF8", $user, $pass);
    
    $req = $db->prepare("SELECT FirstName, LastName FROM USERS");
    $req->execute();

    $_SESSION["members"] = $req->fetchAll();
}

?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <!-- Meta of the website -->
        <?php include("resources/includes/meta.php"); ?>
        <!-- -->

        <link rel="stylesheet" href="resources/stylesheets/main.css">
        <link rel="stylesheet" href="resources/stylesheets/index-style.css">

        <link rel="shortcut icon" href="resources/images/icon.svg" type="image/x-icon">

        <script src="resources/scripts/matrix.js" defer></script>

        <title>Sharkoders</title>
    </head>

    <body>
        <!-- Header -->
        <?php include("resources/includes/header.php"); ?>
        <!-- -->

        <!-- Only index -->

        <div id="matrix"></div>

        <section id="main">
            <img id="sharkoders" src="resources/images/logo.svg" alt="logo Sharkoders">
            <div id="home-buttons">
                <a href="challenges">Commencez à coder !</a>
                <a href="infos">Nos dernieres infos</a>
            </div>
        </section>

        <!-- -->

        <section>
            <h1>Qui sont les Sharkoders ?</h1>
            <p>Sharkoders est le club de Hackathon de Polytech Marseille.</p>
            <p>
                Coder est notre passion et nous aimons mettre nos connaissances à l'épreuve lors de compétitions.
                Les hackathons sont aussi une occasion de passer une bonne soirée entre amis !
            </p>
            <p>Si vous voulez proposer un challenge, envoyez-nous un mail à</p>
            <p style="text-align: center">contact<em>[at]</em>sharkoders<em>[dot]</em>fr</p>

            <h2>Gestion du club</h2>
            <p>Kevin Fedyna<br><em>Président, Lead Developer, Webmaster</em></p>
            <p>Anas Chhilif<br><em>Vice-président, Trésorier</em></p>

            <h2>Créateurs de Challenges</h2>
            <p>Kevin Fedyna, Anas Chhilif</p>

            <h2>Membres</h2>
            <p>
                <?php
                
                for ($i = 0 ; $i < count($_SESSION["members"]) ; $i++) { 
                    echo $_SESSION["members"][$i]["FirstName"] . " " . $_SESSION["members"][$i]["LastName"];

                    if ($i != count($_SESSION["members"]) - 1) {
                        echo ", ";
                    }
                }

                ?>
            </p>
        </section>

        <!-- Footer -->
        <?php include("resources/includes/footer.php"); ?>
        <!-- -->
    </body>
</html>