<?php

session_start();

// Redirect those filthy requests

if (!isset($_POST["type"])) {
    header("Location: ../index");
    exit();
}


// Handle log in requests

if ($_POST["type"] == "login") {
    // Hash pass to compare with database
    $hashed_pass = hash("sha256", $_POST["password"]);

    include("../backend/config.php");
    $db = new PDO("mysql:host=" . $server . ";dbname=" . $database . ";charset=UTF8", $user, $pass);
    
    $req = $db->prepare("SELECT IdUser, FirstName, LastName, IdBadge FROM USERS WHERE Email = :email AND HashedPass = :hpass");
    $req->bindParam(":email", $_POST["email"], PDO::PARAM_STR);
    $req->bindParam(":hpass", $hashed_pass, PDO::PARAM_STR);
    $req->execute();

    $result = $req->fetch(PDO::FETCH_ASSOC);

    // You're wrong bud
    if (!$result) {
        $_SESSION["bad-login"] = true;
        header("Location: ../espace");
        exit();
    }

    // Get the info
    $_SESSION["userid"] = $result["IdUser"];
    $_SESSION["firstname"] = $result["FirstName"];
    $_SESSION["lastname"] = $result["LastName"];
    $_SESSION["idbadge"] = $result["IdBadge"];

    if ($_SESSION["idbadge"] != null) {
        $req = $db->prepare("SELECT ColorBadge FROM USERS NATURAL JOIN BADGES WHERE IdUser = :id");
        $req->bindParam(":id", $_SESSION["userid"], PDO::PARAM_INT);
        $req->execute();

        $result = $req->fetch(PDO::FETCH_ASSOC);

        $_SESSION["colorbadge"] = $result["ColorBadge"];
    }

    header("Location: ../espace");
    exit();
}

// Handle registering

if ($_POST["type"] == "register") {
    // At first, check captcha

    $hashed_captcha = hash("sha256", $_POST["captcha"]);

    // Blip Blop
    if ($hashed_captcha != $_POST["captcha_string"]) {
        $_SESSION["bad-captcha"] = true;
        header("Location: ../espace?register");
        exit();
    }

    // Add dude to database
    include("../backend/config.php");
    $db = new PDO("mysql:host=" . $server . ";dbname=" . $database . ";charset=UTF8", $user, $pass);
 
    // Is dude in db ?
    $req = $db->prepare("SELECT 1 FROM USERS WHERE Email = :email");
    $req->bindParam(":email", $_POST["email"]);

    if ($req->fetch()) {
        $_SESSION["already"] = true;
        header("Location: ../espace?register");
        exit();
    }

    // Hash pass to add to the data base
    $hashed_pass = hash("sha256", $_POST["password"]);
    $firstname = ucwords(strtolower($_POST["firstname"]), " '-");
    $lastname = ucwords(strtolower($_POST["lastname"]), " '-");

   
    $req = $db->prepare("INSERT INTO USERS (FirstName, LastName, Email, HashedPass, idBadge) VALUES (:f, :l, :e, :h, NULL)");
    $req->bindParam(":f", $firstname, PDO::PARAM_STR);
    $req->bindParam(":l", $lastname, PDO::PARAM_STR);
    $req->bindParam(":e", $_POST["email"], PDO::PARAM_STR);
    $req->bindParam(":h", $hashed_pass, PDO::PARAM_STR);
    $req->execute();

    // Set the connexion
    $_SESSION["userid"] = $db->lastInsertId();
    $_SESSION["firstname"] = $firstname;
    $_SESSION["lastname"] = $lastname;
    $_SESSION["idbadge"] = null;
    
    header("Location: ../espace");
    exit();
}

?>