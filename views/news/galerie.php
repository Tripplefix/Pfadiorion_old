<style>
    h1{
        font-size: 41px;
        font-family: 'Segoe UI';
    }
    h2{
        font-size: 17px;
        color: #5E5E5E;
        margin-left: 4px;
    }

    #gallery-list li{
        display: inline-block;
        margin: 6px 4px;    
        background-size: 130%;
        background-repeat: no-repeat;
        background-position: 5% 50%;
        background-color: #000; 
    }

    #gallery-list a{
        display: block;
        width: 216px;
        height: 130px;
        background-color: rgba(255, 255, 255, 0.1);
        text-align: center;
        padding-top: 55px;
        color: #FFF;
        text-shadow: 0 0px 9px rgba(0, 0, 0, 0.8);
        font-size: 28px;
        font-weight: bold;
        transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
    }


    #gallery-list a:hover{
        background-color: rgba(255, 255, 255, 0.3);
        box-shadow: 0 1px 4px rgba(0, 0, 0, .60);
    }
</style>

<script>
    $(function() {
        var scripts = [
            '<?php echo URL; ?>tools/royalslider/jquery.royalslider.min.js'
        ];
        var styles = [
            '<?php echo URL; ?>tools/royalslider/royalslider.css',
            '<?php echo URL; ?>tools/royalslider/skins/minimal-white/rs-minimal-white.css'
        ];
        Orion.loadStyles(styles, function() {
            Orion.loadScripts(scripts, function() {
                $('#gallery_slider').royalSlider({
                    fullscreen: {
                        enabled: true,
                        nativeFS: false
                    },
                    controlNavigation: 'bullets',
                    arrowsNav: true,
                    keyboardNavEnabled: true,
                    autoScaleSlider: true,
                    autoScaleSliderWidth: 960,
                    autoScaleSliderHeight: 350,
                    imageScaleMode: 'fill',
                    globalCaption: true,
                    arrowsNavAutoHide: false,
                    imgWidth: 1400,
                    imgHeight: 933
                });
            });
        });

        $('#impressions_slider_fullscreen').on('click', function() {
            $('#impressions_slider').royalSlider('enterFullscreen');
        });
    });
</script>

<?php if ($this->isGallery): ?>

    <div id="main_container">
        <h1>[gallery title]</h1>
        <h2>[gallery description]</h2>

        <div id="gallery_slider" class="royalSlider rsMinW">
            <a class="rsImg" data-rsBigImg="<?php echo URL; ?>views/index/images/5_big.jpg" href="<?php echo URL; ?>views/index/images/5.jpg">SoLa 2012</a>
            <a class="rsImg" data-rsBigImg="<?php echo URL; ?>views/index/images/2_big.jpg" href="<?php echo URL; ?>views/index/images/2.jpg">HeLa 2013</a>
            <a class="rsImg" data-rsBigImg="<?php echo URL; ?>views/index/images/3_big.jpg" href="<?php echo URL; ?>views/index/images/3.jpg">PfiLa 2012</a>
            <a class="rsImg" data-rsBigImg="<?php echo URL; ?>views/index/images/4_big.jpg" href="<?php echo URL; ?>views/index/images/4.jpg">Schauenbergtippel 2013</a>
            <a class="rsImg" data-rsBigImg="<?php echo URL; ?>views/index/images/1_big.jpg" href="<?php echo URL; ?>views/index/images/1.jpg">HeLa 2013</a>
        </div>
    </div>

<?php else: ?>

    <div id="main_container">
        <h1>Foto Galerien</h1>
        <h2>Hier findest du verschiedene Fotoalben zu Lagern, Weekends, Samstagnachmittags-Aktivitäten, usw.</h2>

        <ul id="gallery-list">
            <li style="background-image: url('<?php echo URL; ?>views/news/galeries/jahresrueckblick_2014/thumb.jpg')">
                <a href="<?php echo URL; ?>news/galerie/jahresrueckblick_2014">Jahresrückblick 2014</a>
            </li>
        </ul>
    </div>

<?php endif; ?>