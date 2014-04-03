<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script src="<?php echo URL; ?>tools/royalslider/jquery.royalslider.min.js"></script>
<link href="<?php echo URL; ?>tools/royalslider/royalslider.css" rel="stylesheet">
<link href="<?php echo URL; ?>tools/royalslider/skins/minimal-white/rs-minimal-white.css" rel="stylesheet">
<script>
    (function() {
        $(function() {
            $('.main-header').data("container-height", $(window).height());
            $('.top-title h2').on("click", function(evt) {
                evt.preventDefault();
                $('body, html').animate({
                    scrollTop: $('#main-container').offset().top
                }, {
                    duration: 1500,
                    queue: false,
                    easing: 'easeInOutQuart'
                });
            });
            $('#full-width-slider').royalSlider({
                arrowsNav: true,
                loop: false,
                keyboardNavEnabled: true,
                controlsInside: false,
                imageScaleMode: 'fill',
                arrowsNavAutoHide: false,
                autoScaleSlider: true,
                autoScaleSliderWidth: 960,
                autoScaleSliderHeight: 350,
                controlNavigation: 'bullets',
                thumbsFitInViewport: false,
                navigateByClick: true,
                startSlideId: 0,
                autoPlay: false,
                transitionType: 'move',
                globalCaption: false,
                deeplinking: {
                    enabled: true,
                    change: false
                },
                /* size of all images http://help.dimsemenov.com/kb/royalslider-jquery-plugin-faq/adding-width-and-height-properties-to-images */
                imgWidth: 1400,
                imgHeight: 680
            });
            if ($('html').hasClass('ie8')) {
                $('.main-header').removeClass("parallax");
                $('.main-header').height($(window).height());
                $('.main-header').css({
                    backgroundImage: 'url("<?php echo URL; ?>public/images/DSCF1444.jpg")',
                    backgroundRepeat: 'no-repeat',
                    backgroundSize: '100%'
                });
            }
        });

        $(window).on("load", function() {
            $('.main-header').parallax({
                parallax: 0.6
            });
            $('body').css({display: 'block'});
        });

        $(window).on("resize", function() {
            var winHeight = $(window).height();
            $('.main-header').height(winHeight);
            $('.main-header').data("container-height", winHeight);
            $('.parallax-container').height(winHeight);
        });

        function organigramm() {
            $('#org_elem').hover(function() {
                $(this).attr("style", "filter:url(#dropshadow_org)");
            });
        }
    })();
</script>
<div id="main-container">   
    <!-- unsere Abteilung -->
    <section id="about-us">
        <div id="about-us-image">
            <img src="<?php echo URL; ?>public/images/IMG_6837.jpg" />
        </div><div id="about-us-content">
            <h2>Wer wir sind</h2>
            <p>Wir sind, Wölfli, Pfader, Pios und Rover! Wir lieben Action und Abenteuer! Wir sind die Pfadiabteilung Orion!</p>

            <p>Die gesamte Abteilung besteht aus ca. 50 Kindern und Jugendlichen im Alter von 6 
                bis 16 Jahren, sowie etwas mehr als 20 Leiter und Leiterinnen, die den Kids Samstag 
                für Samstag Programm in der freien Natur bieten. Die Abteilung Orion ist der Region 
                Winterthur angehörig.</p>

            <p>Wir geben uns sehr Mühe, den Kindern und Jugendlichen in unserer Abteilung ein 
                abwechslungsreiches Programm zu bieten, bei dem sie einerseits die Natur näher 
                kennenlernen, anderseits aber auch die Gesellschaft untereinander nicht zu kurz 
                kommt. Wer zu uns in die Pfadi kommt, dem wird bestimmt nie langweilig!</p>
        </div>
    </section>
    <!-- was ist Pfadi -->
    <section id="whats_scouts">
        <h2>Was ist Pfadi?</h2>
        <div>
            <p>Die Pfadi ist ein weltweiter religiös und politisch unabhängiger Verband mit dem Ziel, 
                junge Menschen bei ihrer Entwicklung zu fördern, damit diese in der Gesellschaft Verantwortung übernehmen können. </p>
            <p>Die Pfadibewegung Schweiz (PBS) ist mit über 40'000 Mitgliedern die grösste Jugendorganisation hierzulande. 
                Sie ist in 22 kantonalen Verbänden und rund 600 lokalen Abteilungen und Gruppen organisiert.</p>
            <p>Mehr Infos und Eindrücke zur Pfadi findest du hier: </p>
            <a href="http://www.pfadi.ch/" target="_blank">Pfadi.ch</a>
        </div>
    </section>
    <!-- unsere Organisation -->
    <section id="organigramm">
        <h2>Unsere Organisation</h2>
        <div class="g-100">
            <div id="organigramm-image">
                <?php
                include("orion_organigramm.html");
                ?>
            </div>
        </div>
    </section>
    <!-- unsere Organisation -->
    <section id="join_us">
        <h2>Besuche uns</h2>
        <div id="join_us_text">
            <p>
                Hast du Lust und Zeit regelmässig am Samstag die Natur auf eine andere Art zu erleben? 

                Möchtest du bräteln, Geschichten und Action erleben? Über Seilbrücken laufen und 

                Pfeilbogen basteln? – Dann bist du bei uns genau richtig! </p>
            <p>

                Komm doch einfach mal vorbei und schau wie's dir gefällt, ganz unverbindlich.</p>
            <p>
                Wenn es dir dann gefallen hat, darfst du gerne in unserem "Download"-Bereich die 

                Anmeldung downloaden, ausfüllen und an uns zurücksenden.</p>
            <p>
                Bei Fragen stehen dir unsere Trupp- und Abteilungsleiter gerne zur Verfügung.
            </p>
            <div id="join_us_button" onclick="(function() {
                        window.location.href = '<?php echo URL; ?>kontakt';
                    })();">Kontakt</div>
        </div>
    </section>
</div>