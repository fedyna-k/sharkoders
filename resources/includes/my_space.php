<?php 

include("backend/functions.php");

include("backend/config.php");
$db = new PDO("mysql:host=" . $server . ";dbname=" . $database . ";charset=UTF8", $user, $pass);

// Fetch user's challenges

$req = $db->prepare("SELECT IdExercice, NameExercice, LanguageS, DateBegin, DateEnd FROM SOLVE NATURAL JOIN EXERCICES WHERE IdUser = :id");
$req->bindParam(":id", $_SESSION["userid"], PDO::PARAM_STR);
$req->execute();

$user_challenges = $req->fetchAll();

// Fetch user's badges

$req = $db->prepare("SELECT * FROM OWN NATURAL JOIN BADGES WHERE IdUser = :id");
$req->bindParam(":id", $_SESSION["userid"], PDO::PARAM_STR);
$req->execute();

$user_badges = $req->fetchAll();

$req = $db->prepare("SELECT Position FROM (
    SELECT IdUser, FirstName, LastName, ColorBadge,
            AVG(Duration) AS TotalDur,
            SUM(ChallengeDone) AS TotalChal,
            (@i := @i + 1) AS Position
        FROM LEADERBOARD, (SELECT @i := 0) as IndexComputing
        GROUP BY IdUser
        ORDER BY TotalChal DESC, TotalDur
) AS PositionComputing WHERE IdUser = :id");
$req->bindParam(":id", $_SESSION["userid"], PDO::PARAM_STR);
$req->execute();

$user_position = $req->fetch()[0];

?>


<!------------------------------------------------------>


<h1>Bienvenue
    <?php
    
    if ($_SESSION["idbadge"] == null) {
        echo $_SESSION["firstname"]; 
    } else {
        echo "<span style ='color: " . $_SESSION["colorbadge"] . " ; text-shadow: 0 0 0.5em " . $_SESSION["colorbadge"] . "'>" . $_SESSION["firstname"] . "</span>";
    }

    ?>
</h1>

<p> <em> Position dans le <a href="leaderboard?start=<?php echo $user_position; ?>">Poly'derboard</a> : <?php echo $user_position; ?> </em></p>

<h2>Mes challenges</h2>

<table>

    <?php
    
    foreach ($user_challenges as $challenges) {
        echo "<tr>";
        echo "<td>" . $challenges["NameExercice"] . "</td>";

        if ($challenges["DateEnd"] == null) {
            echo "<td>En cours...</td>";
        } else {
            $datebegin = new DateTime($challenges["DateBegin"]);
            $dateend = new DateTime($challenges["DateEnd"]);

            echo "<td>" . getDiffTimeText($dateend->getTimestamp() - $datebegin->getTimestamp()) . "</td>";
        }

        echo "<td>" . $challenges["LanguageS"] . "</td>";
        echo "<td><a href='challenges?id=" . $challenges["IdExercice"] . "'>Aller au challenge</a></td>";
        echo "<td><a href='leaderboard?id=" . $challenges["IdExercice"] . "'>Leaderboard</a></td>";

        echo "</tr>";
    } 
    
    ?>

</table>

<h2>Mes badges</h2>

<table>

    <?php
    


    foreach ($user_badges as $badges) {
        echo "<tr>";

        echo "<td>" . $badges["NameBadge"] . "</td>";
        echo "<td style='color: " . $badges["ColorBadge"] . " ; text-shadow: 0 0 0.5em " . $badges["ColorBadge"] . "'>" . $_SESSION["firstname"] . " " . $_SESSION["lastname"] . "</td>";
        echo "<td><a href='public_backend/set_badge?id=" . $badges["IdBadge"] . "'>";
        
        if ($badges["IdBadge"] == $_SESSION["idbadge"]) {
            echo "Ne plus utiliser";
        } else {
            echo "Utiliser ce badge";
        }

        echo "</a></td>";

        echo "</tr>";
    }

    ?>
</table>