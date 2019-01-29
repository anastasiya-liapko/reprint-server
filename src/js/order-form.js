'use strict';

//после загрузки веб-страницы
$(function () {
  var data = {};

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
    element.find('input').each(function() {
      data[$(this)[0].name] = $(this).val();
    })
    element.find('textarea').each(function() {
      data[$(this)[0].name] = $(this).val();
    })
    element.find('select').each(function() {
      data[$(this)[0].name] = $(this).val();
    })
  };

  var addDisabled = function(form) {
    $('form .submit').addClass('disabled');
    $('form .submit').prop('disabled', true);
  };

  var removeDisabled = function(form) {
    $('form .submit').removeClass('disabled');
    $('form .submit').prop('disabled', false);
  };

  var checkForm = function(form) {
    checkInputs($(form));
    var captcha = checkCaptcha();
    console.log(captcha);
    console.log(data);
    if(captcha 
        && data['delivery_type'] !== "" 
        && data['name'] !== "" 
        && data['address'] !== "" 
        && /\+7[0-9]{10}/.test(data['phone']) 
        && data['comment'] !== "" ) {
      removeDisabled(form);
    } else {
      addDisabled(form);
    }
  };

  $('#cartForm input').on('change keyup blur', function() {
    checkForm('#cartForm');
  });
  $('#cartForm textarea').on('change keyup blur', function() {
    checkForm('#cartForm');
  });
  $('#cartForm select').on('change blur', function() {
    checkForm('#cartForm');
  });
  window.recaptchaCallback = function() {
    console.log('recaptcha callback');
    checkForm('#cartForm');
  };


  // при отправке формы messageForm на сервер (id="messageForm")
  $('#orderForm').submit(function (event) {
    
    // заведём переменную, которая будет говорить о том валидная форма или нет
    var formValid = true;
    checkCaptcha();

    // если форма валидна и длина капчи не равно пустой строке, то отправляем форму на сервер (AJAX)
    if ((formValid)) {
      var data = {};

      $(this).find('input').each(function() {
        data[$(this)[0].name] = $(this).val();
      })
      $(this).find('textarea').each(function() {
        data[$(this)[0].name] = $(this).val();
      })
      $(this).find('select').each(function() {
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
            // console.log(msg);
            var obj = jQuery.parseJSON(msg);
            console.log(obj);
        });
        // отменим стандартное действие браузера
        event.preventDefault();
    }
    
  });

  $('#cartForm .input_qty').on('keypress', function(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
          return false;
      }
      return true;
  });

  $('#del').on('click', function(evt) {
    evt.preventDefault();
  })

});
