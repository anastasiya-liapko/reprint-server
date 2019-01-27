'use strict';

$(document).ready(function() {
  
  $('#dropupMenuButton').on('click', function () {
    if($('#dropupMenu').hasClass('fadeInUp')) {
      $('#dropupMenu').removeClass('fadeInUp');
      $('#dropupMenu').addClass('fadeOutDown');
      $('#dropupMenu').on('animationend', function() { $('#dropupMenu').removeClass('show'); })
    } else {
      $('#dropupMenu').removeClass('fadeOutDown');
      $('#dropupMenu').addClass('fadeInUp');
      $('#dropupMenu').addClass('show');
      $('#dropupMenu').on('animationend', function() { $('#dropupMenu').addClass('show'); })
    }
  });

  $('#dropdownMenuButton').on('click', function () {
    if($('#dropdownMenu').hasClass('fadeInDown')) {
      $('#dropdownMenu').removeClass('fadeInDown');
      $('#dropdownMenu').addClass('fadeOutUp');
      $('#dropdownMenu').on('animationend', function() { $('#dropdownMenu').removeClass('show'); })
    } else {
      $('#dropdownMenu').removeClass('fadeOutUp');
      $('#dropdownMenu').addClass('fadeInDown');
      $('#dropdownMenu').addClass('show');
      $('#dropdownMenu').on('animationend', function() { $('#dropdownMenu').addClass('show'); })
    }
  });

  // jQuery.fn.slideUpShow = function (time,callback) {
  //   if (!time)
  //       time = 1000;
  //   var o = $(this[0]) // It your element

  //   if (o.is(':hidden'))
  //   {
  //       var height = o.css({
  //           display: "block"
  //       }).height();

  //       o.css({
  //           overflow: "hidden",
  //           marginTop: height,
  //           height: 0
  //       }).animate({
  //           marginTop: 0,
  //           height: height
  //       }, time, function () {
  //           $(this).css({
  //               display: "",
  //               overflow: "",
  //               height: "",
  //               marginTop: ""
  //           });
  //           if (callback)
  //               callback();
  //       });
  //   }

  //   return this; // This is needed so others can keep chaining off of this
  // };

  // jQuery.fn.slideDownHide = function (time,callback) {
  //     if (!time)
  //         time = 200;
  //     var o = $(this[0]) // It your element
  //     if (o.is(':visible')) {
  //         var height = o.height();

  //         o.css({
  //             overflow: "hidden",
  //             marginTop: 0,
  //             height: height
  //         }).animate({
  //             marginTop: height,
  //             height: 0
  //         }, time, function () {
  //             $(this).css({
  //                 display: "none",
  //                 overflow: "",
  //                 height: "",
  //                 marginTop: ""
  //             });
  //             if (callback)
  //                 callback();
  //         });
  //     }

  //     return this;
  // }
  
});