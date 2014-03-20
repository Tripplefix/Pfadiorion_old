<?php ?>
<script src="<?php echo URL; ?>tools/royalslider/jquery.royalslider.min.js"></script>
<link href="<?php echo URL; ?>tools/royalslider/royalslider.css" rel="stylesheet">
<link href="<?php echo URL; ?>tools/royalslider/skins/minimal-white/rs-minimal-white.css" rel="stylesheet">
<script>
// The following example creates a marker in Stockholm, Sweden
// using a DROP animation. Clicking on the marker will toggle
// the animation between a BOUNCE animation and no animation.

    var sulz = new google.maps.LatLng(47.521312, 8.787713);
    var phSandacker = new google.maps.LatLng(47.538319, 8.787542);
    var marker;
    var map;

    function initialize() {
        var mapOptions = {
            scrollwheel: true,
            zoom: 13,
            center: sulz
        };

        map = new google.maps.Map(document.getElementById('map-canvas'),
                mapOptions);

        marker = new google.maps.Marker({
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP,
            position: phSandacker
        });
        google.maps.event.addListener(marker, 'click', toggleBounce);
    }

    function toggleBounce() {

        if (marker.getAnimation() != null) {
            marker.setAnimation(null);
        } else {
            marker.setAnimation(google.maps.Animation.BOUNCE);
        }
    }

    google.maps.event.addDomListener(window, 'load', initialize);

    (function() {

        //var red = '#CF5C3F';
        var red = '#CC3D18',
                violet = '#4710B5',
                white = '#FFF',
                black = '#000';

        $(function() {
            $('#ph_top').css({
                height: ($(window).height() - 120)
            });
            $("#full-width-slider").royalSlider({
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
                globalCaption: true,
                deeplinking: {
                    enabled: true,
                    change: false
                },
                /* size of all images http://help.dimsemenov.com/kb/royalslider-jquery-plugin-faq/adding-width-and-height-properties-to-images */
                imgWidth: 1400,
                imgHeight: 900
            });

            $('.scout-lily').attr('fill', black);

            $('#main-scout-lily').mouseenter(function() {
                $('.scout-lily').attr('fill', red);
            }).mouseleave(function() {
                $('.scout-lily').attr('fill', black);
            });

            $('.notice_link').click(function(event) {
                event.preventDefault();
                var elem = $(this);

                $.post(elem.attr('href'))
                        .done(function(data) {
                            $('body').append(data);
                            $('.overlay').css('display', 'block');
                            $('.overlay').animate({
                                opacity: 1
                            }, 200);
                            console.log(data);

                            //add event handlers
                            $('.closeModal').click(function(event) {
                                event.preventDefault();
                                $('.overlay').animate({
                                    opacity: 0
                                }, 200, function() {
                                    $('.overlay').remove();
                                });
                            });

                        });
            });

            $('#ph_details_button').click(function() {
                $.scrollTo($('#map-canvas'), 1000, {easing: 'easeInOutQuint'});
            });
            
            $('#show_full_maps_button').click(function(){
                var overlay = $("#google_maps_overlay");
                if(overlay.hasClass("hidden")){
                    overlay.css({height: 750, boxShadow: 'none'});
                    overlay.removeClass("hidden");
                    $('#map-canvas').css({zIndex: 0});
                    $(this).text("Karte ausblenden");
                }else{
                    overlay.css({height: $(window).height() - 640, boxShadow: 'rgb(0, 0, 0) 0px -10px 23px -12px inset'});
                    overlay.addClass("hidden");
                    $('#map-canvas').css({zIndex: -2});
                    $(this).text("Ganze Karte anzeigen");
                }
            });
        });

        $(window).load(function() {
            $('.top-image').parallax({
                parallax: 0.6
            });
            /*console.log("page is loaded!");
             NProgress.done(true);*/
            $('body').css({display: 'block'});
            $('#google_maps_overlay').css({height: $(window).height() - 640});
        });

        $(window).resize(function() {
            $('#ph_top').css({
                height: ($(window).height() - 120)
            });
            
            $('#google_maps_overlay').css({height: $(window).height() - 640});
            if($(window).scrollTop() > 900){
            $("html, body").scrollTop($('#google_maps_overlay').offset().top);
            }
        });
    })();
</script>

<div id="main-container">
    <div id="ph_top">
        <div id="full-width-slider" class="royalSlider heroSlider rsMinW" style="max-width: 1400px;margin: 60px auto 24px;">
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

        <div id="ph_details_button" class="ph_container grey_button">
            Details zum Heim
        </div>
    </div>

    <div id="google_maps_overlay" class="hidden">
        <div id="map-canvas"></div>
        <div id="show_full_maps_button" class="grey_button">Ganze Karte anzeigen</div>
    </div>
    <div id="ph_info_wrapper">
        <div id="ph_location" class="ph_container ph_border">
            <!-- 
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d673.3795679582008!2d8.787130910234787!3d47.538240951191824!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sde!2s!4v1392144415227" width="600" height="450" frameborder="0" style="border:0;float: left;"></iframe>
            -->
            <p>
                Zu finden ist unser Zuhause unter folgender Adresse: <br />

                Pfadiheim Sandacker<br />
                Im Sandacker<br />
                8544 Sulz-Rickenbach<br />

                Für Kartenkundige: 701/500//266/150; 460 m.ü.m.<br />

                Das Heim ist gegenüber Nachbarn auf der Südseite durch Wald getrennt, nördlich liegt ein Bord mit Gebüsch als Grenze. Das Heim ist jedoch aufgrund seiner Nähe zu einer Wohnsiedlung für lärmige Anlässe, insbesondere zur Nachtzeit, nicht geeignet.<br />

                Die interessante und vielfältige Umgebung des Heims bietet viel Wald, Felder, Wiesen, Kiesgruben und Weiher. In der Nähe ist ausserdem das Schloss Mörsburg.
            </p>
        </div><div class="ph_container">
            <div id="ph_administration" class="ph_border">
                <p>
                    Bei Fragen oder Reservationen hilft Ihnen unsere Heimverwaltung gerne weiter.<br /><br />


                    Denise Schubnell (Kontakt)<br />
                    Stationsstrasse 33<br />
                    8544 Sulz-Rickenbach<br />
                    052 337 24 27
                </p>
            </div><div id="ph_vacancy" class="ph_border">
                <p>
                    Ob das Heim an Ihrem Wunschdatum noch frei ist, steht im Kalender
                </p>
            </div>
        </div><div id="ph_furnishment" class="ph_container ph_border">
            <ul>
                <li>1 grosser Aufenthaltsraum</li>
                <li>Chromstahlküche mit Herd, Backofen und Kühlschrank (Geschirr für ca. 30 Personen)</li>
                <li>18 Schlafplätze</li>
                <li>2 Duschen, 2 WCs</li>
                <li>Einen heimeligen Schwedenofen</li>
                <li>Pizzaofen draussen</li>
                <li>eine Spielwiese</li>
                <li>eine Feuerstelle auf unserem Gelände</li>
            </ul>
            <p>Es kann ausserdem noch ein zusätzlicher Arbeitsraum dazugemietet werden (Rücksprache mit der Heimverwaltung).</p>
        </div>
    </div>
</div>