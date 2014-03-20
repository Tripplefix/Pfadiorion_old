
$(function() {
    var _window = $(window),
            winHeight = _window.height(),
            winWidth = _window.width(),
            winOffset = _window.scrollTop(),
            url = document.getServerUrl();

    function msg(txt) {
        console.log(txt);
    }

    var bigNav = $('#big-nav'),
            smallNav = $('#small-nav'),
            tabletNav = $('#tablet-nav-container');
    
    
    _window.on("load", function() {
        if (winWidth < 1000) {
            smallNav.children().remove();
            bigNav.children().remove();
            tabletNav.load(url + 'views/_templates/_mobile_nav.html');
        } else {
            smallNav.load(url + 'views/_templates/_small_nav.html');
            bigNav.load(url + 'views/_templates/_big_nav.html');
            tabletNav.children().remove();
        }
        tabletNav.on("click", function() {
            if ($('#tablet-nav').is(":visible")) {
                $('#tablet-nav').slideUp(200);
            } else {
                $('#tablet-nav').slideDown(200);
            }
        });
    });

    _window.on("scroll", function() {
        winOffset = _window.scrollTop();

        $('#small-scout-lily').on("click", function() {
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

        if (winWidth < 944) {
            smallNav.children().remove();
            bigNav.children().remove();
            tabletNav.load(url + 'views/_templates/_mobile_nav.html');
        } else {
            smallNav.load(url + 'views/_templates/_small_nav.html');
            bigNav.load(url + 'views/_templates/_big_nav.html');
            tabletNav.children().remove();
        }
    });


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


/*
 function loadCSS(e){
 var f=document.createElement("link");
 f.setAttribute("rel", "stylesheet");
 f.setAttribute("type", "text/css");
 f.setAttribute("href", e);
 document.getElementsByTagName("head")[0].appendChild(f);
 }
 function LoadScriptsSync(e,t){var n=0;var r=function(e,t){loadScript(e[n],t[n],function(){n++;if(n<e.length){r(e,t)}})};r(e,t)}function loadScript(e,t,n){t=document.createElement("script");t.onload=function(){n()};t.src=e;document.getElementsByTagName("head")[0].appendChild(t)}function downloadJSAtOnload(){var e=[];var t=[];
 loadCSS("http://www.hotel-du-theatre.ch/css/shrink.css");
 t.push("http://www.hotel-du-theatre.ch/webautor/script/webautor_scripts_20120817.js");
 t.push("http://www.hotel-du-theatre.ch/webautor/functions/mediaplayer/jwplayer.js");
 t.push("http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js");
 t.push("http://www.hotel-du-theatre.ch/js/jquery.flexslider-min.js");
 t.push("http://www.hotel-du-theatre.ch/js/jquery.cycle.min.js");
 t.push("http://www.hotel-du-theatre.ch/js/jquery.easytabs.min.js");
 t.push("http://www.hotel-du-theatre.ch/js/jquery.touchwipe.min.js");
 t.push("http://www.hotel-du-theatre.ch/js/jquery.hashchange.min.js");
 t.push("http://www.hotel-du-theatre.ch/js/ajaxsbmt.js");
 t.push("http://www.hotel-du-theatre.ch/js/datepicker/picker.js");
 t.push("http://www.hotel-du-theatre.ch/js/datepicker/picker.date.js");
 t.push("http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js");
 t.push("http://www.hotel-du-theatre.ch/js/scripts.min.js");
 LoadScriptsSync(t,e);
 }
 if(window.addEventListener)
 window.addEventListener("load",downloadJSAtOnload,false);else if(window.attachEvent)window.attachEvent("onload",downloadJSAtOnload);
 else window.onload=downloadJSAtOnload
 */