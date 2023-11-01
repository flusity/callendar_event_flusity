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

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $id = intval($_POST['id']);
    $edit_reservation_id = isset($_POST['edit_reservation_id']) ? intval($_POST['edit_reservation_id']) : null;

   // $event_laboratory_id = intval($_POST['event_laboratory_id']);
   // $event_item_id = intval($_POST['event_item_id']);
    $event_users_member_id = intval($_POST['event_users_member_id']);
    $event_target_audience = $_POST['event_target_audience'];
    $reserve_event_time = $_POST['reserve_event_time'];
    $reserve_date = $_POST['reserve_date'];
    $reservation_description = $_POST['reservation_description'];
    $event_status = intval($_POST['event_status']);  

    try {
        if ($edit_reservation_id > 0) {          
           // $sql = "UPDATE " . $prefix['table_prefix'] . "_event_reservation_time SET event_laboratory_id = :event_laboratory_id, event_item_id = :event_item_id, event_users_member_id = :event_users_member_id, event_target_audience = :event_target_audience, reserve_event_time = :reserve_event_time, reserve_date = :reserve_date, reservation_description = :reservation_description, event_status = :event_status WHERE id = :edit_reservation_id";
            $sql = "UPDATE " . $prefix['table_prefix'] . "_event_reservation_time SET  event_users_member_id = :event_users_member_id, event_target_audience = :event_target_audience, reserve_event_time = :reserve_event_time, reserve_date = :reserve_date, reservation_description = :reservation_description, event_status = :event_status WHERE id = :edit_reservation_id";
            $stmt = $db->prepare($sql);
           // $stmt->bindParam(':event_laboratory_id', $event_laboratory_id, PDO::PARAM_INT);
           // $stmt->bindParam(':event_item_id', $event_item_id, PDO::PARAM_INT);
            $stmt->bindParam(':event_users_member_id', $event_users_member_id, PDO::PARAM_INT);
            $stmt->bindParam(':event_target_audience', $event_target_audience, PDO::PARAM_STR);
            $stmt->bindParam(':reserve_event_time', $reserve_event_time, PDO::PARAM_STR);
            $stmt->bindParam(':reserve_date', $reserve_date, PDO::PARAM_STR);
            $stmt->bindParam(':reservation_description', $reservation_description, PDO::PARAM_STR);
            $stmt->bindParam(':edit_reservation_id', $edit_reservation_id, PDO::PARAM_INT);
            $stmt->bindParam(':event_status', $event_status, PDO::PARAM_INT);  

            $stmt->execute();

            $_SESSION['success_message'] = t("Updating the reservation was successful.");
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
    }

    header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/core/tools/addons_model.php?name=event_callendar&id='.$id.'');
    exit();
}
?>
