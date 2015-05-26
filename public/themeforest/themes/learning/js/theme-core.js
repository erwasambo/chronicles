(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({"./app/js/themes/learning/theme-core.js":[function(require,module,exports){
// Curriculum
require('./_curriculum');
},{"./_curriculum":"/Code/html/themekit/dev/app/js/themes/learning/_curriculum.js"}],"/Code/html/themekit/dev/app/js/themes/learning/_curriculum.js":[function(require,module,exports){
(function ($) {
    "use strict";

    if (!$('.curriculum').length) return;

    $('.curriculum .list-group-item').on('click', function(){
        location.href = $(this).data('target');
    });

    $('.curriculum .collapse').on('show.bs.collapse', function(){
        $(this).closest('.curriculum').addClass('open');
    });

    $('.curriculum .collapse').on('hide.bs.collapse', function(){
        $(this).closest('.curriculum').removeClass('open');
    });

})(jQuery);
},{}]},{},["./app/js/themes/learning/theme-core.js"]);
