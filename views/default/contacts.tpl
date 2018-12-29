    <main class="main">
      <div class="container">
        <div class="page">
          <p class="page__title mb-sm-0">Контакты</p>
         

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
              <div class="d-flex flex-column flex-grow-1 mr-md-5 mb-5 mb-md-0">
                <input id="name" class="input mb-2" type="text" name="name" placeholder="Имя">
                <input id="phone" class="input mb-2" type="text" name="phone" placeholder="Телефон">
                <input id="email" class="input" type="text" name="email" placeholder="Email">
              </div>
              <div class="flex-grow-1">
                <textarea class="input input_textarea" name="message" placeholder="Сообщение"></textarea>
              </div>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-start mt-5">
              <div class="recaptcha mr-md-5 mb-5 mb-md-0">
                <div class="g-recaptcha" data-sitekey="6Le-w4QUAAAAAOcxwpWlVCXIwO4m6ZYghcQNuj4q"></div>
                <div class="text-danger pl-2" id="recaptchaError"></div>
              </div>

              <div class="button__wrapper">
                <button type="submit" class="button button_square" name="messageForm">Отправить</button>
              </div>
              <span id="error"></span>
            </div>

          </form>
        </div>
      </div>

    </main>
    <!-- main -->