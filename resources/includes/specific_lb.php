<?php

include("backend/config.php");
$db = new PDO("mysql:host=" . $server . ";dbname=" . $database . ";charset=UTF8", $user, $pass);

$id = $_GET["id"];

$req = $db->prepare("SELECT NameExercice FROM EXERCICES
    WHERE IdExercice = :exercice");
$req->bindParam(":exercice", $id);
$req->execute();

echo "<h1>Poly'derboard - " . $req->fetch()[0] . "</h1>";

?>

<p><em>Voir le <a href="leaderboard">Poly'derboard général</a>.</em></p>

<table>
    <tr>
        <th>Position</th>
        <th>Participant</th>
        <th>Temps</th>
        <th>Langage utilisé</th>
    </tr>
<?php

include("backend/functions.php");

$start_index = (isset($_GET["start"]) && intval($_GET["start"]) != 0) ? $_GET["start"] - 1 : 0;

// GET LOCAL LEADERBOARD
$req = $db->prepare("SELECT * FROM (
    SELECT IdUser, FirstName, LastName,
            TIME_TO_SEC(TIMEDIFF(DateEnd, DateBegin)) AS Duration,
            LanguageS, ColorBadge
        FROM SOLVE NATURAL JOIN USERS LEFT JOIN BADGES ON USERS.IdBadge = BADGES.IdBadge
        WHERE IdExercice = :exercice
        ORDER BY -Duration DESC
) AS ChallengeLeaderboard LIMIT 50 OFFSET :startindex");
$req->bindParam(":exercice", $id);
$req->bindParam(":startindex", $start_index, PDO::PARAM_INT);
$req->execute();

// Print it
foreach ($req->fetchAll() as $i => $player) {

    echo "<tr>";

    echo "<td><em>" . ($i + $start_index + 1) . "</em></td>";

    if ($player["ColorBadge"] == null) {
        echo "<td>" . $player["FirstName"] . " " .
            $player["LastName"] . "</td>";
    } else {
        echo "<td style='color: " .
            $player["ColorBadge"] .
            " ; text-shadow: 0 0 0.5em " .
            $player["ColorBadge"] . "'>" .
            $player["FirstName"] . " " .
            $player["LastName"] . "</td>";
    }
    
    $time = getDiffTimeText(round(floatval($player["Duration"])));

    echo "<td>" . (($time != "0secondes") ? $time : "Aucun temps") . "</td>";
    
    echo "<td>" . $player["LanguageS"] . "</td>";

    echo "</tr>";
}

echo "</table>";

$req = $db->prepare("SELECT COUNT(*) FROM (
    SELECT IdUser, FirstName, LastName,
            TIME_TO_SEC(TIMEDIFF(DateEnd, DateBegin)) AS Duration,
            LanguageS, ColorBadge
        FROM SOLVE NATURAL JOIN USERS LEFT JOIN BADGES ON USERS.IdBadge = BADGES.IdBadge
        WHERE IdExercice = :exercice
        ORDER BY -Duration DESC
) AS ChallengeLeaderboard LIMIT 50 OFFSET :startindex;");
$req->bindParam(":exercice", $id);
$req->bindParam(":startindex", $start_index, PDO::PARAM_INT);
$req->execute();


echo "<div style='display: flex; justify-content: space-around'>";

if ($start_index != 0) {
    echo "<a href='?id=" . $id . "&start=" . max(1, $start_index - 50) . "'>" . max(1, $start_index - 50) . "</a>";
}

if ($req->fetch()[0] > 50) {
    echo "<a href='?id=" . $id . "&start=" . ($start_index + 51) . "'>" . ($start_index + 51) . "</a>";
}

echo "</div>";

?>

