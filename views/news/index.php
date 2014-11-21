<script>

    var sidebar;
    $(function() {
        sidebar = $('aside.main_sidebar').html();
        setSidebar();
        $('#tablet_nav_container .scout_lily').attr('fill', Orion.colors.black);

        $('#main_scout_lily').mouseenter(function() {
            $('#tablet_nav_container .scout_lily').attr('fill', Orion.colors.red);
        }).mouseleave(function() {
            $('#tablet_nav_container .scout_lily').attr('fill', Orion.colors.black);
        });

        $('.notice_link').click(function(event) {
            event.preventDefault();
            var elem = $(this);

            $.post(elem.attr('href'))
                    .done(function(data) {
                        var data = JSON.parse(data);

                        $('#notice_title').text(data.day_antreten + ', ' + data.date_antreten);
                        $('#notice_start').text(data.datetime_antreten + ' Uhr, ' + data.place_antreten);
                        $('#notice_end').text(data.datetime_abtreten + ' Uhr, ' + data.place_abtreten);
                        $('#notice_content').html(data.notice_content);

                        $('.overlay').css('display', 'block');
                        $('.overlay').animate({
                            opacity: 1
                        }, 200);
                        if ($(window).width() < 760) {
                            $('#main_container').hide();
                        }

                        //add event handlers
                        $('.closeModal').click(function(event) {
                            event.preventDefault();
                            $('.overlay').animate({
                                opacity: 0
                            }, 200, function() {
                                $('.overlay').hide();
                            });
                        });

                    });
        });

        $('.event_link').click(function(event) {
            event.preventDefault();
            var elem = $(this);

            $.post(elem.attr('href'))
                    .done(function(data) {
                        $('body').append(data);
                        $('.overlay').css('display', 'block');
                        $('.overlay').animate({
                            opacity: 1
                        }, 200);

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

        if ($('html').hasClass('ie8') || navigator.platform.indexOf("iPad") != -1) {
        //if ($('html').hasClass('ie8') || Orion.isMobile()) {
            $('#top_image').removeClass("parallax");
            $('#top_image').height(350);
            $('#top_image').css({
                backgroundImage: 'url("<?php echo URL; ?>public/images/orion-skitag.jpg")',
                backgroundRepeat: 'no-repeat',
                backgroundSize: '100%',
                backgroundPositionY: '-100px',
            });
        }
        if (Orion.isMobile()) {
            $('#main_header').remove();
            $('#top_image').remove();
            $('#parallax_parent').remove();
        }

        $('#notice_back_button').on('click', function() {
            $('.overlay').css('display', 'none');
            $('#main_container').show();
        });
    });

    $(window).on('load', function() {
        $('#top_image').parallax({
            parallax: 0.6
        });
        $('body').css({display: 'block'});
    });

    $(window).on('resize', setSidebar);

    function setSidebar() {
        if ($(window).width() < 744 || Orion.isMobile()) {
            $('aside.main_sidebar').remove();
            $('#main_container').prepend('<aside class="main_sidebar">' + sidebar + '</aside>');
        } else {
            $('aside.main_sidebar').remove();
            $('#main_container').append('<aside class="main_sidebar">' + sidebar + '</aside>');
        }

        if ($('.overlay').is(':visible') && $(window).width() < 760) {
            $('#main_container').hide();
        } else {
            $('#main_container').show();
        }
    }
</script>

<div id="top_image" class="parallax" data-image="<?php echo URL; ?>public/images/sarasani.jpg" data-with="1600" data-height="1067" data-container-height="350" data-posy="400">
    <div id="top_image_description">Abteilungs SoLa 2014</div>
</div>
<div id="main_container">
    <div id="newsfeed">
        <h1>Neuigkeiten aus der Abteilung</h1>
        <?php
//load news
        if ($this->news_list) {
            foreach ($this->news_list as $key => $value) {
                echo "<div class='article_container'><div class='articleHeader'><h2>" . $value->news_title . "</h2></div>" .
                "<div class='articleDetail'>Von " . $value->user_name . " am " . date("d.m.Y", strtotime($value->news_date)) . "</div>" .
                "<div class='articleBody'>" . $value->news_content . "</div></div>";
            }
        } else {
            echo 'Es wurden noch keine Beiträge geschrieben!';
        }
        ?>
    </div>
    <aside class="main_sidebar">
        <section id="onlineanschlag" class="sidebarelement">
            <h3>N&auml;chste Pfadi&uuml;bung
                <span id="notice_info" title="Welchen Anschlag muss ich beachten?" style='display: none'></span></h3>
            <ul> 
                <?php
//load notices      
                if ($this->notices) {
                    foreach ($this->notices as $key => $value) {
                        echo "<li><a class='notice_link' href='" . URL . "news/show_notice/" . $value->notice_id . "'>" . $value->description . "</a></li>";
                    }
                } else {
                    echo 'Keine aktuellen Anschläge';
                }
                ?>
            </ul>
        </section><section class="sidebarelement">
            <h3>Anstehende Events</h3>
            <ul>
                <?php
//load notices      
                if ($this->events) {
                    foreach ($this->events as $value) {
                        echo "<li><a class='event_link' href='" . URL . "news/show_event/" . $value->event_id . "'>" . $value->event_name . "</a></li>";
                    }
                } else {
                    echo 'Keine anstehende Events';
                }
                ?>
            </ul>
            <a href="<?php echo URL; ?>news/kalender"><input class="button" type="button" style="cursor: pointer; margin-top: 10px" value="Kalender" /></a>
        </section><section class="sidebarelement">
            <h3>Downloads</h3>
            <?php
//load downloads
            if ($this->recent_downloads) {
                foreach ($this->recent_downloads as $key => $value) {
                    echo '<a class="no_select" href="' . URL . 'public/download/' . $value->download_file_name . '">' . $value->download_file_name . ' (' . $value->download_size . ')</a><br />';
                }
            } else {
                echo 'Momentan gibt es keine aktuellen Downloads';
            }
            ?>
            <br /><a href="<?php echo URL; ?>news/downloads"><input class="button" type="button" style="cursor: pointer; margin-top: 10px" value="Alle Downloads" /></a>

        </section><section class="sidebarelement">
            <h3>Informationen</h3>
            <?php
            //load infos
            if ($this->reservation) {
                foreach ($this->reservation as $key => $value) {
                    echo "<p>Das Pfadiheim ist noch bis am " . date("d.m.Y", $value->date_end) . " vermietet</p>"; //<a class='more' href='#'>Mehr</a>";
                }
            } else {
                echo "<p>Das Pfadiheim ist momentan nicht vermietet!</p>";
            }
            ?>
            <a href="<?php echo URL; ?>pfadiheim/belegung"><input class="button" type="button" style="cursor: pointer; margin-top: 10px" value="Belegungsplan" /></a>

        </section>
    </aside>
</div>

<div class="overlay">
    <div id="notice_overlay">
        <a class="closeModal" href="close_notice"></a>
        <h2 id="notice_title"></h2>
        <div class="notice_time">
            <h4>Antreten</h4>
            <div id="notice_start"></div>
        </div><div class="notice_time">                
            <h4>Abtreten</h4>
            <div id="notice_end"></div>
        </div><br />
        <h4 id="notice_content_title">Details</h4><p id="notice_content"></p>
        <div id="notice_back_button">Zurück</div>
    </div>
</div>


<div class="overlay" style='display: none' >
    <div class="notice_help_overlay">
        <h2>Die verschiedenen Gruppen</h2>
        <p><b>Volk Pimpernuss</b><br />Gemischte Gruppe in Wiesendangen, im Alter zwischen 5 und ca. 11 Jahren</p>
        <p><b>Meute Von Planta</b><br />Jungs-Gruppe in Sulz-Rickenbach, im Alter zwischen 5 und ca. 11 Jahren</p>
        <p><b>Trupp Girsberg</b><br />Jungs-Gruppe in Sulz-Rickenbach, im Alter zwischen 11 und 15 Jahren</p>
        <p><b>Trupp Aquila</b><br />Mädchen-Gruppe in Sulz-Rickenbach, im Alter zwischen 11 und 15 Jahren</p>

        <h2>Spezielle Anschläge</h2>
        <p><b>Wolfstufe</b><br />Wenn das Volk Pimpernuss und die Meute Von Planta zusammen eine Übung machen</p>
        <p><b>Pfadistufe</b><br />Wenn der Trupp Girsberg und der Trupp Aquila zusammen eine Übung machen</p>
        <p><b>Abteilung Orion</b><br />Wenn die ganze Abteilung eine gemeinsame Übung machen</p>
    </div>
</div>