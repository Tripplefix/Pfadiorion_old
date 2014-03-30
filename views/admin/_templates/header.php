<!doctype html>
<html>
    <head>        
        <title>Pfadi Orion</title>
        <meta charset="utf-8">
        <script src="<?php echo URL; ?>public/js/jquery-1.10.1.min.js"></script>
        <script src="<?php echo URL; ?>public/js/timepicker/jquery.timePicker.js"></script>
        <script src="<?php echo URL; ?>tools/ckeditor/ckeditor.js"></script>   
        <script src="<?php echo URL; ?>tools/ckeditor/adapters/jquery.js"></script>
        <script src="<?php echo URL; ?>tools/notify.min.js"></script>
        <script src="<?php echo URL; ?>tools/jquery-ui/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script src="<?php echo URL; ?>public/js/admin.js"></script>

        <link rel="stylesheet" href="<?php echo URL; ?>public/css/admin/reset.css" />
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/admin/default.css" />
        <link rel="stylesheet" href="<?php echo URL; ?>public/js/timepicker/timePicker.css" />
        <link rel="stylesheet" href="<?php echo URL; ?>tools/jquery-ui/css/dot-luv/jquery-ui-1.10.3.custom.min.css" />
    </head>
    <body>

        <div class='title-box'>
            <a href="<?php echo URL; ?>">Pfadi Orion Administration</a>
        </div>

        <div class="header">

            <div class="header_left_box">
                <ul id="menu">
                    <!-- <li <?php
                    if ($this->checkForActiveController($filename, "index")) {
                        echo ' class="active" ';
                    }
                    ?> >
                        <a href="<?php echo URL; ?>admin/index">Übersicht</a>
                    </li>  -->       
                    <?php if (Session::get('user_logged_in') == true): ?>
                        <li <?php
                        if ($this->checkForActiveController($filename, "dashboard")) {
                            echo ' class="active" ';
                        }
                        ?> >
                            <a href="<?php echo URL; ?>admin/dashboard">Dashboard</a>	
                        </li>   
                    <?php endif; ?> 
                    <?php if (Session::get('user_logged_in') == true): ?>
                        <li <?php
                        if ($this->checkForActiveController($filename, "notice")) {
                            echo ' class="active" ';
                        }
                        ?> >
                            <a href="<?php echo URL; ?>admin/notice">Onlineanschlag</a>
                        </li>   
                    <?php endif; ?>                           
                    <?php if (Session::get('user_logged_in') == true): ?>
                        <li <?php
                        if ($this->checkForActiveController($filename, "news")) {
                            echo ' class="active" ';
                        }
                        ?> >
                            <a href="<?php echo URL; ?>admin/news">Beiträge verwalten</a>
                        </li>                  
                    <?php endif; ?>                     
                    <?php if (Session::get('user_logged_in') == true && (Session::get('user_access_level') == 5 || Session::get('user_is_admin') == 1)): ?>
                        <li <?php
                        if ($this->checkForActiveController($filename, "pfadiheim")) {
                            echo ' class="active" ';
                        }
                        ?> >
                            <a href="<?php echo URL; ?>admin/pfadiheim">Heim Verwaltung</a>
                        </li>                  
                    <?php endif; ?>             
                    <?php if (Session::get('user_logged_in') == true && (Session::get('user_access_level') == 5 || Session::get('user_is_admin') == 1)): ?>
                        <li <?php
                        if ($this->checkForActiveController($filename, "users")) {
                            echo ' class="active" ';
                        }
                        ?> >
                            <a href="<?php echo URL; ?>admin/users">User Verwaltung</a>
                        </li>                  
                    <?php endif; ?>    

                    <?php if (Session::get('user_logged_in') == true): ?>
                        <li <?php
                        if ($this->checkForActiveController($filename, "login")) {
                            echo ' class="active" ';
                        }
                        ?> >
                            <!--<a href="#">My Account</a>-->
                            <a href="<?php echo URL; ?>admin/login/showprofile">Mein Profil</a>
                            <ul class="sub-menu">  
                                <!-- <li <?php
                                if ($this->checkForActiveController($filename, "login")) {
                                    echo ' class="active" ';
                                }
                                ?> >
                                    <a href="<?php echo URL; ?>admin/login/edituseremail">E-Mail Adresse &auml;ndern</a>
                                </li>  -->
                                <li <?php
                                if ($this->checkForActiveController($filename, "login")) {
                                    echo ' class="active" ';
                                }
                                ?> >
                                    <a href="<?php echo URL; ?>admin/login/uploadavatar">Profilbild hochladen</a>
                                </li>    
                                <li <?php
                                if ($this->checkForActiveController($filename, "login")) {
                                    echo ' class="active" ';
                                }
                                ?> >
                                    <a href="<?php echo URL; ?>admin/login/logout">Logout</a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>          

                    <!-- for not logged in users -->
                    <?php if (Session::get('user_logged_in') == false): ?>

                        <li <?php
                        if ($this->checkForActiveControllerAndAction($filename, "login/index")) {
                            echo ' class="active" ';
                        }
                        ?> >
                            <a href="<?php echo URL; ?>admin/login/index">Login</a>
                        </li>  
                        <!-- <li <?php
                        if ($this->checkForActiveControllerAndAction($filename, "login/requestpasswordreset")) {
                            echo ' class="active" ';
                        }
                        ?> >
                            <a class="disabled_link" href="<?php echo URL; ?>admin/login/requestpasswordreset">Passwort vergessen(funktion in Arbeit)</a>
                        </li> -->

                    <?php endif; ?>

                </ul>   
            </div>

            <?php if (Session::get('user_logged_in') == true): ?>
                <div class="header_right_box">

                    <div class="namebox">
                        Hallo <?php echo Session::get('user_name'); ?> !
                    </div>

                    <div class="avatar">
                        <?php if (Session::get('user_avatar_file') == ""): ?>
                            <img width="44" height="44" src='<?php echo URL; ?>public/avatars/missing.jpg' />
                        <?php else: ?> 
                            <img width="44" height="44" src='<?php echo Session::get('user_avatar_file'); ?>' />
                        <?php endif; ?>
                    </div>                

                </div>
            <?php endif; ?>

            <div class="clear-both"></div>

        </div>	
