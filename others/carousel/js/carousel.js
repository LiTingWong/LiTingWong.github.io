/*jslint browser: true*/
/*global $, jQuery, define, module, exports*/
(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(function () {
            return factory(root);
        });
    } else if (typeof exports === 'object') {
        module.exports = factory;
    } else {
        root.Carousel = factory(root);
    }
})(this, function () {
    'use strict';

    var Carousel = function (options) {
        if (!this || !(this instanceof Carousel)) {
            return new Carousel(options);
        }

        if (typeof options === 'string') {
            options = { key : options };
        }

        this.target = options.target;
        this.early();
    };

    Carousel.init = function (options) {
        return new Carousel(options);
    };

    Carousel.prototype = {
        early: function () {
			console.log(this);
            this.target.find('#activeBoxDiv').append('<span class="nav-left"><</span><span class="nav-right">></span>');
            this.setupClass();
            this.events();
			//var auto = setInterval(this.moveCarousel(this.target.find('.carousel-wrapper li'), 'right', 'left'), 1000);
        },
        isInViewport: function ($el) {
			console.log("isInViewport: function ($el)");
            if (typeof jQuery === "function" && $el instanceof jQuery) {
                $el = $el[0];
            }

            var rect = $el.getBoundingClientRect();

            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        },
        setupClass: function () {
            var carouselBox = this.target.find('.carousel-box');
	
			carouselBox.eq(0).addClass('left3');
			carouselBox.eq(1).addClass('left2');
            carouselBox.eq(2).addClass('left');
            carouselBox.eq(3).addClass('is-active');
            carouselBox.eq(4).addClass('right');
			carouselBox.eq(5).addClass('right2');
            carouselBox.eq(6).addClass('right3');
        },
        moveCarousel: function ($el, direction, reverse) {
            var $current = this.target.find('ul .is-active'),
                indexActive;
            $el.removeClass(direction);
			$el.removeClass(direction+'2');
			$el.removeClass(direction+'3');
			
			$el.removeClass(reverse+'2');
			$el.removeClass(reverse+'3');
			$current.removeClass('is-active');
            //$current.removeClass('is-active').addClass(direction);

            /*indexActive = $current.siblings('.' + reverse).removeClass(reverse).addClass('is-active').index();*/
            //indexActive = callback(indexActive, $el);
			
			indexActive = $current.siblings('.' + reverse).removeClass(reverse).index();
			var num = $( "#carousel-wrapper" ).attr("number");
			
			if(indexActive-3 < 0){$el.eq(indexActive+(num-3)).addClass('left3');} else {$el.eq(indexActive-3).addClass('left3');}
			if(indexActive-2 < 0){$el.eq(indexActive+(num-2)).addClass('left2');} else {$el.eq(indexActive-2).addClass('left2');}
			if(indexActive-1 < 0){$el.eq(indexActive+(num-1)).addClass('left');} else {$el.eq(indexActive-1).addClass('left');}
			$el.eq(indexActive).addClass('is-active');
			if(indexActive+1 > 6){$el.eq(indexActive-(num-1)).addClass('right');} else {$el.eq(indexActive+1).addClass('right');}
			if(indexActive+2 > 6){$el.eq(indexActive-(num-2)).addClass('right2');} else {$el.eq(indexActive+2).addClass('right2');}
			if(indexActive+3 > 6){$el.eq(indexActive-(num-3)).addClass('right3');} else {$el.eq(indexActive+3).addClass('right3');}	
        },
        events: function () {
            var self = this;

            this.target.on('click', '.nav-left', function (e) {
				console.log("this.target.on .nav-left");
                e.preventDefault();
                self.moveCarousel(self.target.find('.carousel-wrapper li'), 'right', 'left');
				/* self.moveCarousel(self.target.find('.carousel-wrapper li'), 'right', 'left', function (cur, $el) {
                    if (cur === 1) {
                        return '0';
                    }

                    return cur - 1;
                });*/
            });

            this.target.on('click', '.nav-right', function (e) {
				console.log("this.target.on .nav-right");
                e.preventDefault();
                self.moveCarousel(self.target.find('.carousel-wrapper li'), 'left', 'right');
				/*self.moveCarousel(self.target.find('.carousel-wrapper li'), 'left', 'right', function (cur, $el) {
                    if (cur === $el.length - 1) {
                        return '0';
                    }

                    return cur + 1;
                });*/
            });

            $(document).keyup(function (e) {
                if (e.which === 39 && self.isInViewport(self.target)) {
                    self.target.find('.nav-right').trigger('click');
                }

                if (e.which === 37 && self.isInViewport(self.target)) {
                    self.target.find('.nav-left').trigger('click');
                }
            });
			
			$(document).ready(function(){
				setInterval(self.moveCarousel(self.target.find('.carousel-wrapper li'), 'right', 'left'), 1000);
			});
        }
    };

    return Carousel;
});