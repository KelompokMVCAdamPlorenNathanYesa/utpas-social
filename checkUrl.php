<?php 

function checkUrl($userUrl) {
    $currentUrl = strtok($_SERVER['REQUEST_URI'], '?');
    $currentUrl = rtrim($currentUrl, '/');
    $userUrl = rtrim($userUrl, '/');

    if ($currentUrl === $userUrl) {
        return true;
    } else {
        return false;
    }
}