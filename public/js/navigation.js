
$(function() {
    var _window = $(window),
            winHeight = _window.height(),
            winWidth = _window.width(),
            winOffset = _window.scrollTop(),
            url = document.getServerUrl();

    function msg(txt) {
        console.log(txt);
    }

    var bigNav = $('#big_nav'),
            smallNav = $('#small_nav'),
            tabletNav = $('#tablet_nav_container');


    $('body').on("click", '#tablet_nav_container', function() {
        if ($('#tablet_nav').is(":visible")) {
            $('#tablet_nav').slideUp(200);
        } else {
            $('#tablet_nav').slideDown(200);
        }
    });

    _window.on("load", setNavigation());

    _window.on("scroll", function() {
        winOffset = _window.scrollTop();

        $('#small_scout_lily').on("click", function() {
            $('body, html').animate({
                scrollTop: 0
            }, {
                duration: 1500,
                queue: false,
                easing: 'easeInOutQuart'
            });
        });
        if (winWidth >= 1000) {
            //small navigation
            if (winOffset > winHeight - 10) {
                smallNav.css({
                    marginTop: 0
                });
            } else if (winOffset <= winHeight - 60) {
                smallNav.css({
                    marginTop: -60
                });
            }

            //big navigation
            if (winOffset <= 80) {
                bigNav.removeClass("bignav_hidden");
            } else {
                bigNav.addClass("bignav_hidden");
            }
        }
    });

    _window.on("resize", function() {
        winHeight = _window.height();
        winWidth = _window.width();
        setNavigation();
    });

    function setNavigation() {
        if ((window.devicePixelRatio === 1 && winWidth < 944)
                || (window.devicePixelRatio === 1.5 && winWidth < 1500)
                || (window.devicePixelRatio >= 2 && winWidth < 2000)) {
            smallNav.children().remove();
            bigNav.children().remove();
            tabletNav.load(url + 'views/_templates/_mobile_nav.html');
            $('body').addClass('mobile');
        } else {
            smallNav.load(url + 'views/_templates/_small_nav.html');
            bigNav.load(url + 'views/_templates/_big_nav.html');
            tabletNav.children().remove();
            $('body').removeClass('mobile');
        }
    }

    /*function initScoutLily() {
     var lilyB = $('#main-scout-lily');
     var lilyS = $('#small-scout-lily')
     lilyB.attr('fill', colors.white);
     $('#small-scout-lily').attr('fill', colors.black);
     
     lilyB.mouseenter(function() {
     lilyB.attr('fill', colors.red);
     }).mouseleave(function() {
     lilyB.attr('fill', colors.white);
     });
     
     lilyS.mouseenter(function() {
     lilyS.attr('fill', colors.red);
     }).mouseleave(function() {
     lilyS.attr('fill', colors.black);
     });
     
     lilyB.attr("style", "filter:url(#dropshadow)");
     }*/
});
