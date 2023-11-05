<?php 
/*
 @Flusity cms
 Author Darius Jakaitis, author web site https://www.flusity.com
 fix-content
*/
 if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
    }

?>
<?php require_once 'menu-horizontal.php';  ?>
<header class="masthead register-header" style="background-image: url('/cover/themes/free-time/assets/img/pexels-pixabay-279810.jpg');height: 200px;padding-top: 0px;padding-bottom: 0px;margin-bottom: -16px;">
<div class="overlay register-head-ov" style="height: 200px;background: rgba(0,0,0,0.84);padding-bottom: 0px;"></div>
</header>
 
    <section class="py-4 py-xl-5" style="margin-top: -3px;">
        <div class="container">
            <div class="row ">
                <div class="col-md-8 col-xl-6 text-center mx-auto" style="padding-bottom: 0px;">
                <h2><?php echo t("Event callendar");?></h2> 
                    
                </div>
            </div>
            <div class="row d-flex justify-content-center">
            <?php
            if (isset($_SESSION['success_message'])) {
                echo "<div class='alert alert-success alert-dismissible fade show slow-fade'>
                    " . htmlspecialchars($_SESSION['success_message']) . "
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
                unset($_SESSION['success_message']);
            }

            if (isset($_SESSION['error_message'])) {
                echo "<div class='alert alert-danger alert-dismissible fade show slow-fade'>
                    " . htmlspecialchars($_SESSION['error_message']) . "
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
                unset($_SESSION['error_message']);
            }
            ?>
</div>
    <div class="row">
            <div class="col-md-12 mb-2 p-2"> 
            <?php if(!isset($_SESSION['user_logged_in'])): ?> 
                 
                <?php
                    if(isset($_SESSION['member_user_name'])): 
                        ?>
                    <p><?php echo isset($translations['logged_in_as']) ? htmlspecialchars( $translations['logged_in_as'], ENT_QUOTES, 'UTF-8') : 'Logged in as'; ?>&nbsp;<b><?php echo $_SESSION['member_user_name'];?></b> &nbsp;<a style="cursor: pointer; text-transform: lowercase;" id="logoutBtn" class="mb-5" style="cursor: pointer;"><?php echo isset($translations['logout']) ? htmlspecialchars($translations['logout'], ENT_QUOTES, 'UTF-8') : 'Log out'; ?></a></p>
                
                    <?php  else: ?>
                        <p><?php echo isset($translations['are_you_registered_then_you_can_just_log_in']) ? htmlspecialchars( $translations['are_you_registered_then_you_can_just_log_in'], ENT_QUOTES, 'UTF-8') : 'Are you registered? then you can just log in'; ?> <a type="button" class="link" style="cursor: poiner;" data-bs-toggle="modal" data-bs-target="#loginModal"><?php echo isset($translations['login']) ? htmlspecialchars($translations['login'], ENT_QUOTES, 'UTF-8') : 'Login'; ?></a>
                        </p>
                    <?php 
                    endif;   
                 endif; ?>
                
                    <!-- Modal -->
                    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="loginModalLabel"  style="font-weight: 300;">
                            <?php echo isset($translations['member_login_form']) ? htmlspecialchars($translations['member_login_form'], ENT_QUOTES, 'UTF-8') : 'Member login form'; ?>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="" id="loginMemberForm" method="POST">
                            <input type="text" class="form-control mb-3" name="member_login_name" placeholder="<?php echo htmlspecialchars(isset($translations['login_name']) ? $translations['login_name'] : 'Login Name', ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="password" class="form-control mb-3" name="member_password" placeholder="<?php echo isset($translations['password']) ? htmlspecialchars($translations['password'], ENT_QUOTES, 'UTF-8') : 'Password'; ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary mb-3"><?php echo isset($translations['login']) ? htmlspecialchars($translations['login'], ENT_QUOTES, 'UTF-8') : 'Login'; ?></button>           
                        </form>
                        </div>
                        </div>
                    </div>
                    </div>

                <?php 
                    $page_url = getCurrentPageUrl($db, $prefix);
                    if ($page_url) {
                        displayPlace($db, $prefix, $page_url, 'callendar-full-12');
                    } else {
                        print "";
                    }
                    ?>
            </div>
            </div>
        </div>
    </section>     
    
<script>
    var translations = <?php echo json_encode($translations); ?>;
</script>