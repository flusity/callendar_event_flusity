<?php 
/*
 @Flusity cms
 Author Darius Jakaitis, author web site https://www.flusity.com
 fix-content
*/
?>
<?php if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
    }
    $translations = ($selected_lang == $lang_code) ? array_merge($translations_, ${"translations_" . $lang_code}) : $translations_en;
                           
?>
<?php require_once 'menu-horizontal.php';  ?>
<header class="masthead register-header" style="background-image: url('/cover/themes/free-time/assets/img/pexels-pixabay-279810.jpg');height: 200px;padding-top: 0px;padding-bottom: 0px;margin-bottom: -16px;">
<div class="overlay register-head-ov" style="height: 200px;background: rgba(0,0,0,0.84);padding-bottom: 0px;"></div>
</header>
    <section class="py-4 py-xl-5" style="margin-top: -3px;">
        <div class="container">
            <div class="row mb-5" style="padding-bottom: 0px;padding-top: 0px;margin-bottom: 0px;">
                <div class="col-md-8 col-xl-6 text-center mx-auto" style="padding-bottom: 0px;">
                <h2><?php echo t("Event time Registration system");?></h2>
                </div>
            </div>
            <div class="row d-flex justify-content-center" style="padding-top: 0px;">
                <div class="col-md-8 col-lg-8 col-xl-6" style="margin-top: -24px;padding-top: 0px;margin-right: 1px;">
                    
                <div class="col-md-12 text-center" style="padding-bottom: 0px;"> 
                   <?php if (isset($_SESSION['error_message'])) :
                                echo "<div class='alert alert-danger alert-dismissible fade show slow-fade'>
                                    " . htmlspecialchars($_SESSION['error_message']) . "
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>";
                                unset($_SESSION['error_message']);
                            endif; 
                        if (isset($_SESSION['success_message'])): ?>
                            <div class="alert alert-success alert-dismissible fade show slow-fade">
                                <?php echo htmlspecialchars($_SESSION['success_message']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php unset($_SESSION['success_message']); ?>
                        <?php endif; 
                            $csrf_token = generateCSRFToken();
                        ?>
                </div>
                    <?php  
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $selectedTime = isset($_POST["selectedTime"]) ? $_POST["selectedTime"] : null;
                            $event_laboratory_id =  isset($_POST["event_laboratory_id"]) ? $_POST["event_laboratory_id"] : null;  // event_callendar_laboratories id
                            $event_item_id =  isset($_POST["event_item_id"]) ? $_POST["event_item_id"] : null; //event_callendar_item id
                            $event_laboratory_title = isset($_POST["event_laboratory_title"]) ? $_POST["event_laboratory_title"] : null; //pavadinimas iš event_callendar_laboratories
                            $event_item_title = isset($_POST["event_item_title"]) ? $_POST["event_item_title"] : null; //pavadinimas iš event_callendar_item
                            $reserve_date = isset($_POST["event_reserve_day"]) ? $_POST["event_reserve_day"] : null;
                            $event_target_audience = isset($_POST["event_target_audience"]) ? $_POST["event_target_audience"] : null;       
                        }
                      ?>
                    <?php
                    if(!isset($_SESSION['member_user_name'])) {?>
                  
                    <p><?php echo isset($translations['are_you_registered_then_you_can_just_log_in']) ? htmlspecialchars(
                        $translations['are_you_registered_then_you_can_just_log_in'], ENT_QUOTES, 'UTF-8') : 'Are you registered? then you can just log in'; ?> <a type="button" class="link" style="cursor: poiner;" data-bs-toggle="modal" data-bs-target="#loginModal"><?php echo isset($translations['login']) ? htmlspecialchars($translations['login'], ENT_QUOTES, 'UTF-8') : 'Login'; ?></a>
                    </p>


                <!-- Modal -->
                    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="loginModalLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <form action="" id="loginMemberForm" method="POST">
                                <input type="text" class="form-control mb-3" name="member_login_name" placeholder="<?php echo htmlspecialchars(isset($translations['login_name']) ? $translations['login_name'] : 'Login Name', ENT_QUOTES, 'UTF-8'); ?>">
                                <input type="password" class="form-control mb-3" name="member_password" placeholder="<?php echo isset($translations['password']) ? htmlspecialchars($translations['password'], ENT_QUOTES, 'UTF-8') : 'Password'; ?>">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="mb-3"><?php echo isset($translations['login']) ? htmlspecialchars($translations['login'], ENT_QUOTES, 'UTF-8') : 'Login'; ?></button>           
                            </form>
                            </div>
                            </div>
                        </div>
                        </div>


                   <?php  } else { 
                     echo " <p> Sveiki <b>". $_SESSION['member_user_name'];
                   ?>  
                    </b>&nbsp; <a id="logoutBtn" class="mb-5" style="cursor: pointer; text-transform: lowercase;"><?php echo isset($translations['logout']) ? htmlspecialchars($translations['logout'], ENT_QUOTES, 'UTF-8') : 'Log out'; ?></a>
                    </p>
                    <?php }  ?>

                   <?php if(isset($selectedTime) && $selectedTime != "") {  ?>

                    <form action="" method="POST" id="registrationForm" onsubmit="return checkPasswordsMatch()">
                   <?php if(isset($_SESSION['member_user_name'])) {?>
                    <input type="hidden" id="member_user_id" name="member_user_id" value="<?php echo htmlspecialchars($_SESSION['member_user_id']); ?>">
                    <?php } ?>
                    <div class="mb-3 row">
                        <div class="col-sm-12">
                            <h2 style="font-weight: 300;"><b><?php echo htmlspecialchars(isset($translations['location']) ? $translations['location'] : 'Location', ENT_QUOTES, 'UTF-8'); ?> </b><?php echo htmlspecialchars($event_laboratory_title, ENT_QUOTES, 'UTF-8'); ?></h2>
                            <input type="hidden" id="reserve_event_laboratory_id" name="reserve_event_laboratory_id" value="<?php echo htmlspecialchars($event_laboratory_id, ENT_QUOTES, 'UTF-8'); ?>">
              
                            <h4 style="font-weight: 300;"><b><?php echo htmlspecialchars(isset($translations['practice']) ? $translations['practice'] : 'Practice', ENT_QUOTES, 'UTF-8'); ?>: </b><?php echo htmlspecialchars($event_item_title, ENT_QUOTES, 'UTF-8'); ?></h4>
                            <input type="hidden" id="event_item_id" name="event_item_id" value="<?php echo htmlspecialchars($event_item_id, ENT_QUOTES, 'UTF-8'); ?>">

                            <h4 style="font-weight: 300;"><b><?php echo htmlspecialchars(isset($translations['audience']) ? $translations['audience'] : 'Audience', ENT_QUOTES, 'UTF-8'); ?>: </b><?php echo htmlspecialchars($event_target_audience, ENT_QUOTES, 'UTF-8'); ?></h4>
                            <input type="hidden" id="event_target_audience" name="event_target_audience" value="<?php echo htmlspecialchars($event_target_audience, ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-sm-5 mb-3" style="min-width: 240px;">
                            <?php echo htmlspecialchars(isset($translations['event_time_and_day_selected']) ? $translations['event_time_and_day_selected'] : 'Event time and day selected', ENT_QUOTES, 'UTF-8'); ?>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <input type="time" class="form-control disable" id="selectedTime" name="reserve_event_time" value="<?php echo htmlspecialchars($selectedTime, ENT_QUOTES, 'UTF-8'); ?>" readonly style="background-color: #f3f3f3; min-width: 80px;">
                        </div>
                        <div class="col-sm-3 mb-3">
                            <input type="date" class="form-control disable" id="reserveDate" name="reserve_date" value="<?php echo htmlspecialchars($reserve_date, ENT_QUOTES, 'UTF-8'); ?>" readonly style="background-color: #f3f3f3; min-width: 80px;">
                        </div>
                        </div>
                                    
                        <div class="mb-3"><input type="text" class="form-control" id="member_login_name" name="member_login_name" placeholder="<?php echo htmlspecialchars(isset($translations['login_name']) ? $translations['login_name'] : 'Login Name', ENT_QUOTES, 'UTF-8'); ?>" required></div>

                        <div class="mb-3"><input type="text" class="form-control" id="member_first_name" name="member_first_name" placeholder="<?php echo isset($translations['first_name']) ? htmlspecialchars($translations['first_name'], ENT_QUOTES, 'UTF-8') : 'First Name'; ?>" required></div>

                        <div class="mb-3"><input type="text" class="form-control" id="member_last_name" name="member_last_name" placeholder="<?php echo isset($translations['last_name']) ? htmlspecialchars($translations['last_name'], ENT_QUOTES, 'UTF-8') : 'Last Name'; ?>" required></div>

                        <div class="mb-3"><input type="text" class="form-control" id="member_telephone" name="member_telephone" placeholder="<?php echo isset($translations['telephone']) ? htmlspecialchars($translations['telephone'], ENT_QUOTES, 'UTF-8') : 'Telephone'; ?>" required></div>

                        <div class="mb-3"><input type="email" class="form-control" id="member_email" name="member_email" placeholder="<?php echo isset($translations['email']) ? htmlspecialchars($translations['email'], ENT_QUOTES, 'UTF-8') : 'Email'; ?>" required></div>

                        <div class="mb-3"><input type="password" class="form-control" id="member_password" name="member_password" placeholder="<?php echo isset($translations['password']) ? htmlspecialchars($translations['password'], ENT_QUOTES, 'UTF-8') : 'Password'; ?>" required></div>

                        <div class="mb-3"><input type="password" class="form-control" id="re_member_password" name="re_member_password" placeholder="<?php echo isset($translations['repeat_password']) ? htmlspecialchars($translations['repeat_password'], ENT_QUOTES, 'UTF-8') : 'Repeat password'; ?>" required></div>

                        <hr class="" style="color: black;">
                        <h4 style="font-weight: 300;"><?php echo isset($translations['additional_information']) ? htmlspecialchars($translations['additional_information'], ENT_QUOTES, 'UTF-8') : 'Additional information'; ?></4>
                        <hr class="" style="color: black;">

                        <div class="mb-3">
                        <input type="text" class="form-control" id="member_institution" name="member_institution" placeholder="<?php echo isset($translations['institution']) ? htmlspecialchars($translations['institution'], ENT_QUOTES, 'UTF-8') : 'Institution';?>">
                        </div>

                        <div class="mb-3">
                        <input type="text" class="form-control" id="member_address_institution" name="member_address_institution" placeholder="<?php echo isset($translations['institution_address']) ? htmlspecialchars($translations['institution_address'], ENT_QUOTES, 'UTF-8') : 'Institution Address';?>" required>
                        </div>

                        <div class="row">
                        <div class="col-sm-4 mb-3">
                        <label for="member_invoice" class="nowrap" style="font-weight: 300;"><?php echo isset($translations['invoice']) ? htmlspecialchars($translations['invoice'], ENT_QUOTES, 'UTF-8') : 'Invoice'; ?></label>
                        </div>
                        <div class="col-sm-2 mb-3">
                            <select class="form-control" id="member_invoice" name="member_invoice">
                                <option value="0"><?php echo isset($translations['no']) ? htmlspecialchars($translations['no'], ENT_QUOTES, 'UTF-8') : 'No'; ?></option>
                                <option value="1"><?php echo isset($translations['yes']) ? htmlspecialchars($translations['yes'], ENT_QUOTES, 'UTF-8') : 'Yes'; ?></option>
                            </select>
                        </div>
                        </div>

                        <div class="mb-3">
                        <input type="text" class="form-control" id="member_employee_position" name="member_employee_position" placeholder="<?php echo isset($translations['employee_position']) ? htmlspecialchars($translations['employee_position'], ENT_QUOTES, 'UTF-8') : 'Employee Position';?>" required>
                        </div>

                        <div class="mb-3">
                        <textarea class="form-control" id="member_description" name="member_description" placeholder="<?php echo isset($translations['additional_information']) ? htmlspecialchars($translations['additional_information'], ENT_QUOTES, 'UTF-8') : 'Additional information';?>"></textarea>
                        </div>

                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

                        <div class="mb-3">
                            <button class="btn btn-primary d-block w-100" type="submit" style="background: rgb(230,227,160);--bs-primary: #7faef2;--bs-primary-rgb: 127,174,242;border-style: none;color: rgb(136,132,132);"><?php echo htmlspecialchars(isset($translations['register_event']) ? $translations['register_event'] : 'Register event', ENT_QUOTES, 'UTF-8'); ?></button>
                        </div>

                    </form>

                    <?php   } else if(empty($selectedTime)){
                           /*  
                            echo "<p>" . (isset($translations['not_selected_event_time']) ? $translations['not_selected_event_time'] : 'You have not selected an event time. Registration is currently suspended. Please try again later.') . "</p>
                            <div class='container mt-5 mb-3 no-register'></div>"; }  else  {
                            */
                        
                            echo "<p>" . (isset($translations['event_up']) ? $translations['event_up'] : '') . "</p>
                            <div class='container mt-5 mb-3 register'></div>";
                        } 
                    ?>
                        <p><?php echo isset($translations['go_to']) ? $translations['go_to'] : 'Go to'; ?>&nbsp;<a href="/" class="btn-link"><?php echo strtolower(isset($translations['home_page']) ? $translations['home_page'] : 'Home page'); ?></a>&nbsp;<?php echo isset($translations['or']) ? $translations['or'] : 'or';?>&nbsp;
                        <?php echo isset($translations['back_to']) ? $translations['back_to'] : 'back to'; ?>&nbsp;<a href="/event-calendar" class="btn-link"><?php echo strtolower(isset($translations['event_calendar']) ? $translations['event_calendar'] : 'Event calendar'); ?></a>&nbsp;<p>

                    </div>
                </div>
            </div>
    </section>
        
<script>
    var translations = <?php echo json_encode($translations); ?>;
</script>