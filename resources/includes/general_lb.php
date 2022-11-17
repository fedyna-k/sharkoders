<table>
    <tr>
        <th>Position</th>
        <th>Participant</th>
        <th>Challenges réussis</th>
        <th>Temps moyen</th>
        <th>Langage préféré</th>
    </tr>
<?php

include("backend/functions.php");

$start_index = (isset($_GET["start"]) && intval($_GET["start"]) != 0) ? $_GET["start"] - 1 : 0;

include("backend/config.php");
$db = new PDO("mysql:host=" . $server . ";dbname=" . $database . ";charset=UTF8", $user, $pass);

// GET GLOBAL LEADERBOARD
$req = $db->prepare("SELECT * FROM (
    SELECT IdUser, FirstName, LastName, ColorBadge, LanguageS,
            AVG(Duration) AS AvgDur,
            SUM(ChallengeDone) AS TotalChal,
            (@i := @i + 1) AS Position
        FROM LEADERBOARD, (SELECT @i := 0) as IndexComputing
        GROUP BY IdUser
        ORDER BY TotalChal DESC, AvgDur
) AS GlobalLeaderboard ORDER BY Position LIMIT 50 OFFSET :startindex");
$req->bindParam(":startindex", $start_index, PDO::PARAM_INT);
$req->execute();

// Print it
foreach ($req->fetchAll() as $player) {

    echo "<tr>";

    echo "<td><em>" . $player["Position"] . "</em></td>";

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

    echo "<td>" . $player["TotalChal"] . "</td>";
    
    $time = getDiffTimeText(round(floatval($player["AvgDur"])));
    echo "<td>" . (($time != "0secondes") ? $time : "Aucun temps") . "</td>";
    
    echo "<td>" . $player["LanguageS"] . "</td>";

    echo "</tr>";
}

echo "</table>";

$req = $db->prepare("SELECT COUNT(*) FROM (
    SELECT IdUser, FirstName, LastName, ColorBadge, LanguageS,
            AVG(Duration) AS AvgDur,
            SUM(ChallengeDone) AS TotalChal,
            (@i := @i + 1) AS Position
        FROM LEADERBOARD, (SELECT @i := 0) as IndexComputing
        GROUP BY IdUser
        ORDER BY TotalChal DESC, AvgDur
) AS GlobalLeaderboard ORDER BY Position LIMIT 50 OFFSET :startindex");
$req->bindParam(":startindex", $start_index, PDO::PARAM_INT);
$req->execute();


echo "<div style='display: flex; justify-content: space-around'>";

if ($start_index != 0) {
    echo "<a href='?start=" . max(1, $start_index - 50) . "'>" . max(1, $start_index - 50) . "</a>";
}

if ($req->fetch()[0] > 50) {
    echo "<a href='?start=" . ($start_index + 51) . "'>" . ($start_index + 51) . "</a>";
}

echo "</div>";

?>

