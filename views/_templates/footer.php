<script>
    $(function() {
        $('#footer_toggle').on("click", function() {
            if ($('#footer_nav').is(":visible")) {
                $('#footer_nav').slideUp(200);
                $('#footer_toggle p').removeClass("open");
                
            } else {
                $('#footer_nav').show();
                $('body, html').animate({
                    scrollTop: document.body.scrollHeight
                }, {
                    duration: 800,
                    queue: false,
                    easing: 'linear'
                });
                $('#footer_toggle p').addClass("open");
            }
        });
    });
</script>

<div id="footer">
    <div id="footer_top">
        <div class="footer_top_element left">
            <h3>Übersicht</h3>
            <ul>
                <li>
                    <a href="<?php echo URL; ?>">Hauptseite</a>
                </li>
                <li>
                    <a href="<?php echo URL; ?>news">News</a>
                    <ul>
                        <li style="margin: 0 0 0 10px;list-style-type: disc;"><a href="<?php echo URL; ?>news/kalender">Kalender</a></li>
                        <li style="margin: 0 0 5px 10px;list-style-type: disc;"><a href="<?php echo URL; ?>news/downloads">Downloads</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo URL; ?>pfadiheim">Pfadiheim</a>
                    <ul>
                        <li style="margin: 0 0 5px 10px;list-style-type: disc;"><a href="<?php echo URL; ?>pfadiheim/belegung">Belegungsplan</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo URL; ?>kontakt">Kontakt</a>
                </li>
            </ul>
        </div>
        <div class="footer_top_element middle">
            <?php include 'scout_lily_small.html'; ?>
            <p>Allzeit Bereit!</p>
        </div>
        <div class="footer_top_element right">
            <h3>Nützliche Links</h3>
            <ul>
                <li>
                    <a href="http://www.pfadiwinti.ch/">Pfadi Region Winterthur (PRW)</a>
                </li>
                <li>
                    <a href="http://www.pbs.ch/de/verband/">Pfadibewegung Schweiz (PBS)</a>
                </li>
            </ul>             
        </div>
    </div>
    <div id="footer_bottom">
        <div class="footer_bottom_element left">
            <a href="<?php echo URL; ?>kontakt/impressum">Impressum</a>
        </div>
        <div class="footer_bottom_element middle">
            <p><a href="<?php echo URL; ?>">Pfadi Orion</a> &copy; <?php echo date("Y"); ?></p>
        </div>
        <div class="footer_bottom_element right">
            <a href="<?php echo URL; ?>admin">Login</a>
        </div>
    </div>
    <div id="footer_mobile">
        <div id="footer_toggle"><p>&raquo;</p></div>
        <nav id="footer_nav">
            <ul>
                <li>
                    <a href="<?php echo URL; ?>kontakt/impressum">Impressum</a>
                </li><li>
                    <a href="<?php echo URL; ?>admin">Login</a>
                </li><li>
                    <p>Pfadi Orion &copy; <?php echo date("Y"); ?></p>
                </li>
            </ul>
        </nav>    
    </div>
</div>

</body>
</html>