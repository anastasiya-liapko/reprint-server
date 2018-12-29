'use strict';

//после загрузки веб-страницы
$(function () {

  // при отправке формы messageForm на сервер (id="messageForm")
  $('#orderForm').submit(function (event) {
    
    // заведём переменную, которая будет говорить о том валидная форма или нет
    var formValid = true;

    // проверяем элемент, содержащий код капчи
    // 1. Получаем капчу
    var captcha = grecaptcha.getResponse();
    // 2. Если длина кода капчи, которой ввёл пользователь не равно 6,
      // то сразу отмечаем капчу как невалидную (без отправки на сервер)
    if (!captcha.length) {
      // Выводим сообщение об ошибке
      $('#recaptchaError').text('* Вы не прошли проверку "Я не робот"');
    } else {
      // получаем элемент, содержащий капчу
      $('#recaptchaError').text('');
    }

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

});
