'use strict';

$(function () {
  var ESC_KEYCODE = 27;

  $('.search-form__open').click(function() {
    $('.search-form_index').removeClass('fadeOut');
    $('.header_index').addClass('open');
    $('.search-form_index').addClass('fadeIn');
    $('.search-form_index').on('animationend', function() { $('.header_index').addClass('open'); })

    // $('.search-form_index .search-form__input').focus();
  })

  $('.search-form__close').click(function() {
    $('.search-form_index').removeClass('fadeIn');
    $('.search-form_index').addClass('fadeOut');
    $('.search-form_index').on('animationend', function() { $('.header_index').removeClass('open'); })
  })
  
  $(document).keyup(function(e) {
    if (e.key === "Escape") {
      $('.search-form_index').removeClass('fadeIn');
      $('.search-form_index').addClass('fadeOut');
      $('.search-form_index').on('animationend', function() { $('.header_index').removeClass('open'); })
    }
  });

});