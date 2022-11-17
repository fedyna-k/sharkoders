<?php
function getDiffTimeText ($diffInSeconds) {
    $diff = array();
    $text = "";

    $diff["days"] = floor($diffInSeconds / 86400);
    $diffInSeconds = $diffInSeconds % 86400;

    $diff["hours"] = floor($diffInSeconds / 3600);
    $diffInSeconds = $diffInSeconds % 3600;

    $diff["minutes"] = floor($diffInSeconds / 60);
    $diffInSeconds = $diffInSeconds % 60;

    $diff["seconds"] = $diffInSeconds;

    if ($diff["days"]) {
        $text .= $diff["days"] . "jours, " . $diff["hours"] . ":" . $diff["minutes"] . ":" . $diff["seconds"];
    } elseif ($diff["hours"]) {
        $text .= $diff["hours"] . ":" . $diff["minutes"] . ":" . $diff["seconds"];
    } elseif ($diff["minutes"]) {
        if ($diff["minutes"] == 1) {
            $text .= $diff["minutes"] . "minute " . $diff["seconds"];
        } else {
            $text .= $diff["minutes"] . "minutes " . $diff["seconds"];
        }
    } else {
        if ($diff["seconds"] == 1) {
            $text .= $diff["seconds"] . "seconde";
        } else {
            $text .= $diff["seconds"] . "secondes";
        }
    }

    return $text;
}
?>