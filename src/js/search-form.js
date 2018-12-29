'use strict';

$(function () {
  var ESC_KEYCODE = 27;

  $('.search-form__open').click(function() {
    $('.header_index').toggleClass('open');

    $('.search-form_index .search-form__input').focus();
  })

  $('.search-form__close').click(function() {
    $('.header_index').toggleClass('open');
  })
  
  $(document).keyup(function(e) {
    if (e.key === "Escape") {
      $('.header_index').removeClass('open');
    }
  });
});