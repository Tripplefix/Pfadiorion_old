<script src="<?php echo URL; ?>tools/royalslider/jquery.royalslider.min.js"></script>
<link href="<?php echo URL; ?>tools/royalslider/royalslider.css" rel="stylesheet">
<link href="<?php echo URL; ?>tools/royalslider/skins/minimal-white/rs-minimal-white.css" rel="stylesheet">
<script>
    (function() {
        $(function() {
            $('#main_header').data("container-height", $(window).height());
            $('#top_title h2').on("click", function(evt) {
                evt.preventDefault();
                $('body, html').animate({
                    scrollTop: $('#main_container').offset().top
                }, {
                    duration: 1500,
                    queue: false,
                    easing: 'easeInOutQuart'
                });
            });
            $("#impressions_slider").royalSlider({
                fullscreen: {
                    enabled: true,
                    nativeFS: false
                },
                controlNavigation: 'bullets',
                arrowsNav: true,
                keyboardNavEnabled: true,
                autoScaleSlider: true,
                autoScaleSliderWidth: 1400,
                autoScaleSliderHeight: 600,
                imageScaleMode: 'fill',
                globalCaption: true,
                arrowsNavAutoHide: false,
                imgWidth: 1400,
                imgHeight: 933
            });
            
            if ($('html').hasClass('ie8') || navigator.platform.indexOf("iPad") != -1) {
                $('#main_header').removeClass("parallax");
                $('#main_header').height($(window).height());
                $('#main_header').css({
                    backgroundImage: 'url("<?php echo URL; ?>public/images/DSCF1444.jpg")',
                    backgroundRepeat: 'no-repeat',
                    backgroundSize: '115%'
                });
                $('#big_nav').css({transition: 'none', position: 'absolute'});
            }
            
            $('#impressions_slider_fullscreen').on('click', function(){
                $("#impressions_slider").royalSlider('enterFullscreen');
            });
        });

        $(window).on("load", function() {
            $('#main_header').parallax({
                parallax: 0.6
            });
            $('body').css({display: 'block'});
        });

        $(window).on("resize", function() {
            var winHeight = $(window).height();
            $('#main_header').height(winHeight);
            $('#main_header').data("container-height", winHeight);
            $('.parallax_container').height(winHeight);
        });

        function organigramm() {
            $('#org_elem').hover(function() {
                $(this).attr("style", "filter:url(#dropshadow_org)");
            });
        }
    })();
</script>
<div id="main_container">   
    <!-- unsere Abteilung -->
    <section id="about_us">
        <div id="about_us_image">
            <img src="<?php echo URL; ?>public/images/IMG_6837.jpg" />
        </div><div id="about_us_content">
            <h2>Das sind wir</h2>
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
    </section><!-- Eindrücke -->
    <section id="impressions">
        <h2>Eindrücke</h2>
        <div id="impressions_slider" class="royalSlider rsMinW">
            <a class="rsImg" href="<?php echo URL; ?>views/index/images/5.jpg">SoLa 2012</a>
            <a class="rsImg" href="<?php echo URL; ?>views/index/images/2.jpg">HeLa 2013</a>
            <a class="rsImg" href="<?php echo URL; ?>views/index/images/3.jpg">PfiLa 2012</a>
            <a class="rsImg" href="<?php echo URL; ?>views/index/images/4.jpg">Schauenbergtippel 2013</a>
            <a class="rsImg" href="<?php echo URL; ?>views/index/images/1.jpg">HeLa 2013</a>
        </div>
        <div id="impressions_slider_fullscreen" class="no_select">
            Vollbild
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
            <?php
            include("orion_organigramm.html");
            ?>
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
            <a id="join_us_button" class="no_select" href="<?php echo URL; ?>public/download/Anmeldeformular Pfadi Orion.pdf">Anmelden</a>
            <div id="contact_us_button" class="no_select" onclick="(function() {
                        window.location.href = '<?php echo URL; ?>kontakt';
                    })();">Kontakt</div>
        </div>
    </section>
</div>