<?php

session_start();

unset($_SESSION["userid"]);
unset($_SESSION["firstname"]);
unset($_SESSION["lastname"]);
unset($_SESSION["members"]);
unset($_SESSION["idbadge"]);
unset($_SESSION["colorbadge"]);

header("Location: espace");
exit();

?>