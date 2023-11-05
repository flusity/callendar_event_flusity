<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

define('IS_ADMIN', true);
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/');

require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';

$db = getDBConnection($config);
secureSession($db, $prefix);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginName = $_POST['member_login_name'];
    $password = $_POST['member_password'];

    try {
        $sql = "SELECT id, member_first_name, member_password FROM " .  $prefix['table_prefix'] . "_callendar_users_member WHERE member_login_name = :login_name";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':login_name', $loginName, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result && password_verify($password, $result['member_password'])) {
    
            $_SESSION['member_user_id'] = $result['id'];
            $_SESSION['member_user_name'] = $result['member_first_name'];
            echo 'success';
        } else {
            echo 'error';
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        $_SESSION['error_message'] = "Įvyko klaida. Prašome bandyti vėliau arba kreiptis į sistemos administratorių.";
    }
}
?>
