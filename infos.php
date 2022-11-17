<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <!-- Meta of the website -->
        <?php include("resources/includes/meta.php"); ?>
        <!-- -->

        <link rel="stylesheet" href="resources/stylesheets/main.css">
        <link rel="stylesheet" href="resources/stylesheets/complement.css">

        <link rel="shortcut icon" href="resources/images/icon.svg" type="image/x-icon">

        <title>Sharkoders</title>
    </head>

    <body>
        <!-- Header -->
        <?php include("resources/includes/header.php"); ?>
        <!-- -->
        
        <section>
            

            <?php
            
            if (isset($_GET["id"])) {
                // seek info file if exists
                if (file_exists("info_files/info-". $_GET["id"] .".php")) {
                    include("info_files/info-". $_GET["id"] .".php");
                } else {
                    header("Location: infos");
                    exit();
                }
            } else {
                echo "<h1>Dernières informations</h1>";

                // Get all infos
                include("backend/config.php");
                $db = new PDO("mysql:host=" . $server . ";dbname=" . $database . ";charset=UTF8", $user, $pass);
                
                $req = $db->prepare("SELECT * FROM INFOS ORDER BY IdInfo DESC");
                $req->execute();

                foreach($req->fetchAll() as $info) {
                    echo "<h2><a href='infos?id=".$info["IdInfo"]."'>".$info["NameInfo"]."</a></h2>";
                    echo "<p>" . $info["Abstract"] . "</p>";
                }
            }

            ?>
        </section>

        <!-- Footer -->
        <?php include("resources/includes/footer.php"); ?>
        <!-- -->
    </body>
</html>