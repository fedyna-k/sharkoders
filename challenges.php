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
            
            if (isset($_GET["id"])) {
                // seek info file if exists

                include("backend/config.php");
                $db = new PDO("mysql:host=" . $server . ";dbname=" . $database . ";charset=UTF8", $user, $pass);
                
                $req = $db->prepare("SELECT NameExercice, Abstract FROM EXERCICES WHERE IdExercice = :id");
                $req->bindParam(":id", $_GET["id"]);
                $req->execute();

                $res = $req->fetch();

                if ($res && file_exists("challenges_files/challenge-". $_GET["id"] .".php")) {
                    echo "<h1>" . $res["NameExercice"] . "</h1>
                    <em>Accéder au <a href='leaderboard?id=".$_GET["id"]."'>leaderboard associé</a></em>";

                    $req = $db->prepare("SELECT DateEnd FROM SOLVE WHERE IdUser = :idu AND IdExercice = :ide");
                    $req->bindParam(":idu", $_SESSION["userid"]);
                    $req->bindParam(":ide", $_GET["id"]);
                    $req->execute();
                    $dateend = $req->fetch();

                    if ($dateend) {

                        include("challenges_files/challenge-". $_GET["id"] .".php");

                        if (!$dateend[0]) {
                            echo "<p><a href='challenge_inputs/". $_SESSION["userid"] . "_" . $_GET["id"] . "_input.txt'>Lien vers votre énoncé</a></p>
                            <form action='public_backend/send_solution' method='post'>
                            <input type='hidden' name='challenge' id='challenge' value=".$_GET["id"].">
                            <label for='solution'>Proposition de réponse</label>
                            <input type='text' id='solution' name='solution' placeholder='Solution...' autocomplete='off'>
                            <div id='submit-div'><input type='submit' value='Soumettre'></div>
                            </form>";

                            if (isset($_SESSION["bad-answer"])) {
                                echo "<p style='color: red'>Mauvaise réponse.</p>";
                                unset($_SESSION["bad-answer"]);
                            }
                        } else {
                            echo "<p style='color: #ffd400'>Bravo, vous avez réussi ce challenge !</p>";
                        }



                    } else {
                        $_SESSION["last_unstarted_challenge"] = $_GET["id"];
                        $languages = [
                            "Assembleur", "Basic", "Brainfuck",
                            "C", "C++", "C#", "Fortran", "Go",
                            "Haskell", "Java", "JavaScript", "Kotlin",
                            "Lisp", "Lua", "Matlab", "MIPS", "Objective-C", "OCaml",
                            "Pascal", "Perl", "PHP", "Python", "R", "Ruby", "Rust",
                            "Scilab", "Swift"
                        ];

                        echo "<p>" . $res["Abstract"] . "</p>";
                        echo "<form action='public_backend/start_solving' method='post'>
                            <input type='hidden' name='language' id='language' value=''>
                            <label for='l'>Langage utilisé</label>
                            <select name='l' id='l'>
                                <option value=''>-- Langage --</option>";

                        foreach ($languages as $l) {
                            echo "<option value='". $l ."'>".$l."</option>";
                        }
                                
                        echo "</select>
                        <div id='submit-div'><input type='submit' value='Commencer le challenge'></div>
                        </form>";

                        echo "<script src='resources/scripts/challenge.js'></script>";
                    }                
                } else {
                    header("Location: challenges");
                    exit();
                }
            } else {
                echo "<h1>Challenges</h1>
                <em>Accéder au <a href='leaderboard'>Poly'derboard</a></em>";

                // Get all challenges
                include("backend/config.php");
                $db = new PDO("mysql:host=" . $server . ";dbname=" . $database . ";charset=UTF8", $user, $pass);
                
                $req = $db->prepare("SELECT * FROM EXERCICES ORDER BY IdExercice DESC");
                $req->execute();

                foreach($req->fetchAll() as $info) {
                    echo "<h2><a href='challenges?id=".$info["IdExercice"]."'>".$info["NameExercice"]."</a></h2>";
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