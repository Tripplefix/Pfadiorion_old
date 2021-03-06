<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>
<script>

    var styles = [
        '<?php echo URL; ?>tools/royalslider/royalslider.css',
        '<?php echo URL; ?>tools/royalslider/skins/minimal-white/rs-minimal-white.css'
    ];
    Orion.loadStyles(styles, function() {
        Orion.loadScripts(['<?php echo URL; ?>tools/royalslider/jquery.royalslider.min.js'], function() {
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
            $("#full-width-slider").css({opacity: 1});
        });
    });

    /* Google Maps */
    var sulz = new google.maps.LatLng(47.505964, 8.787713);
    var phSandacker = new google.maps.LatLng(47.538319, 8.787542);
    var marker;
    var map;

    function initializeMap() {
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
        console.log("map is loaded!");
    }

    function toggleBounce() {
        if (marker.getAnimation() != null) {
            marker.setAnimation(null);
        } else {
            marker.setAnimation(google.maps.Animation.BOUNCE);
        }
    }

    function scrollToDetails() {
        var offset;
        if (Orion.isMobile()) {
            offset = $('#map-canvas').offset().top - 75;
        } else {
            offset = $('#map-canvas').offset().top;
        }
        $('body, html').animate({
            scrollTop: offset
        }, {
            duration: 1000,
            queue: false,
            easing: 'easeInOutQuint'
        });
    }


    $(function() {
        //$('body').css({overflowY: 'hidden'});
        $('#ph_top').css({
            height: ($(window).height() - 120)
        });


        $('.scout_lily').attr('fill', Orion.colors.black);

        $('#main_scout_lily').mouseenter(function() {
            $('.scout_lily').attr('fill', Orion.colors.red);
        }).mouseleave(function() {
            $('.scout_lily').attr('fill', Orion.colors.black);
        });

        $('#ph_details_button').click(scrollToDetails);

        $('#show_full_maps_button').click(function() {

            var overlay = $("#google_maps_overlay");

            if (Orion.isMobile()) {
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
                scrollToDetails();
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

    $(window).on({
        load: function() {
            $('body').css({display: 'block'});
            initializeMap();
        },
        resize: function() {
            $('#ph_top').css({
                height: ($(window).height() - 120)
            });
            if(!Orion.isMobile() && window.scrollY >= 600) scrollToDetails();
        }
    });
</script>

<h1 style="display: none;">Pfadiheim Im Sandacker</h1>
<div id="main_container">
    <div id="ph_top">
        <div id="full-width-slider" class="royalSlider heroSlider rsMinW" style="opacity: 0; max-width: 1400px;margin: 60px auto 24px;">
            <div class="rsContent">
                <img class="rsImg" src="<?php echo URL; ?>views/pfadiheim/images/IMG_8292.jpg" alt="&copy; Pfadi Orion">
                <div class="infoBlock rsABlock" data-fade-effect="" data-move-offset="10" data-move-effect="top" data-speed="200">
                    <h4>Unser Heim von vorne, in seiner ganzen Pracht</h4>
                </div>
            </div>
            <div class="rsContent">
                <img class="rsImg" src="<?php echo URL; ?>views/pfadiheim/images/IMG_8294.jpg" alt="&copy; Pfadi Orion">
                <div class="infoBlock rsABlock" data-fade-effect="" data-move-offset="10" data-move-effect="top" data-speed="200">
                    <h4>Hinter dem Heim befindet sich eine Sitzmöglichkeit, geeignet für lange Bastelarbeiten</h4>
                </div>
            </div>
            <div class="rsContent">
                <img class="rsImg" src="<?php echo URL; ?>views/pfadiheim/images/IMG_8298.JPG" alt="&copy; Pfadi Orion">
                <div class="infoBlock rsABlock" data-fade-effect="" data-move-offset="10" data-move-effect="top" data-speed="200">
                    <h4><span style="color: red">Neu!</span> Direkt daneben steht ein ehemaliger Zirkuswagen, umgebaut für Pfadizwecke</h4>
                </div>
            </div>
            <div class="rsContent">
                <img class="rsImg" src="<?php echo URL; ?>views/pfadiheim/images/IMG_8295.jpg" alt="&copy; Pfadi Orion">
                <div class="infoBlock rsABlock" data-fade-effect="" data-move-offset="10" data-move-effect="top" data-speed="200">
                    <h4>Direkt neben dem Heim ist eine kleine Spielwiese, in gebrauchtem Zustand</h4>
                </div>
            </div>
            <div class="rsContent">
                <img class="rsImg" src="<?php echo URL; ?>views/pfadiheim/images/IMG_8296.jpg" alt="&copy; Pfadi Orion">
                <div class="infoBlock rsABlock" data-fade-effect="" data-move-offset="10" data-move-effect="top" data-speed="200">
                    <h4>Eine von zwei gepflegten Feuerstellen für gemütliche Grillnachmittage</h4>
                </div>
            </div>
            <div class="rsContent">
                <img class="rsImg" src="<?php echo URL; ?>views/pfadiheim/images/IMG_8297.jpg" alt="&copy; Pfadi Orion" data-rsw="1400" data-rsh="681">
                <div class="infoBlock rsABlock" data-fade-effect="" data-move-offset="10" data-move-effect="top" data-speed="200">
                    <h4>Nigelnagelneue WC-Anlagen, für geschäftliche Angelegenheiten</h4>
                </div>
            </div>
            <div class="rsContent">
                <img class="rsImg" src="<?php echo URL; ?>views/pfadiheim/images/IMG_8302.jpg" alt="&copy; Pfadi Orion" data-rsw="1400" data-rsh="691">
                <div class="infoBlock rsABlock" data-fade-effect="" data-move-offset="10" data-move-effect="top" data-speed="200">
                    <h4>Eine moderne Küche macht das Kochen für viele Personen einfacher</h4>
                </div>
            </div>
            <div class="rsContent">
                <img class="rsImg" src="<?php echo URL; ?>views/pfadiheim/images/IMG_8303.jpg" alt="&copy; Pfadi Orion">
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
                </p>

                <p style="text-align: center; font-size: 20px; font-weight: bold;">
                    Denise Schubnell<br />
                    Stationsstrasse 33<br />
                    8544 Sulz-Rickenbach<br />
                    052 337 24 27<br />
                </p><br />
                Oder E-Mail an
                <script>
                    document.write(
                            '<a href="mailto:heimverwaltung@pfadiorion.ch?Subject=Heimreservation">heimverwaltung@pfadiorion.ch</a>'
                            );
                </script>
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
                <li><span style="color: red">Neu!</span> beheizter Bauwagen, kann auf Anfrage dazugemietet werden</li>
                <li>zwei Feuerstellen auf unserem Gelände</li>
            </ul><br />
            <p>Es kann ausserdem noch ein zusätzlicher Arbeitsraum dazugemietet werden (Rücksprache mit der Heimverwaltung).</p>
        </div>
    </div>
</div>