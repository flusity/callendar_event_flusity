<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
date_default_timezone_set('Europe/Vilnius');

require_once 'class_callendar/class_callendar.php';


//$year = 2023;//isset($_GET['year']) ? $_GET['year'] : date("Y");
//$month = 11;//isset($_GET['month']) ? $_GET['month'] : date("m");
//$day = 29; //isset($_GET['day']) ? $_GET['day'] : date("d");
$calendar = new Calendar();
//echo "$year-$month-$day";
if (isset($_SESSION['holidays'])) {
    $holidays = $_SESSION['holidays'];
    $calendar->add_holidays($holidays);
}
if (isset($_SESSION['topics'])) {
    $topics = $_SESSION['topics'];
}

if (isset($_SESSION['events'])) {
    foreach ($_SESSION['events'] as $event) {
        $calendar->add_event(
            $event['id'],
            $event['event_name'],
            $event['when_event_will_start'],
            $event['event_days'],
            $event['event_color']
        );
    }
}

?>
<?=$calendar?>