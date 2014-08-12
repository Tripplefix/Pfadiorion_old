/**
 * jQuery.parallax-skeleton - Parallax-scrolling on a new level
 * Copyright (c) 2014 Rolf Isler
 * Licensed under MIT.
 * Date: 24.01.2014
 * @author Rolf Isler
 * @version 1.2.0
 **/

(function($) {

    $.fn.parallax = function(options) {

        // Default options
        var settings = $.extend({
            placeHolderName: '.parallax',
            parallax: 0.75
        }, options);

        //image settings
        var _imgTransX = new Array(),
        _imgTransY = new Array(),
        _imgPosY = 0,
        _window = $(window),
        _doc = document,
        _parallax = $(".parallax"),
        _body = $('body'),
        _winWith = parseInt(_window.width()),
        _winHeight = parseInt(_window.height()),
        //create parent element for the parallax-container
        parallaxParent = $(_doc.createElement("div"));
        parallaxParent.addClass("parallax-parent");
        parallaxParent.css({position: 'fixed'});
        _body.prepend(parallaxParent);

        _parallax.each(function(index, obj) {            
            var elem = $(obj),
            elemHeight = parseInt(elem.data("height")),
            elemWith = parseInt(elem.data("with")),
            elemImage = elem.data("image"),
            elemOffset = elem.offset().top - _window.scrollTop(),
            containerHeight = elem.data("container-height");
            
            _imgTransX[index] = 0;
            _imgTransY[index] = -elem.data("posy");            
            _imgPosY = elem.data("posy");

            //set placeholder properties
            $(settings.placeHolderName).css({
                height: containerHeight,
                width: '100%'
            }); 

            if (_winWith >= elemWith) {
                _imgTransX[index] = 0;
                elemWith = elemWith + (_winWith - elemWith);
                elemHeight = elemHeight * (_winWith / elemWith);
            } else {
                _imgTransX[index] = (_winWith - elemWith) / 2;
            }

            //create a parallax-container for each parallax object in the document
            var parallaxContainer = $(_doc.createElement("div"));
            parallaxContainer.addClass("parallax-container");
            parallaxContainer.css({
                visibility: 'visible',
                height: containerHeight,
                'transform': 'translate3d(0px, ' + elemOffset + 'px, 0px)',
                '-webkit-transform': 'translate3d(0px, ' + elemOffset + 'px, 0px)',
                overflow: 'hidden',
                position: 'fixed'
            });
            
            //create a image-container for each parallax-container
            var parallaxImage = $(_doc.createElement("div"));
            parallaxImage.addClass("parallax-image");
            parallaxImage.css({
                backgroundImage: "url('" + elemImage + "')",
                width: elemWith,
                height: elemHeight,
                'transform': 'translate3d(' + _imgTransX[index] + 'px, ' + (-(elemOffset) * settings.parallax + _imgTransY[index]) + 'px, 0px)',
                '-webkit-transform': 'translate3d(' + _imgTransX[index] + 'px, ' + (-(elemOffset) * settings.parallax + _imgTransY[index]) + 'px, 0px)',
                backgroundRepeat: 'no-repeat',
                backgroundSize: '100%'
            });

            //append those container tho its parents
            parallaxContainer.append(parallaxImage);
            parallaxParent.append(parallaxContainer);
        });

        var _parallaxContainer = $(".parallax-container"),
        _parallaxImage = $(".parallax-image");

        //set image position on resize
        _window.resize(function() {
            //update window-variables
            _winWith = parseInt(_window.width());
            _winHeight = parseInt(_window.height());
           
            _parallaxImage.each(function(index, obj) {
                var elem = $(obj),
                elemWith = parseInt($(_parallax.get(index)).data("with")),
                elemHeight = parseInt($(_parallax.get(index)).data("height"));
                
                if (_winWith >= elemWith) {
                    _imgTransX[index] = 0;
                    elemWith = elemWith + (_winWith - elemWith);
                    elemHeight = elemHeight * (_winWith / elemWith);
                } else {
                    _imgTransX[index] = (_winWith - elemWith) / 2;
                }

                elem.css({
                    'width': elemWith,
                    'height': elemHeight,
                    'transform': 'translate3d(' + _imgTransX[index] + 'px, ' + _imgTransY[index] + 'px, 0px)',
                    '-webkit-transform': 'translate3d(' + _imgTransX[index] + 'px, ' + _imgTransY[index] + 'px, 0px)'
                });
            });
            
            _parallaxContainer.each(function(index, obj) {
                var elem = $(obj); 
                elem.css({
                    height: $(_parallax[index]).data("container-height")
                });
            });
        });

        //bind on scroll event to window
        _window.scroll(function() {
            var scrollTop = _window.scrollTop(),
            contTop = _winHeight + scrollTop;

            //reset all css-properties
            _parallaxContainer.css({
                visibility: 'hidden',
                'transform': 'translate3d(0px, 0px, 0px)',
                '-webkit-transform': 'translate3d(0px, 0px, 0px)'
            });

            //loop through each parallax object on the document
            _parallax.each(function(index, obj) {
                var elem = $(obj),
                offset = elem.offset().top,
                position = (offset - scrollTop),
                visibility = 'visible',
                cont = $(_parallaxContainer.get(index)),
                containerHeight = elem.data("container-height");;

                //if container-top(offset.top) reaches the bottom of the window(winHeight + scrollTop) while scrolling ... 1*
                if ((contTop) >= offset) {
                    //but, if container-bottom(settings.containerHeight) reaches top of the window(scrollTop - offset.top)  while scrolling ... 2*
                    if ((scrollTop - offset) >= containerHeight) {
                        // 2* ... hide the container ...
                        position = 0;
                        visibility = 'hidden';
                    }

                    // 1* ... set the container visible and set it to the position of its placeholder ...
                    cont.css({
                        visibility: visibility,
                        'transform': 'translate3d(0px, ' + position + 'px, 0px)',
                        '-webkit-transform': 'translate3d(0px, ' + position + 'px, 0px)'
                    });

                    // ... set the parallax-image visible and translate it a bit slower as its container
                    _imgTransY[index] = (-(position) * settings.parallax - _imgPosY);
                    //translateImage($(cont.children().first()), _imgTransX[index], _imgTransY[index]);

                    cont.children().first().css({
                        'transform': 'translate3d(' + _imgTransX[index] + 'px, ' + _imgTransY[index] + 'px, 0px)',
                        '-webkit-transform': 'translate3d(' + _imgTransX[index] + 'px, ' + _imgTransY[index] + 'px, 0px)'
                    });
                }
            });
        });
        return this;
    };
}(jQuery));