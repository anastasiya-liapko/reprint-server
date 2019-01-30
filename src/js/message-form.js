'use strict';

//после загрузки веб-страницы
$(function () {

  jQuery(function($){
    $("#messageForm-phone").mask("+79999999999");
  });

  var required = ['name', 'phone', 'email', 'message'];

  var errorsTexts = 
  {
    email: 'Введите e-mail в формате default@mail.com',
    phone: 'Введите номер телефона в формате +1234567890'
  };

  var phonePattern = /\+7[0-9]{10}/;
  var emailPattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;


  var setError = function(errorObject) {
    $('#messageFormValid-' + errorObject.name).text(errorObject.error);
    $('#messageForm-' + errorObject.name).addClass('error');
  };

  var removeError = function(inputName) {
    $('#messageFormValid-' + inputName).text('');
    $('#messageForm-' + inputName).removeClass('error');
  };


  var data = {};
  var errorObject = {};


  var validateInput = function (inputName, inputValue) {
    errorObject = {};

    if (inputValue === '') {
      $.each(required, function (i, requiredFieldName) {
        if (inputName === requiredFieldName) {
          errorObject = {'name': inputName, 'error': 'Это обязательное поле'};
        }
      });
    } else {
      switch (inputName) {
        case 'phone': 
          errorObject = phonePattern.test(inputValue) ? {} : {'name': inputName, 'error': errorsTexts[inputName]};
          break;
        case 'email':
          errorObject = emailPattern.test(inputValue) ? {} : {'name': inputName, 'error': errorsTexts[inputName]};
          break;
      };
    }

    return errorObject;
  };


  var checkCaptcha = function() {
    // проверяем элемент, содержащий код капчи
    // 1. Получаем капчу
    var captcha = grecaptcha.getResponse();
    // 2. Если длина кода капчи, которой ввёл пользователь не равно 6,
      // то сразу отмечаем капчу как невалидную (без отправки на сервер)
    if (!captcha.length) {
      return false;
      // Выводим сообщение об ошибке
      // $('#recaptchaError').text('* Вы не прошли проверку "Я не робот"');
    } else {
      return true;
      // получаем элемент, содержащий капчу
      $('#recaptchaError').text('');
    }
  };


  var checkInputs = function(element) {
    var valid = true;

    element.find('input').each(function() {
      data[$(this)[0].name] = $(this).val();
    });

    element.find('textarea').each(function() {
      data[$(this)[0].name] = $(this).val();
    });

    $.each(data, function (inputName, inputValue) {
      var error = validateInput(inputName, inputValue);
      
      if (Object.keys(error).length > 0) {
        valid = false;
      }
    });

    return valid;
  };


  var addDisabled = function(form) {
    $('form .submit').addClass('disabled');
    $('form .submit').prop('disabled', true);
  }

  var removeDisabled = function(form) {
    $('form .submit').removeClass('disabled');
    $('form .submit').prop('disabled', false);
  }


  var checkForm = function(form) {
    var inputs = checkInputs($(form));
    var captcha = checkCaptcha();
    if(captcha && inputs) {
      removeDisabled(form);
    } else {
      addDisabled(form);
    }
  };


  // check events on inputs
  $('#messageForm input').on('change keyup blur', function() {
    removeError($(this).attr('name'));
    var error = validateInput($(this).attr('name'), $(this).val());
    if (Object.keys(error).length > 0) {
      setError(error);
      addDisabled('#messageForm');
    } else {
      checkForm('#messageForm');
    }
  })

  $('#messageForm textarea').on('change keyup blur', function() {
    removeError($(this).attr('name'));
    var error = validateInput($(this).attr('name'), $(this).val());
    if (Object.keys(error).length > 0) {
      setError(error);
      addDisabled('#messageForm');
    } else {
      checkForm('#messageForm');
    }
  })

  window.recaptchaCallback2 = function() {
    console.log('recaptcha callback2');
    checkForm('#messageForm');
  };


  // при отправке формы messageForm на сервер (id="messageForm")
  $('#messageForm').submit(function (event) {
    
    // заведём переменную, которая будет говорить о том валидная форма или нет
    // var formValid = true;
    // checkCaptcha();
    
    // если форма валидна и длина капчи не равно пустой строке, то отправляем форму на сервер (AJAX)
    // if ((formValid)) {
      var data = {};

      $(this).find('input').each(function() {
        data[$(this)[0].name] = $(this).val();
      })
      $(this).find('textarea').each(function() {
        data[$(this)[0].name] = $(this).val();
      })

      // технология AJAX
      $.ajax({
        //метод передачи запроса - POST
        type: "POST",
        //URL-адрес запроса
        url: "form.php",
        //передаваемые данные - formData
        data: data
        })
        //при успешном выполнении запроса
        .done(function( msg ) {
            $('#messageFormValid-send').text('Сообщение отправлено!');
            var obj = jQuery.parseJSON(msg);
            console.log(obj);
        });
        // отменим стандартное действие браузера
        event.preventDefault();
    // }
    
  });

});
