<header>
    <a href="http://127.0.0.1:8080/edsa-sharkoders/"><img src="resources/images/logo.svg" alt="logo Sharkoders"></a>
    <div>
        <a href="challenges">Challenges</a>
        <a href="infos">Infos</a>

        <?php
        
        if (isset($_SESSION["userid"])) {
            $filename = explode("/", $_SERVER["PHP_SELF"]);

            if(end($filename) == "espace.php") {
                echo "<a href='log-out'>Deconnexion</a>";
            } else {
                echo "<a href='espace'>Espace</a>";
            }
        } else {
            echo "<a href='espace'>Connexion</a>";
        }

        ?>
    </div>
</header>