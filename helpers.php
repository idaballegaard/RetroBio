<?php
function relativeDate($date) {
    $today = new DateTime(); // current date and time
    $tomorrow = new DateTime('tomorrow');

    // Reset time to midnight for accurate comparison
    $showingDateOnly = (clone $date)->setTime(0, 0);
    $todayOnly = (clone $today)->setTime(0, 0);
    $tomorrowOnly = (clone $tomorrow)->setTime(0, 0);

    if ($showingDateOnly == $todayOnly) {
        return "Today";
    } elseif ($showingDateOnly == $tomorrowOnly) {
        return "Tomorrow";
    } else {
        return $date->format("d/M/Y");
    }
}

function generateUrl(string $path) {
    $prefix = "/RetroBio";
    if($path === "" || $path === "/") {
        $url = $prefix;
    } else {
        $url = $prefix . "/" . ltrim($path, '/');
    }
    return $url;
}

function safeString(string $input): string {
    return trim(htmlspecialchars($input));
}