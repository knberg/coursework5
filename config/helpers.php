<?php


function clearPath($path) {
    $pos = strpos($path, '?');
    if ($pos === false) return $path;
    return substr($path, 0, $pos);
}

function debug($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

function redirect($page){
    header('Location: ' . $page);
}

function checkAuthorization() {
    return isset($_SESSION['user_role']);
}

function getUserRole($required) {
    return $_SESSION['user_role'] ?? 'guest';
}

function checkUserRole($required) {
    $role = $_SESSION['user_role'] ?? 'guest';
    return $role == $required;
}