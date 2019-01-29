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
  
});