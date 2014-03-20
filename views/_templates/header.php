<!doctype html>
<html>
    <head>
        <title>Pfadi Orion</title>
        <meta charset="utf-8">
        <link rel="icon" href="<?php echo URL; ?>public/images/favicon.gif" type="image/gif">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="<?php echo URL; ?>public/js/custom.js"></script>
        <script src="<?php echo URL; ?>public/js/navigation.js"></script>
        <script src="<?php echo URL; ?>public/js/jquery.slides.min.js"></script>
        <script src="<?php echo URL; ?>public/js/jquery.scrollTo.min.js" type="text/javascript"></script>
        <script src="<?php echo URL; ?>public/js/jquery.easing.1.3.js" type="text/javascript"></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

        <!-- Less compiler -->
        <?php
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);

        $url[0] = !empty($url[0]) ? $url[0] : "index";
        if (file_exists('public/css/' . $url[0] . '.less')) {
            echo '<link rel="stylesheet/less" type="text/css" href="' . URL . 'public/css/' . $url[0] . '.less" />';
        }
        ?>
        <link rel="stylesheet/less" type="text/css" href="<?php echo URL; ?>public/css/main.less" />
        <script src="<?php echo URL; ?>public/js/less-1.5.0.min.js" type="text/javascript"></script>

        <!-- webfonts -->
        <link href='http://fonts.googleapis.com/css?family=Denk+One' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Chelsea+Market' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>

        <!-- parallax plugin -->
        <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/js/parallax/parallax-skeleton.css" />
        <script src="<?php echo URL; ?>public/js/parallax/jquery.parallax-skeleton.js"></script>
        <script>
            (function() {
                document.getServerUrl = function() {
                    return "<?php echo URL; ?>";
                };

                colors = {
                    red: '#CC3D18',
                    violet: '#4710B5',
                    white: '#FFF',
                    black: '#000'
                }
            }());

            $(window).load(function() {
                //$('body, html').css({scrollTop: 0});
            });
        </script>
        <style>
            #logged_in_panel{
                position: fixed;
                top: 0;
                left: 100px;
                padding: 10px 10px 5px 10px;
                height: 30px;
                background-color: #1e2029;
                z-index: 901;
            }
            #logged_in_panel form{
                color: #FFF;
            }    
        </style>
    </head>
    <body>
        <?php if (Session::get('user_logged_in') == true): ?>
            <div id="logged_in_panel">
                <form method="GET" action="<?php echo URL; ?>admin/login/logout">
                    Du bist angemeldet als <?php echo Session::get('user_name') ?>
                    <input type="submit" value="Logout" />
                </form>
            </div>
        <?php endif; ?>   
        <div id="tablet-nav-container">
        </div> 

        <header class="main-header no_select <?php if ($url[0] == "index" || empty($url[0])): ?> parallax<?php endif; ?>" data-container-height="500" data-image="<?php echo URL; ?>public/images/DSCF1444.jpg" data-with="1600" data-height="1200" data-posy="0">

            <nav id="big-nav" <?php if ($url[0] == "index" || empty($url[0])): ?> style="position: fixed"<?php endif; ?>></nav> 
            <nav id="small-nav"></nav> 

            <?php if ($url[0] == "index" || empty($url[0])): ?>


                <div class="top-title">
                    <h1>Pfadi Orion</h1>
                    <h2 style="cursor: pointer;">Erfahre mehr über uns</h2>     
                    <h2 style="margin-top: -50px;font-size: 130px; text-align: center; cursor: pointer;">v</h2>
                </div>
            <?php endif; ?>                  
        </header>
