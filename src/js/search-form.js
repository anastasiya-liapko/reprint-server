'use strict';

$(function () {
  var ESC_KEYCODE = 27;

  $('.search-form__open').click(function() {
    console.log('open');
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

  // $('body').click(function(event) {
  //   var target = event.target;
  //   var val = target.className.split(' ').shift();

  //   console.log(val);
  //   if(val === 'search-form__open') {
  //     console.log('addClass open');
  //     $('.header_index').toggleClass('open');
  //     $('.search-form_index .search-form__input').focus();

  //   } else if(val === 'search-form__close') {
  //     console.log('addClass open');
  //     $('.header_index').toggleClass('open');

  //   } else {
  //     if($('.header_index').hasClass('open')) {
  //       $('.header_index').removeClass('open');
  //     }
  //   }

  // })
});