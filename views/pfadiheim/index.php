<?php ?>
<script src="<?php echo URL; ?>tools/royalslider/jquery.royalslider.min.js"></script>
<link href="<?php echo URL; ?>tools/royalslider/royalslider.css" rel="stylesheet">
<link href="<?php echo URL; ?>tools/royalslider/skins/minimal-white/rs-minimal-white.css" rel="stylesheet">
<script>
    (function() {
        /* Google Maps */
        var sulz = new google.maps.LatLng(47.505964, 8.787713);
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
                imgHeight: 933
            });

            $('.scout_lily').attr('fill', black);

            $('#main_scout_lily').mouseenter(function() {
                $('.scout_lily').attr('fill', red);
            }).mouseleave(function() {
                $('.scout_lily').attr('fill', black);
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
                $('body, html').animate({
                    scrollTop: $('#map-canvas').offset().top - 75
                }, {
                    duration: 1000,
                    queue: false,
                    easing: 'easeInOutQuint'
                });
            });

            $('#show_full_maps_button').click(function() {
                var overlay = $("#google_maps_overlay");

                if ($('body').hasClass('mobile')) {
                    if (overlay.hasClass("hidden")) {
                        $(this).text("Karte ausblenden");
                        overlay.removeClass("hidden");
                        overlay.addClass('mobile_fullsize');
                        overlay.find('#show_full_maps_button').addClass('mobile_fullsize');
                        $('#map-canvas').css({zIndex: 952});
                        map.panTo(phSandacker);
                    } else {
                        $(this).text("Ganze Karte anzeigen");
                        overlay.addClass("hidden");
                        overlay.removeClass('mobile_fullsize');
                        overlay.find('#show_full_maps_button').removeClass('mobile_fullsize');
                        $('#map-canvas').css({zIndex: -2});
                        map.panTo(sulz);
                    }
                } else {
                    if (overlay.hasClass("hidden")) {
                        overlay.css({height: 750, boxShadow: 'none'});
                        overlay.removeClass("hidden");
                        $('#map-canvas').css({zIndex: 0});
                        $(this).text("Karte ausblenden");
                        $(this).css({
                            bottom: '70px',
                            left: '50px'
                        });
                        map.panTo(phSandacker);
                    } else {
                        //overlay.css({height: $(window).height() - 640, boxShadow: 'rgb(0, 0, 0) 0px -10px 23px -12px inset'});
                        $('#google_maps_overlay').css({height: '250px', boxShadow: 'rgb(0, 0, 0) 0px -10px 23px -12px inset'});
                        overlay.addClass("hidden");
                        $('#map-canvas').css({zIndex: -2});
                        $(this).text("Ganze Karte anzeigen");
                        $(this).css({
                            bottom: '560px',
                            left: 'calc(50% - 130px)'
                        });
                        map.panTo(sulz);
                    }
                }
            });
        });

        $(window).load(function() {
            /*console.log("page is loaded!");
             NProgress.done(true);*/
            $('body').css({display: 'block'});
            //$('#google_maps_overlay').css({height: $(window).height() - 640});
            $('#google_maps_overlay').css({height: '250px'});
        });

        $(window).resize(function() {
            $('#ph_top').css({
                height: ($(window).height() - 120)
            });

            //$('#google_maps_overlay').css({height: $(window).height() - 640});
            $('#google_maps_overlay').css({height: '250px'});
            if ($(window).scrollTop() > 900) {
                $("html, body").scrollTop($('#google_maps_overlay').offset().top);
            }
        });
    })();
</script>

<div id="main_container">
    <div id="ph_top">
        <div id="full-width-slider" class="royalSlider heroSlider rsMinW" style="max-width: 1400px;margin: 60px auto 24px;">
            <div class="rsContent">
                <img class="rsImg" src="<?php echo URL; ?>views/pfadiheim/images/IMG_8292.jpg" alt="by Kaa">
                <div class="infoBlock rsABlock" data-fade-effect="" data-move-offset="10" data-move-effect="top" data-speed="200">
                    <h4>Unser Heim von vorne, in seiner ganzen Pracht</h4>
                </div>
            </div>
            <div class="rsContent">
                <img class="rsImg" src="<?php echo URL; ?>views/pfadiheim/images/IMG_8294.jpg" alt="by Kaa">
                <div class="infoBlock rsABlock" data-fade-effect="" data-move-offset="10" data-move-effect="top" data-speed="200">
                    <h4>Hinter dem Heim befindet sich eine Sitzmöglichkeit, geeignet für lange Bastelarbeiten</h4>
                </div>
            </div>
            <div class="rsContent">
                <img class="rsImg" src="<?php echo URL; ?>views/pfadiheim/images/IMG_8295.jpg" alt="by Kaa">
                <div class="infoBlock rsABlock" data-fade-effect="" data-move-offset="10" data-move-effect="top" data-speed="200">
                    <h4>Direkt neben dem Heim ist eine kleine Spielwiese, in gebrauchtem Zustand</h4>
                </div>
            </div>
            <div class="rsContent">
                <img class="rsImg" src="<?php echo URL; ?>views/pfadiheim/images/IMG_8296.JPG" alt="by Kaa">
                <div class="infoBlock rsABlock" data-fade-effect="" data-move-offset="10" data-move-effect="top" data-speed="200">
                    <h4>Eine von zwei gepflegten Feuerstellen für gemütliche Grillnachmittage</h4>
                </div>
            </div>
            <div class="rsContent">
                <img class="rsImg" src="<?php echo URL; ?>views/pfadiheim/images/IMG_8297.jpg" alt="by Kaa" data-rsw="1400" data-rsh="681">
                <div class="infoBlock rsABlock" data-fade-effect="" data-move-offset="10" data-move-effect="top" data-speed="200">
                    <h4>Nigelnagelneue WC-Anlagen, für geschäftliche Angelegenheiten</h4>
                </div>
            </div>
            <div class="rsContent">
                <img class="rsImg" src="<?php echo URL; ?>views/pfadiheim/images/IMG_8302.jpg" alt="by Kaa" data-rsw="1400" data-rsh="691">
                <div class="infoBlock rsABlock" data-fade-effect="" data-move-offset="10" data-move-effect="top" data-speed="200">
                    <h4>Eine moderne Küche macht das Kochen für viele Personen einfacher</h4>
                </div>
            </div>
            <div class="rsContent">
                <img class="rsImg" src="<?php echo URL; ?>views/pfadiheim/images/IMG_8303.jpg" alt="by Kaa">
                <div class="infoBlock rsABlock" data-fade-effect="" data-move-offset="10" data-move-effect="top" data-speed="200">
                    <h4>Der grosszügige Aufenthaltsraum wird von einem Schwedenofen beheizt</h4>
                </div>
            </div>
        </div>

        <div id="ph_details_button" class="no_select">
            Details zum Heim
        </div>
    </div>

    <div id="google_maps_overlay" class="hidden">
        <div id="map-canvas"></div>
        <div id="show_full_maps_button" class="no_select">Ganze Karte anzeigen</div>
    </div>
    <div id="ph_info_wrapper">
        <div id="ph_location" class="ph_container ph_border">
            <!-- 
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d673.3795679582008!2d8.787130910234787!3d47.538240951191824!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sde!2s!4v1392144415227" width="600" height="450" frameborder="0" style="border:0;float: left;"></iframe>
            -->
            <p>
                <span style="font-weight: bold;">Zu finden ist unser Zuhause unter folgender Adresse: </span><br /><br />

                Pfadiheim Sandacker<br />
                Im Sandacker<br />
                8544 Sulz-Rickenbach<br /><br />

                Für Kartenkundige: 701/500//266/150; 460 m.ü.m.<br /><br />

                Das Heim ist gegenüber Nachbarn auf der Südseite durch Wald getrennt, nördlich liegt ein Bord mit Gebüsch als Grenze. Das Heim ist jedoch aufgrund seiner Nähe zu einer Wohnsiedlung für lärmige Anlässe, insbesondere zur Nachtzeit, nicht geeignet.<br />

                Die interessante und vielfältige Umgebung des Heims bietet viel Wald, Felder, Wiesen, Kiesgruben und Weiher. In der Nähe ist ausserdem das Schloss Mörsburg.
            </p>
        </div><div class="ph_container">
            <div id="ph_administration" class="ph_border">
                <p>
                    Bei Fragen oder Reservationen hilft Ihnen unsere Heimverwaltung gerne weiter.
                </p><br />

                <p style="text-align: center; font-size: 20px; font-weight: bold;">
                    Denise Schubnell<br />
                    Stationsstrasse 33<br />
                    8544 Sulz-Rickenbach<br />
                    052 337 24 27<br />
                </p><br />
                Oder E-Mail an <a href="mailto:heimverwaltung@pfadiorion.ch?Subject=Heimreservation">heimverwaltung@pfadiorion.ch</a>
            </div><div id="ph_vacancy" class="ph_border">
                <p>
                    Ob das Heim an Ihrem Wunschdatum noch frei ist, steht im <a href="<?php echo URL; ?>pfadiheim/belegung">Kalender</a>
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
            </ul><br />
            <p>Es kann ausserdem noch ein zusätzlicher Arbeitsraum dazugemietet werden (Rücksprache mit der Heimverwaltung).</p>
        </div>
    </div>
</div>