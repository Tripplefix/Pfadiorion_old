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
        var winOffset,
                winHeight,
                comingBack = false,
                body,
                //mainContOff,        
                scrollToCust = function(pos) {
                    body.animate({
                        scrollTop: pos
                    }, {
                        duration: 1500,
                        queue: false,
                        easing: 'easeInOutQuart'
                    });
                };

        $(function() {
            winHeight = $(window).height();
            winOffset = $(window).scrollTop();
            body = $('body, html');
            var mainContOff = $('#main-container').offset().top;

            $('.main-header').data("container-height", winHeight);


            $('.top-title h2').click(function() {
                scrollToCust($('#main-container').offset().top);
            });

            $('#big-nav li').first().click(function(e) {
                e.preventDefault();
                scrollToCust($('#main-container').offset().top);
            });

            $('#small-nav li').first().click(function(e) {
                e.preventDefault();
                scrollToCust($('#main-container').offset().top);
            });

            $('#goto_organigramm_button').click(function() {
                scrollToCust($('#organigramm').offset().top - 120);
            });

            $('#goto_aboutus_button').click(function() {
                scrollToCust($('#join_us').offset().top - 120);
            });

            //$('#orion_organigramm').attr("style", "filter:url(#dropshadow_org)");
        });

        $(window).load(function() {
            if (document.URL === '<?php echo URL; ?>index/orion') {
                comingBack = false;
                $.scrollTo(winHeight);
            }

            $('.main-header').parallax({
                parallax: 0.6
            });
            $('body').css({display: 'block'});
        });

        $(window).resize(function() {
            var winWidth = $(window).width();
            winHeight = $(window).height();
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
            <p>
                Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. 
            </p>
        </div>
    </section>
    <!-- was ist Pfadi -->
    <section id="whats_scouts">
        <h2>Was ist Pfadi?</h2>
        <div class="g-100">

        </div>
    </section>
    <!-- Eindrücke -->
    <section id="impressions">
        <h2>Eindrücke</h2>
        <div class="g-100">
            <div id="full-width-slider" class="royalSlider heroSlider rsMinW">
                <div class="rsContent">
                    <img class="rsImg" src="<?php echo URL; ?>views/pfadiheim/images/304401.jpg" alt="Beispiel Bild">
                    <div class="infoBlock rsABlock" data-fade-effect="" data-move-offset="10" data-move-effect="top" data-speed="200">
                        <h4>This is an animated block, add any number of them to any type of slide</h4>
                    </div>
                </div>
                <div class="rsContent">
                    <img class="rsImg" src="<?php echo URL; ?>views/pfadiheim/images/Pfadiheim_1.jpg" alt="Beispiel Bild">
                    <div class="infoBlock rsABlock" data-fade-effect="" data-move-offset="10" data-move-effect="top" data-speed="200">
                        <h4>This is a static HTML block</h4>
                    </div>
                </div>
                <div class="rsContent">
                    <img class="rsImg" src="<?php echo URL; ?>views/pfadiheim/images/32968035.jpg" alt="Beispiel Bild">
                    <div class="infoBlock rsABlock" data-fade-effect="" data-move-offset="10" data-move-effect="top" data-speed="200">
                        <h4>This is a static HTML block</h4>
                    </div>
                </div>
                <div class="rsContent">
                    <img class="rsImg" src="<?php echo URL; ?>views/pfadiheim/images/Grillstelle.JPG" alt="Beispiel Bild">
                    <div class="infoBlock rsABlock" data-fade-effect="" data-move-offset="10" data-move-effect="top" data-speed="200">
                        <h4>This is a static HTML block</h4>
                    </div>
                </div>
                <div class="rsContent">
                    <img class="rsImg" src="<?php echo URL; ?>views/pfadiheim/images/Cute-Cats-cats-33440930-1280-800.jpg" alt="Beispiel Bild">
                    <div class="infoBlock rsABlock" data-fade-effect="" data-move-offset="10" data-move-effect="top" data-speed="200">
                        <h4>This is a static HTML block</h4>
                    </div>
                </div>
            </div>
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
        <h2>Anmelden</h2>
        <div class="g-100">
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
        </div>
    </section>
</div>