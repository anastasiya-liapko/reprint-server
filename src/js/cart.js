"use strict";

(function ($) {

    //корзина
    var timeoutId = 0, form,status = false, modCartQuantity, modCartTotal, sumDelivery, itogo, send, validInputs = [];
    // end корзина

    //BookPage
    var priceItem, selects = {}, params = {}, price = 0;
    // end BookPage



    //корзина
    function tikTak(){
        clearTimeout(timeoutId);
        timeoutId = setTimeout(function() { 
            form.submit(); 
        }, 1300 );  
    }

    function deleteProduct(val, button) {
        if(status) return;
        status = true;
   
        $.ajax({
            type: "POST",
            cache: false,
            dataType: "json",
            url: '/index.php?controller=cart&action=delete_product',
            data: {delete:val}
        }).done(
            function (data) {
                if(data.status) {
                    modCartQuantity.text(data.quantity);
                    modCartTotal.text(data.itogo);
                    sumDelivery.text(data.sumDelivery);
                    itogo.text(data.itogo);           
                    var row = button.parents('div.order__item');
                    row.remove();
                }
            }
        );
        status = false;
    }


    function changeDelivery(sel) {       
        if(status) return;
        status = true;
   
        $.ajax({
            type: "POST",
            cache: false,
            dataType: "json",
            url: '/index.php?controller=cart&action=change_delivery',
            data: {delivery_type:sel.val()}
        }).done(
            function (data) {   
                if(data.status) {          
                    modCartTotal.text(data.itogo);
                    sumDelivery.text(data.sumDelivery);
                    itogo.text(data.itogo);
                }
            }
        );
        status = false;
    }

    function formStart(){        
        var inp = ['name', 'address', 'phone', 'email', 'delivery-type'];
        send = $('#send');        

        for (var i = 0; i < inp.length; i++) {		
            var input = $('#'+inp[i]);
            validateInput(input, i, inp[i], false);

            (function(i2, input2, name){
                input2.on('change blur keyup', function() {
                    validateInput(input2, i2, name, true);
                });
            })(i, input, inp[i]);        
        }     
        
        validateForm();
    }


    var errorsObject = {};

    function validateInput(input, i, name, runValid){
        var v = input.val();        
        if(name == 'phone') {
            if(/\+7[0-9]{10}/.test(v)) {
                validInputs[i] = true;
            } else {
                validInputs[i] = false;
                errorsObject[i] = {
                    'name': name,
                    'error': 'Введите номер телефона в формате +1234567890'
                };
            }
        } else if(name == 'email') {
            var pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;          
            if(pattern.test(v)) {
                validInputs[i] = true;
            } else { 
                validInputs[i] = false;
                errorsObject[i] = {
                    'name': name,
                    'error': 'Введите e-mail в формате default@mail.com'
                };
            }
        } else {
            if(v.length > 2) {
                validInputs[i] = true;
            } else { 
                validInputs[i] = false;
                errorsObject[i] = {
                    'name': name,
                    'error': 'Это обязательное поле'
                };
            }
        }
            
        if(runValid){
            if(validInputs[i]) {
                input.removeClass('error');
                errorsObject[i] !== undefined ? $('#cartFormValid-' + errorsObject[i].name).text('') : '' ;
            } else {
                input.addClass('error');
                errorsObject[i] !== undefined ? $('#cartFormValid-' + errorsObject[i].name).text(errorsObject[i].error) : '' ;
            } 
                        
        }
        validateForm();
      
    }


    function validateForm(){
        var valid = true;
        for (var i = 0; i < validInputs.length; i++) {
            if(validInputs[i] == false) {
                valid = false;
            }
        }       
        /*if(valid) {
            var captcha = grecaptcha.getResponse();
            if(!captcha.length) {
                valid = false;
            }            
        }*/
        if(valid) {            
            send.removeClass('disabled');
            send.prop('disabled', false);
        } else  {
            send.addClass('disabled');
            send.prop('disabled', true);
        }
        //console.log(validInputs);       
    }


    $.startCart = function(){

        form = $('#cartForm');
        modCartQuantity = $('#modCartQuantity');
        modCartTotal = $('#modCartTotal');
        sumDelivery = $('#sumDelivery');
        itogo = $('#itogo');
      
        form.find('input.quantity_js').on('keypress', function(t){
            var e = (t = t || window.event).which ? t.which : t.keyCode;
            return !(31 < e && (e < 48 || 57 < e));
        });
      
        form.find('select.adv_params_js, input.quantity_js').on('change keyup', function(){          
            tikTak();
        });

        $('#delivery-type').on('change', function(){ changeDelivery($(this)); });
        
        $('#modalDelete').on('shown.bs.modal', function(event) {        
            var button = $(event.relatedTarget); 
            var key = button.data('key');
            var modal = $(this);
            $('#yesDelete').on('click', function(){
                modal.modal('hide');
                deleteProduct(key, button);
            });
        });

        formStart();
    }
    // end корзина




    //BookPage
    function calcPrice(){
        var newPrice = price;
        for(var t in selects) {		
            var id = selects[t].val();
            if( (params[t] !== undefined) && (params[t][id] !== undefined) ) {
                newPrice = newPrice + parseFloat(params[t][id]);
            }
        }
        priceItem.text(newPrice);
    }

    $.startBookPage = function(params0, price0){
        priceItem = $('#priceItem');
        params = params0;  
        price = parseFloat( price0 );

        var selects0 = $('select.adv_params_js');
        selects0.each(function(){
            var el = $(this);
            var key = el.attr('name');
            selects[key] = el;
        });

        selects0.on('change', function(){
            calcPrice();
        });
    }
    // end BookPage


})(jQuery);