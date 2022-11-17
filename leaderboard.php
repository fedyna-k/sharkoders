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
            
            if (isset($_GET["id"]) && intval($_GET["id"]) != 0) {
                include("resources/includes/specific_lb.php");
            } else {
                echo "<h1>Poly'derboard</h1>";
                include("resources/includes/general_lb.php");
            }

            ?>

        </section>

        <!-- Footer -->
        <?php include("resources/includes/footer.php"); ?>
        <!-- -->
    </body>
</html>