var Orion = (function() {
    var i = 0;
    var config = {
        //serverUrl: 'http://pfadiorion.ch/'
        serverUrl: '<not set>'
    };

    function setConfig(o, p, v) {
        // loop through all the properties of he object
        for (var i in o) {
            // when the value is an object call this function recursively
            if (isObj(o[i])) {
                alert("test");
                setConfig(o[i], p, v);

                // otherwise compare properties and set their value accordingly
            } else {
                if (i === p) {
                    o[p] = v;
                }
            }
        }
    }

    function isObj(o) {
        // tests if a parameter is an object (and not an array)
        return (typeof o === 'object' && typeof o.splice !== 'function');
    }

    function setNavigation() {
        var _window = $(window),
                winHeight = _window.height(),
                winWidth = _window.width(),
                winOffset = _window.scrollTop(),
                url = config.serverUrl;

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
    }

    return {
        init: function() {
            // --------------- set configuration ---------------
            // check if the first argument is an object
            var a = arguments;
            if (isObj(a[ 0 ])) {
                var cfg = a[ 0 ];

                // loop through arguments and alter the configuration
                for (var i in cfg) {
                    setConfig(config, i, cfg[i]);
                }
            }
            
            // --------------- check if site is loaded on a mobile(touchscreen) device ---------------
            /*if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                $('html').addClass('mobile');
            }*/

            // --------------- set event handlers ---------------
            $('body').on('click', '.disabled_link', function(event) {
                event.preventDefault();
            });

            setNavigation();
        },
        isMobile: function(){
            if(this.mobile === undefined){
                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                    this.mobile = true;
                }else{
                    this.mobile = false;
                }
            }
            return this.mobile;
        },
        colors: {
            red: '#CC3D18',
            violet: '#4710B5',
            white: '#FFF',
            black: '#000'
        },
        url: function() {
            return config.serverUrl;
        },
        loadScripts: function loadScript(scripts) {
            //this function will work cross-browser for loading scripts asynchronously
                          
                var s,
                    r,
                    t;
                r = false;
                s = document.createElement('script');
                //s.type = 'text/javascript';
                s.src = scripts[i];
                s.onload = s.onreadystatechange = function() {
                    //console.log( this.readyState ); //uncomment this line to see which ready states are called.
                    if (!r && (!this.readyState || this.readyState == 'complete'))
                    {
                        r = true;
                        i++;
                        if(i < scripts.length) {
                            loadScript(scripts);
                        }
                    }
                };
                t = document.getElementsByTagName('script')[0];
                t.parentNode.insertBefore(s, t);
        }
    };
})();