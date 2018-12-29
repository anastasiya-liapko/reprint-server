'use strict';

$(function () {

  $('.pagination a').click(function (event) {
    event.preventDefault();

    var MIN_VALUE = 1;
    var value = parseInt($(this).text(), 10);
    var maxValue = parseInt($('#page-7').text(), 10);
  
    if ($(this).attr('id') === 'page-5' && value < (maxValue - 2)) {

      $('.pagination a').removeClass('active');
      $('#page-4').addClass('active');

      $('#page-1').text('1');
      $('#page-2').text('...');
      $('#page-3').text(value - 1);
      $('#page-4').text(value);
      $('#page-5').text(value + 1);

      if (value === (maxValue - 3)) {
        $('#page-6').text(value + 2);
      }

    } else if ($(this).attr('id') === 'page-3' && value > (MIN_VALUE + 2) && $('#page-2').text() === '...') {

      $('.pagination a').removeClass('active');
      $('#page-4').addClass('active');

      $('#page-3').text(value - 1);
      $('#page-4').text(value);
      $('#page-5').text(value + 1);
      $('#page-6').text('...');

      if (value === (MIN_VALUE + 3)) {
        $('#page-2').text(value - 2);
      }

    } else if ($(this).attr('id') === 'page-7') {

      $('.pagination a').removeClass('active');
      $(this).addClass('active');

      $('#page-2').text('...');
      $('#page-3').text(value - 4);
      $('#page-4').text(value - 3);
      $('#page-5').text(value - 2);
      $('#page-6').text(value - 1);

    } else if ($(this).attr('id') === 'page-1') {

      $('.pagination a').removeClass('active');
      $(this).addClass('active');

      $('#page-2').text(value + 1);
      $('#page-3').text(value + 2);
      $('#page-4').text(value + 3);
      $('#page-5').text(value + 4);
      $('#page-6').text('...');

    } else if ($(this).attr('id') === 'page-3' && $('#page-2').text() !== '...') {

      $('.pagination a').removeClass('active');
      $(this).addClass('active');

    } else if ($(this).attr('id') === 'page-3' && value === (MIN_VALUE + 2)) {

      $('.pagination a').removeClass('active');
      $('#page-4').addClass('active');

      $('#page-2').text(value - 1);
      $('#page-3').text(value);
      $('#page-4').text(value + 1);
      $('#page-5').text(value + 2);
      $('#page-6').text('...');

    } else if ($(this).text() === '...') {

    } else {

      $('.pagination a').removeClass('active');
      $(this).addClass('active');

    }

  })
});