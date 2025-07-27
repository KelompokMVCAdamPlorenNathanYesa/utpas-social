<?php
function activeClass($userUrl, $activeClass = 'border-b-4 border-yellow-400 rounded ') {
    $currentUrl = strtok($_SERVER['REQUEST_URI'], '?');
    $currentUrl = rtrim($currentUrl, '/');
    $userUrl = rtrim($userUrl, '/');

    return ($currentUrl === $userUrl) ? $activeClass : '';
}
