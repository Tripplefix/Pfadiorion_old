<script>
    //var red = '#CF5C3F';
    var red = '#CC3D18',
            violet = '#4710B5',
            white = '#FFF',
            black = '#000';

    var sidebar;
    $(function() {
        sidebar = $('aside.main_sidebar').html();
        setSidebar();
        $('#tablet_nav_container .scout_lily').attr('fill', black);

        $('#main_scout_lily').mouseenter(function() {
            $('#tablet_nav_container .scout_lily').attr('fill', red);
        }).mouseleave(function() {
            $('#tablet_nav_container .scout_lily').attr('fill', black);
        });

        $('.notice_link').click(function(event) {
            event.preventDefault();
            var elem = $(this);

            $.post(elem.attr('href'))
                    .done(function(data) {
                        var data = JSON.parse(data);
                        
                        $('.notice_title').text(data.day_antreten + ', ' + data.date_antreten);
                        $('.notice_start').text(data.datetime_antreten);
                        $('.notice_end').text(data.datetime_abtreten);
                        $('.notice_content').html(data.notice_content);
                
                        /*$('body').append(data);*/
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

        //if ($('html').hasClass('ie8') || navigator.platform.indexOf("iPad") != -1) {
        if ($('html').hasClass('ie8') || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            $('#top_image').removeClass("parallax");
            $('#top_image').height(350);
            $('#top_image').css({
                backgroundImage: 'url("<?php echo URL; ?>public/images/orion-skitag.jpg")',
                backgroundRepeat: 'no-repeat',
                backgroundSize: '100%',
                backgroundPositionY: '-100px',
            });
        }
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            $('#top_image').css({
                height: '250px'
            });
            $('#top_image_description').css({
                top: '214px',
                opacity: 1
            });
        }
    });

    $(window).on('load', function() {
        $('#top_image').parallax({
            parallax: 0.6
        });
        $('body').css({display: 'block'});
        console.log(sidebar);
    });

    $(window).on('resize', setSidebar);

    function setSidebar() {
        if ($(window).width() < 744) {
            $('aside.main_sidebar').remove();
            $('#main_container').prepend('<aside class="main_sidebar">' + sidebar + '</aside>');
        } else {
            $('aside.main_sidebar').remove();
            $('#main_container').append('<aside class="main_sidebar">' + sidebar + '</aside>');
        }
    }
</script>

<style>


</style>

<div id="top_image" class="parallax" data-image="<?php echo URL; ?>public/images/orion-skitag.jpg" data-with="1600" data-height="1200" data-container-height="350" data-posy="140">
    <div id="top_image_description">Orion Skitag 2014</div>
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
            <h3>N&auml;chste Pfadi&uuml;bung</h3>
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
    <div class="overlay">
        <section class="modal rounded">
            <a class="closeModal" href="close_notice"></a>
            <h2 class="notice_title"></h2>
            <h4 style="font-size: 22px;display: inline-block; width: 50%">Antreten</h4><h4 style="font-size: 22px;display: inline-block; width: 50%">Abtreten</h4><br />
            <span class="notice_start" style="display: inline-block; width: 49%"></span>
            <span class="notice_end" style="display: inline-block; width: 49%"></span><br />
            <h4 style="font-size: 22px;margin-top: 20px;">Details</h4><p class="notice_content"></p>
        </section>
    </div>
</div>

