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

function generateUrl(string $path): string {
    $data = parse_ini_file(__DIR__ . "/.env");
    $prefix = $data['URL_PREFIX'] ?? "";
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

function requestLoginRedirectIfNeeded(): void {
    if (isset($_SESSION['user_id'])) {
        return; // User is logged in, no need to redirect
    }
    
    $loginUrl = generateUrl("login") . "?showRequestLogin=1";
    header("Location: " . $loginUrl);
    exit();
}