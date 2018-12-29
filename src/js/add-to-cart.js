'use strict';

/**
* функция добавления товара в корзину
*
* @param integer itemId ID продукта
* @return в случай успеха обновятся данные корзины на странице
*/
function addToCart(itemId) {
    console.log('js - addToCart()');
    $.ajax({
        type: 'POST',
        async: false,
        url: '/?controller=cart&action=addtocart$id=' + itemId,
        dataType: 'json',
        success: function(data) {
            console.log('data: ' + data);
            if (data['success']) {
                $('#cartCntItems').html(data['cntItems']);
            }
        },
        error: function (request, status, error) {
            console.log(request.responseText);
        }
    })
}