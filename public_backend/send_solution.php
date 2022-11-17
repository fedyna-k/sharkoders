<?php

session_start();

if (!isset($_SESSION["userid"]) || !isset($_POST["challenge"]) || !isset($_POST["solution"])) {
    header("Location: ../challenges");
    exit();
}

if (!file_exists("../challenges_generators/challenge" . $_POST["challenge"] . ".php")) {
    header("Location: ../challenges");
    exit();
}

include("../challenges_generators/challenge" . $_POST["challenge"] . ".php");

if (!verifySolution($_POST["solution"])) {
    $_SESSION["bad-answer"] = true;

    header("Location: ../challenges?id=" . $_POST["challenge"]);
    exit();
}


include("../backend/config.php");
$db = new PDO("mysql:host=" . $server . ";dbname=" . $database . ";charset=UTF8", $user, $pass);

$req = $db->prepare("UPDATE SOLVE SET DateEnd = NOW() WHERE IdUser = :iduser AND IdExercice = :idexo");
$req->bindParam(":iduser", $_SESSION["userid"]);
$req->bindParam(":idexo", $_POST["challenge"]);
$req->execute();

unlink("../challenge_inputs/" . $_SESSION["userid"] . "_" . $_POST["challenge"] . "_input.txt");

header("Location: ../challenges?id=" . $_POST["challenge"]);

?>