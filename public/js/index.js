(function() {
    $(function() {
        $('.main-header').data("container-height", $(window).height());
        $('.top-title h2').on("click", function(evt) {
            evt.preventDefault();
            $('body, html').animate({
                scrollTop: $('#main-container').offset().top
            }, {
                duration: 1500,
                queue: false,
                easing: 'easeInOutQuart'
            });
        });
        $('#full-width-slider').royalSlider({
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
            globalCaption: false,
            deeplinking: {
                enabled: true,
                change: false
            },
            /* size of all images http://help.dimsemenov.com/kb/royalslider-jquery-plugin-faq/adding-width-and-height-properties-to-images */
            imgWidth: 1400,
            imgHeight: 680
        });
    });

    $(window).on("load", function() {
        $('.main-header').parallax({
            parallax: 0.6
        });
        $('body').css({display: 'block'});
    });

    $(window).on("resize", function() {
        var winHeight = $(window).height();
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