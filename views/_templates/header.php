<!doctype html>

<!--[if lt IE 9]>
    <html class="ie8">
<![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html>
    <!--<![endif]-->
    <head>
        <title>Pfadi Orion</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="icon" href="<?php echo URL; ?>public/images/favicon.gif" type="image/gif">

        <?php
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);

        $url[0] = !empty($url[0]) ? $url[0] : "index";
        if (file_exists('public/css/' . $url[0] . '.min.css')) {
            echo '<link rel="stylesheet" type="text/css" href="' . URL . 'public/css/' . $url[0] . '.min.css" />';
        }
        ?>
        <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/css/main.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/js/parallax/parallax-skeleton.min.css" />

        <!-- webfonts -->
        <link href='http://fonts.googleapis.com/css?family=Denk+One' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Chelsea+Market' rel='stylesheet' type='text/css'>

        <!-- parallax plugin -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="<?php echo URL; ?>public/js/Orion.min.js"></script>
        <script src="<?php echo URL; ?>public/js/parallax/jquery.parallax-skeleton.min.js"></script>
        <!--[if lt IE 9]>
            <script>
               document.createElement('header');
               document.createElement('nav');
               document.createElement('section');
               document.createElement('article');
               document.createElement('aside');
               document.createElement('footer');
            </script>
         <![endif]-->
        <script>
            //Google Analytics
            (function(i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function() {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-49674561-1', 'pfadiorion.ch');
            ga('require', 'displayfeatures');
            ga('send', 'pageview');

            $(function() {
                Orion.init({
                    serverUrl: '<?php echo URL; ?>'
                });
                var scripts = [
                    '<?php echo URL; ?>public/js/jquery.slides.min.js',
                    '<?php echo URL; ?>public/js/jquery.scrollTo.min.js',
                    '<?php echo URL; ?>public/js/jquery.easing.1.3.min.js'
                ];
                Orion.loadScripts(scripts);

                // only for beta DO NOT INCLUDE IN RELEASE
                $('body').on('click', '#this_is_the_beta_site', function() {
                    $(this).fadeOut(500);
                });
            });
        </script>
        <style>    
            /* only for beta DO NOT INCLUDE IN RELEASE */
            #this_is_the_beta_site{
                /*remove*/
                display: none;

                height: 30px;
                width: 100%;
                background-color: #ff0000;
                color: #FFF;
                position: fixed;
                font-size: 90%;
                font-weight: bold;
                padding: 10px 20px;
                z-index: 1000;
                cursor: pointer;
            }
            #this_is_the_beta_site a{
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
        <div id="tablet_nav_container">
        </div> 
        <div id="this_is_the_beta_site">Du befindest dich auf der Testversion unserer Homepage. Informationen auf dieser Seite sind möglicherweise falsch oder veraltet. Bitte wechle zu unserer richtigen Homepage: <a href="http://pfadiorion.ch">http://pfadiorion.ch</a></div>

        <header id="main_header" class="no_select <?php if ($url[0] == "index" || empty($url[0])): ?> parallax<?php endif; ?>" data-container-height="500" data-image="<?php echo URL; ?>public/images/DSCF1444.jpg" data-with="1600" data-height="1200" data-posy="0">

            <nav id="big_nav" <?php if ($url[0] == "index" || empty($url[0])): ?> style="position: fixed"<?php endif; ?>></nav> 
            <nav id="small_nav"></nav> 

            <?php if ($url[0] == "index" || empty($url[0])): ?>

                <div id="top_title">
                    <h1>Pfadi Orion</h1>
                    <a id="orion_location" href="https://www.google.com/maps/place/Rickenbach+sulz" target="blank">
                        <div id="orion_location">
                            <p>Rickenbach Sulz / Wiesendangen</p>
                        </div> 
                    </a>                     
                    <h2 style="cursor: pointer;">Erfahre mehr über uns</h2>   
                    <h2 style="margin-top: -30px;font-size: 70px; text-align: center; cursor: pointer;">v</h2>
                </div>
            <?php endif; ?>                  
        </header>
