<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <!-- Meta of the website -->
        <?php include("resources/includes/meta.php"); ?>
        <!-- -->

        <link rel="stylesheet" href="resources/stylesheets/main.css">
        <link rel="stylesheet" href="resources/stylesheets/complement.css">
        <link rel="stylesheet" href="resources/stylesheets/forms.css">

        <link rel="shortcut icon" href="resources/images/icon.svg" type="image/x-icon">

        <title>Sharkoders</title>
    </head>

    <body>
        <!-- Header -->
        <?php include("resources/includes/header.php"); ?>
        <!-- -->
        
        <section>
            <?php

            if (isset($_SESSION["userid"])) {
                include("resources/includes/my_space.php");
            } else {
                if (isset($_GET["register"])) {
                    include("resources/includes/register.php");
                } else {
                    include("resources/includes/log_in.php");
                }
            }
            
            ?>
        </section>

        <!-- Footer -->
        <?php include("resources/includes/footer.php"); ?>
        <!-- -->
    </body>
</html>