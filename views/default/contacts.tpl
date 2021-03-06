    <main class="main">
      <div class="container">
        <div class="page">
          <h1 class="page__title mb-sm-0">Контакты</h1>
         

          <div class="contacts__info info pl-0 pb-5">
            <span class="info__title d-block text-center text-md-left">Телефоны</span>
            <span class="info__text d-inline-block text-justify text-md-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint</span>
            <span class="info__title d-block text-center text-md-left mt-4">Адрес</span>
            <span class="info__text d-inline-block text-justify text-md-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in</span>
          </div>
          <!-- contacts__info -->

          <p class="page__title mb-sm-0">Сообщение</p>

          <form id="messageForm" class="contacts__form mt-4 mb-5">
            <div class="d-flex flex-column flex-md-row justify-content-between">
              <div class="contacts__form-column d-flex flex-column justify-content-between mr-md-5 mb-5 mb-md-0">
                <input id="messageForm-name" class="input" type="text" name="name" placeholder="Имя">
                <span id="messageFormValid-name" class="error-text"></span>
                <input id="messageForm-phone" class="input mt-2" type="text" name="phone" placeholder="Телефон">
                <span id="messageFormValid-phone" class="error-text"></span>
                <input id="messageForm-email" class="input mt-2" type="text" name="email" placeholder="Email">
                <span id="messageFormValid-email" class="error-text"></span>
              </div>
              <div class="contacts__form-column d-flex flex-column justify-content-between">
                <textarea id="messageForm-message" class="input input_textarea flex-grow-1" name="message" placeholder="Сообщение"></textarea>
                <span id="messageFormValid-message" class="error-text"></span>
              </div>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-start mt-5">
              <div class="recaptcha mr-md-5 mb-5 mb-md-0">
                <div class="g-recaptcha" data-callback="recaptchaCallback2" data-sitekey="6Le-w4QUAAAAAOcxwpWlVCXIwO4m6ZYghcQNuj4q"></div>
                <div class="error-text pl-2" id="recaptchaError"></div>
              </div>

              <div class="button__wrapper">
                <button id="js-messageFormBtnSubmit" type="submit" class="button button_square disabled submit" name="messageForm" disabled>Отправить</button>
              </div>
              <span id="error"></span>
            </div>

            <span id="messageFormValid-send" class="error-text error-text_bigger-font d-block text-center mt-2"></span>

          </form>
        </div>
      </div>

    </main>
    <!-- main -->