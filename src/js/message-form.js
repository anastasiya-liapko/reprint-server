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
  }

  var checkInputs = function(element) {
    element.find('input').each(function() {
      data[$(this)[0].name] = $(this).val();
    })
    element.find('textarea').each(function() {
      data[$(this)[0].name] = $(this).val();
    })
  }

  var addDisabled = function(form) {
    $('form .submit').addClass('disabled');
    $('form .submit').prop('disabled', true);
  }

  var removeDisabled = function(form) {
    $('form .submit').removeClass('disabled');
    $('form .submit').prop('disabled', false);
  }

  var checkForm = function(form) {
    checkInputs($(form));
    var captcha = checkCaptcha();
    console.log(captcha);
    console.log(data);
    if(captcha  
        && data['name'] !== "" 
        && data['message'] !== "" 
        && (/\+7[0-9]{10}/.test(data['phone']) || data['email'] !== "" )) {
      removeDisabled(form);
    } else {
      addDisabled(form);
    }
  }

  $('#messageForm input').on('change keyup blur', function() {
    checkForm('#messageForm');
  })
  $('#messageForm textarea').on('change keyup blur', function() {
    checkForm('#messageForm');
  })
  window.recaptchaCallback2 = function() {
    console.log('recaptcha callback2');
    checkForm('#messageForm');
  };


  // при отправке формы messageForm на сервер (id="messageForm")
  $('#messageForm').submit(function (event) {
    
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

});
