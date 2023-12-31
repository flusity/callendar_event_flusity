<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

define('IS_ADMIN', true);
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/');

require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';

try {
    $db = getDBConnection($config);
    secureSession($db, $prefix);

    if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST['member_user_id'])) {
        $password = $_POST['member_password'];
       
        $selectedTime = $_POST['reserve_event_time'];
        $reserve_date = $_POST['reserve_date'];
        $event_laboratory_id = $_POST['reserve_event_laboratory_id'];
        $event_item_id = $_POST['event_item_id'];
        $event_target_audience = $_POST['event_target_audience'];
        $reservation_description = $_POST['member_description'];

        $member_login_name = $_POST['member_login_name'];
        $member_first_name = $_POST['member_first_name'];
        $member_last_name = $_POST['member_last_name'];
        $member_telephone = $_POST['member_telephone'];
        $member_email = $_POST['member_email'];
        $member_institution = $_POST['member_institution'];
        $member_address_institution = $_POST['member_address_institution'];
        $member_invoice = $_POST['member_invoice'];
        $member_employee_position = $_POST['member_employee_position'];

            $checkUserQuery = "SELECT * FROM " .  $prefix['table_prefix'] . "_callendar_users_member WHERE member_login_name = ? OR member_email = ?";
            $checkUserStmt = $db->prepare($checkUserQuery);
            $checkUserStmt->execute([$member_login_name, $member_email]);
       
            if ($checkUserStmt->fetch()) { 
                echo 'exists';
                exit(); 
            } 
       
            echo 'success';

            $hashed_member_password = password_hash($password, PASSWORD_DEFAULT);

            $sql2 = "INSERT INTO " .  $prefix['table_prefix'] . "_callendar_users_member (member_login_name, member_first_name, member_last_name, member_telephone, member_email, member_institution, member_address_institution, member_invoice, member_password, member_employee_position) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt2 = $db->prepare($sql2);

            $stmt2->execute([$member_login_name, $member_first_name, $member_last_name, $member_telephone, $member_email, $member_institution, $member_address_institution, $member_invoice, $hashed_member_password, $member_employee_position]);
            $lastInsertMemberId = $db->lastInsertId();

            $sql1 = "INSERT INTO " .  $prefix['table_prefix'] . "_event_reservation_time (event_laboratory_id, event_item_id, event_users_member_id, event_target_audience, reserve_event_time, reserve_date, reservation_description) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt1 = $db->prepare($sql1);

            $stmt1->execute([$event_laboratory_id, $event_item_id, $lastInsertMemberId, $event_target_audience, $selectedTime, $reserve_date, $reservation_description]);

            $_SESSION['success_message'] = t("The activity has been successfully submitted for registration, please wait for confirmation via the email you provided.");
            header("Location: registration-member.php?message=success");
            exit();
 
        } else if(isset($_POST['member_user_id'])){

            $member_user_id = $_POST['member_user_id'];
            $selectedTime = $_POST['reserve_event_time'];
            $reserve_date = $_POST['reserve_date'];
            $event_laboratory_id = $_POST['reserve_event_laboratory_id'];
            $event_item_id = $_POST['event_item_id'];
            $event_target_audience = $_POST['event_target_audience'];
            $reservation_description = $_POST['member_description'];
           
            if (isset($member_user_id)) {
                echo 'success';
            } else {
                 if ($checkUserStmt->fetch()) { 
                    echo 'exists';
                    exit(); 
                } 
            }
            echo 'success'; 

            $sql1 = "INSERT INTO " .  $prefix['table_prefix'] . "_event_reservation_time (event_laboratory_id, event_item_id, event_users_member_id, event_target_audience, reserve_event_time, reserve_date, reservation_description) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt1 = $db->prepare($sql1);

            $stmt1->execute([$event_laboratory_id, $event_item_id, $member_user_id, $event_target_audience, $selectedTime, $reserve_date, $reservation_description]);

            $_SESSION['success_message'] = t("The activity has been successfully submitted for registration, please wait for confirmation via the email you provided");
            header("Location: registration-member.php?message=success");
            exit();
        } 
    
} catch (Exception $e) {
   // error_log($e->getMessage());
   // $_SESSION['error_message'] = "Įvyko klaida. Prašome bandyti vėliau arba kreiptis į sistemos administratorių.";
}

?>
