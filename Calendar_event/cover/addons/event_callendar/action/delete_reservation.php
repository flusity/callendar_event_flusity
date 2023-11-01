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
$language_code = getLanguageSetting($db, $prefix);
$translations = getTranslations($db, $prefix, $language_code);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_reservation_id'])) 
{  $id = intval($_GET['id']); 
    $delete_reservation_id = intval($_GET['delete_reservation_id']);

    try {
        $sql = "DELETE FROM " . $prefix['table_prefix'] . "_event_reservation_time WHERE id = :delete_reservation_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':delete_reservation_id', $delete_reservation_id, PDO::PARAM_INT);

        $stmt->execute();
        $_SESSION['success_message'] = t("Deleting the reservation was successful.");
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
    }

    header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/core/tools/addons_model.php?name=event_callendar&id='.$id.'');
    exit();
}
?>