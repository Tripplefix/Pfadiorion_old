var Orion = (function() {
    var mobile;
    var config = {
        serverUrl: 'http://pfadiorion.ch/'
    };

    function setConfig(o, p, v) {
        // loop through all the properties of he object
        for (var i in o) {
            // when the value is an object call this function recursively
            if (isObj(o[i])) {
                alert('test');
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
    
    function hasClass(o, className){
        if (o.classList)
            return o.classList.contains(className);
        else
            return new RegExp('(^| )' + className + '( |$)', 'gi').test(o.className);
    }
    
    function addClass(o, className){
        if (o.classList)
            o.classList.add(className);
        else
            o.className += ' ' + className;
    }
    
    function removeClass(o, className){
        if (o.classList)
            o.classList.remove(className);
        else
            o.className = o.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
    }

    function setNavigation() {
        var winHeight = window.innerHeight,
            scrollTop = document.body.scrollTop || window.pageYOffset,        
            bigNav = document.getElementById('big_nav'),
            smallNav = document.getElementById('small_nav'),
            tabletNav = document.getElementById('tablet_nav_container');

        tabletNav.addEventListener('click', function(){
            if(hasClass(document.getElementById('tablet_nav'), 'hidden')){
                removeClass(document.getElementById('tablet_nav'), 'hidden');
            }else{
                addClass(document.getElementById('tablet_nav'), 'hidden');
            }
        });
        
        window.addEventListener('load', setNav);
        window.addEventListener('resize', setNav);
        window.addEventListener('scroll', function(){
            scrollTop = document.body.scrollTop || window.pageYOffset;
            
            if (!mobile) {
                //small navigation
                if (scrollTop > winHeight - 20) {
                    smallNav.style.marginTop = '0';
                } else if (scrollTop <= winHeight - 50) {
                    smallNav.style.marginTop = '-60px';
                }

                //big navigation
                if (scrollTop <= 80) {
                    removeClass(bigNav, 'bignav_hidden');
                } else {
                    addClass(bigNav, 'bignav_hidden');
                }
            }
        });        

        function setNav() {
            winHeight = window.innerHeight;
            if(mobile || window.innerWidth <= 640) {                
                smallNav.style.display = 'none';
                bigNav.style.display = 'none';
                tabletNav.style.display = 'block';
            } else {                
                smallNav.style.display = 'block';
                bigNav.style.display = 'block';
                tabletNav.style.display = 'none';
            }
        }
    }

    return {
        init: function(args, callback) {
            // --------------- set configuration ---------------
            // check if the first argument is an object
            if (isObj(args)) {
                // loop through arguments and alter the configuration
                for (var i in args) {
                    setConfig(config, i, args[i]);
                }
            }

            // --------------- check if site is loaded on a mobile(touchscreen) device ---------------
            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                mobile = true;
            } else {
                mobile = false;
            }
            
            // --------------- set event handlers ---------------
            //currently no events 
            

            // --------------- set navigation ---------------
            setNavigation();
            
            // --------------- run callback ---------------
            if(callback !== 'undefined' && typeof callback === 'function'){
                callback();
            }
        },
        isMobile: function() {
            return mobile;
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
        loadScripts: function (scripts, callback) {
            var scriptCount = scripts.length;
            var loadedCount = 0;
            
            scripts.forEach(function(src){                
                var script, done, t;
                done = false;
                script = document.createElement('script');
                //s.type = 'text/javascript';
                script.src = src;
                //if(async === 'true') script.async = 'async';
                script.onload = script.onreadystatechange = function() {
                    if (!done && (!this.readyState || this.readyState === 'complete'))
                    {
                        done = true;
                        loadedCount++;
                        
                        //callback ausführen, nachdem alle scripts geladen wurden
                        if(loadedCount === scriptCount){
                            if(callback !== 'undefined' && typeof callback === 'function'){
                                callback('scripts loaded');
                            }
                        }
                    }            
                };
                t = document.getElementsByTagName('script')[0];
                t.parentNode.insertBefore(script, t);
            });
        },
        loadStyles: function (styles, callback) {
            var styleCount = styles.length;
            var loadedCount = 0;
            
            styles.forEach(function(src){       
                var style, done, t;
                done = false;
                style = document.createElement('link');
                style.rel = 'stylesheet';
                style.href = src;
                style.onload = style.onreadystatechange = function() {
                    if (!done && (!this.readyState || this.readyState === 'complete'))
                    {
                        done = true;
                        loadedCount++;
                        
                        //callback ausführen, nachdem alle styles geladen wurden
                        if(loadedCount === styleCount){
                            if(callback !== 'undefined' && typeof callback === 'function'){
                                callback('styles loaded');
                            }
                        }
                    }
                };
                t = document.getElementsByTagName('link')[0];
                t.parentNode.insertBefore(style, t);     
            });
        }
    };
})();