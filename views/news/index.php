 <script>
    //var red = '#CF5C3F';
    var red = '#CC3D18',
            violet = '#4710B5',
            white = '#FFF',
            black = '#000';
    $(function() {
        $('#tablet-nav-container .scout-lily').attr('fill', black);

        $('#main-scout-lily').mouseenter(function() {
            $('#tablet-nav-container .scout-lily').attr('fill', red);
        }).mouseleave(function() {
            $('#tablet-nav-container .scout-lily').attr('fill', black);
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
    });

    $(window).load(function() {
        $('.top-image').parallax({
            parallax: 0.6
        });
        /*console.log("page is loaded!");
         NProgress.done(true);*/
        $('body').css({display: 'block'});
    });
</script>

<div class="top-image parallax" data-image="<?php echo URL; ?>public/images/orion-skitag.jpg" data-with="1600" data-height="1200" data-container-height="350" data-posy="140">
    <div id="top_image_description">Orion Skitag 2014</div>
</div>
<div id="main-container">
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
    <aside class="main-sidebar">
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
        </section>
        <section class="sidebarelement">
            <h3>Anstehende Events</h3>
            <ul>
                <?php
//load notices      
                if ($this->events) {
                    foreach ($this->events as $value) {
                        echo "<li><a class='event_link' href='" . URL . "news/show_event/" . $value->event_id . "'>" . $value->event_details . "</a></li>";
                    }
                } else {
                    echo 'Keine anstehende Events';
                }
                ?>
            </ul>
            <a href="<?php echo URL; ?>news/kalender"><input class="button" type="button" style="cursor: pointer; margin-top: 10px" value="Kalender" /></a>
        </section>
        <section class="sidebarelement">
            <h3>Informationen</h3>
            <?php
            //load infos
            if ($this->reservation) {
                foreach ($this->reservation as $key => $value) {
                    echo "<p>Das Pfadiheim ist noch bis am " . date("d.m.Y", $value->date_end) . " vermietet</p>"; //<a class='more' href='#'>Mehr</a>";
                }
            } else {
                echo 'Das Pfadiheim ist momentan nicht vermietet!';
            }
            ?>
            <a href="<?php echo URL; ?>pfadiheim/belegung"><input class="button" type="button" style="cursor: pointer; margin-top: 10px" value="Belegungsplan" /></a>

        </section>
    </aside>
</div>

