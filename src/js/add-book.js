'use strict';

$(function () {
  var ITEMS_ON_PAGE = 12;
  var books = rsProducts;

  //added number of pages
  var booksQuantity = Object.keys(books).length;
  var pagesQuantity = Math.ceil(booksQuantity / ITEMS_ON_PAGE);
  $('#page-7').text(pagesQuantity);


  document.querySelector('.books').innerHTML = '';

  var pickedPage = parseInt($('.pagination .active').html(), 10);
  var limit = ITEMS_ON_PAGE * pickedPage;
  var offset = limit - ITEMS_ON_PAGE;


  // added books into page
  var renderBooks = function(limit, offset) {
    var content = '';

    Object.keys(books).forEach(function(element, i) {


      if (i >= offset && i < limit) {
      content += '<a href="/?controller=product&id=' + i + '" class="book d-flex flex-column align-items-center position-relative">' +
        '<div class="book__mark position-absolute">';

        if (i >= offset && i < (offset + 4)) {
          content += '<img src="assets/img/new.png" alt="new">';
        }
        content += '</div>' +
        '<div class="book__img">' +
          '<img src="' + books[element]['image'] + '" alt="book" width="142" height="224">' + 
        '</div>' + 
        '<div class="book__descr">' +
          '<span class="author d-block">' + i + books[element]['author'] + '</span>' +
          '<span class="name d-block">' + books[element]['name'] + '</span>' +
        '</div>' +
      '</a>';
      }

    });

    document.querySelector('.books').innerHTML = content;
  };
  renderBooks(limit, offset);


  $('.pagination').on('click', function () {
    document.querySelector('.books').innerHTML = '';

    if ($('.pagination a').hasClass('active')) {
      var pickedPage = parseInt($('.pagination .active').html(), 10);
      var limit = ITEMS_ON_PAGE * pickedPage;
      var offset = limit - ITEMS_ON_PAGE;
      renderBooks(limit, offset);
    }

  });

});