<?php

session_start();

$languages = [
    "Assembleur", "Basic", "Brainfuck",
    "C", "C++", "C#", "Fortran", "Go",
    "Haskell", "Java", "JavaScript", "Kotlin",
    "Lisp", "Lua", "Matlab", "MIPS", "Objective-C", "OCaml",
    "Pascal", "Perl", "PHP", "Python", "R", "Ruby", "Rust",
    "Scilab", "Swift"
];

if (!isset($_SESSION["userid"]) || !isset($_SESSION["last_unstarted_challenge"]) || !in_array($_POST["language"], $languages)) {
    header("Location: ../challenges");
    exit();
}


include("../backend/config.php");
$db = new PDO("mysql:host=" . $server . ";dbname=" . $database . ";charset=UTF8", $user, $pass);

$req = $db->prepare("INSERT INTO SOLVE VALUES (:iduser, :idexo, :solval, NOW(), NULL, :lang)");
$req->bindParam(":iduser", $_SESSION["userid"]);
$req->bindParam(":idexo", $_SESSION["last_unstarted_challenge"]);
$req->bindParam(":lang", $_POST["language"]);

// The function solutionGenerator() must be in every challenges generator.
// This function must create a file in challenges_inputs using the format
//
//      ${IdUser}_${IdExercice}_input.txt
//
// Then the function returns the solution to the generated input

include("../challenges_generators/challenge" . $_SESSION["last_unstarted_challenge"] . ".php");
$req->bindParam(":solval", challengeGenerator());

$req->execute();

header("Location: ../challenges?id=" . $_SESSION["last_unstarted_challenge"]);
unset($_SESSION["last_unstarted_challenge"]);

?>