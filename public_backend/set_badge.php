<?php

session_start();

// Redirect those filthy invaders
if (!isset($_SESSION["userid"]) || !isset($_GET["id"])) {
    header("Location: ../index");
    exit();
}

include("../backend/config.php");
$db = new PDO("mysql:host=" . $server . ";dbname=" . $database . ";charset=UTF8", $user, $pass);

$req = $db->prepare("UPDATE USERS SET IdBadge = :idb WHERE IdUser = :id");
$req->bindParam(":id", $_SESSION["userid"], PDO::PARAM_STR);
$req->bindParam(":idb", ($_GET["id"] == $_SESSION["idbadge"]) ? NULL : $_GET["id"]);
$req->execute();

if ($_GET["id"] == $_SESSION["idbadge"]) {
    $_SESSION["colorbadge"] = null;
} else {
    $req = $db->prepare("SELECT ColorBadge FROM BADGES WHERE IdBadge = :idb");
    $req->bindParam(":idb", $_GET["id"]);
    $req->execute();

    $_SESSION["colorbadge"] = $req->fetch(PDO::FETCH_ASSOC)["ColorBadge"];
}

$_SESSION["idbadge"] = ($_GET["id"] == $_SESSION["idbadge"]) ? NULL : $_GET["id"];

header("Location: ../espace");
exit();

?>