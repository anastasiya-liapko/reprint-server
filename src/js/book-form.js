'use strict';

//после загрузки веб-страницы
$(function () {

  // при отправке формы messageForm на сервер (id="messageForm")
  $('#bookForm').submit(function (event) {
    
    // заведём переменную, которая будет говорить о том валидная форма или нет
    var formValid = true;


    // если форма валидна и длина капчи не равно пустой строке, то отправляем форму на сервер (AJAX)
    if ((formValid)) {
      var data = {};

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
