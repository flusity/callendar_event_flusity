<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
    
}

unset($_SESSION['member_user_id']);
unset($_SESSION['member_user_name']);
session_destroy();

echo 'logged_out';
exit;
?>