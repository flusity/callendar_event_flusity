<?php 
/*
 @MiniFrame css karkasas Lic GNU
 Author Darius Jakaitis, author web site https://www.flusity.com
 fix-content
*/
 if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
    }

    require_once 'core/functions/functions.php';

   
    list($db, $config, $prefix) = initializeSystem();
    secureSession($db, $prefix);
    $settings = getSettings($db, $prefix);

    $lang_code = $settings['language']; // Kalbos kodas
    $bilingualism = $settings['bilingualism'];

    require_once "join.php";
    require_once getThemePath($db, $prefix, '/template/header.php'); 
     if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
        echo '<link rel="stylesheet" href="/core/tools/css/edit.css">';
    }
    $language_code = getLanguageSetting($db, $prefix);
    $translations = getTranslations($db, $prefix, $language_code);
    require_once getThemePath($db, $prefix, '/template/registration_member.php');
 
    require_once getThemePath($db, $prefix, '/template/footer.php');
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
        echo '<script src="/core/template/js/editable.js"></script>
        <script src="/core/template/js/edit.js"></script>';
    }
?>
</body>
</html>
