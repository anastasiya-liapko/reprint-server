    <main class="main">
      <div class="container">
        <div class="page">
          <form id="orderForm" class="order__form pb-5 mb-2">
            <p class="page__title mb-3">Ваш заказ</p>
           
            <div class="order__items">

              {section name=product start=0 loop=2}
              <div class="order__item order__border-bottom pb-3 pt-3">

                <div class="d-flex flex-wrap align-items-center justify-content-between mt-3">

                  <div class="order__item-descr order-1 flex-md-grow-1 mb-lg-3">
                    <span class="order__item-name d-block">Маша и Медведь</span>
                    <span class="order__item-author d-block">Автор И.О.</span>
                  </div>
                  
                  <div class="order__item-wrapper d-flex flex-wrap flex-xl-nowrap align-items-center order-2 w-100">
                  <div class="order__item-price order__item-price_fix-width mt-3 mt-lg-0 mb-3 mb-lg-0 order-4 order-lg-2">
                    <span class="number">350</span>
                    <span class="currency">руб.</span>
                  </div>

                  <span class="order__item-multiplication sign sign__multiplication mt-3 mt-lg-0 mb-3 mb-lg-0 ml-4 mr-4 order-5 order-lg-3">x</span>

                  <input type="text" id="item1-quantity" name="item1-quantity" class="input order-6 order-lg-4 mt-3 mt-lg-0 mb-3 mb-lg-0" id="order__item-quantity" placeholder="2">

                  <div class="order__item-select d-flex flex-column flex-md-row flex-grow-1 order-3 order-lg-5">
                    <div class="select select__paper d-flex mb-3 mt-3 mt-md-0 mb-lg-0">
                      <span class="order__item-addition sign sign__addition ml-2 mr-2">+</span>
                      <select name="item-paper_{$smarty.section.product.index}" id="item-paper_{$smarty.section.product.index}"  data-placeholder="Глянцевая">
                        <option class="text-center" value="Глянцевая">Белая 80 г/м</option>
                        <option class="text-center" value="Матовая">Слоновая кость 80 г/м</option>
                        <option class="text-center" value="Матовая">Белая 160 г/м</option>
                        <option class="text-center" value="Матовая">Слоновая кость 120 г/м</option>
                        <option class="text-center" value="Матовая">Слоновая кость 160 г/м</option>
                        <option class="text-center" value="Матовая">Верже</option>
                      </select>
                    </div>

                    <div class="select select__cover flex-grow-1 order-7 order-lg-6 d-flex mb-3 mb-lg-0">
                      <span class="order__item-addition sign sign__addition ml-2 mr-2">+</span>
                      <select name="item-cover_{$smarty.section.product.index}" id="item-cover_{$smarty.section.product.index}" data-placeholder="Твердый">
                        <option class="text-center" value="Твердый">Листы в подборе (под переплёт)</option>
                        <option class="text-center" value="Мягкий">Мягкий переплет (КБС)</option>
                        <option class="text-center" value="Мягкий">Полукожаный переплёт</option>
                        <option class="text-center" value="Мягкий">Цельнокожаный переплёт</option>
                      </select>
                    </div>

                    <div class="select select__format order-8 order-lg-7 d-flex mb-md-3 mb-lg-0">
                      <span class="order__item-addition sign sign__addition ml-2 mr-2">+</span>
                      <select name="item-format_{$smarty.section.product.index}" id="item-format_{$smarty.section.product.index}" data-placeholder="А5">
                        <option class="text-center" value="А5">Оригинал</option>
                        <option class="text-center" value="А4">17х24</option>
                        <option class="text-center" value="А4">А4</option>
                      </select>
                    </div>
                  </div>

                  <div class="order__item-price order__item-general-price d-flex justify-content-end justify-content-md-start order-7 order-lg-8 mt-lg-3 mt-xl-0">
                    <span class="order__item-equal sign sign__equal ml-2 mr-2">=</span>
                    <span class="number">500</span>
                    <span class="currency">руб.</span>
                  </div>

                  <div class="order__item-del d-flex justify-content-end order-2 order-lg-9 mb-3 mb-lg-0 mt-lg-3 mt-xl-0">
                    <div class="order__item-del-wrapper">
                      <span class="iconmoon icon-del"></span>
                    </div>
                  </div>
                  </div>

                </div>

              </div>
              <!-- order__item -->
              {/section}

              <div class="order__delivery d-flex justify-content-between order__border-bottom pb-3 pt-3">
                <span class="order__delivery-text">Доставка</span>
                <div class="order__item-price order__delivery-price order__delivery-price_fix-width">
                  <span class="order__item-addition sign sign__equal ml-2 mr-2">=</span>
                  <span class="number">500</span>
                  <span class="currency">руб.</span>
                </div>
              </div>
              <!-- order__delivery -->

              <div class="order__general d-flex justify-content-between pb-3 pt-3">
                <span class="order__general-text">Общая схема доставки</span>
                <div class="order__item-price order__general-price order__general-price_fix-width">
                  <span class="order__item-addition sign sign__equal ml-2 mr-2">=</span>
                  <span class="number">12500</span>
                  <span class="currency">руб.</span>
                </div>
              </div>
            </div>
            <!-- order__items -->

            <p class="page__title mb-5 mt-5">Получатель и адрес доставки</p>

            <div class="order__contacts d-flex flex-wrap justify-content-between">

              <div class="order__delivery-type">
                <div class="select__delivery-type">
                  <label class="label d-block">Способ доставки:</label>
                  <select name="delivery-type" id="delivery-type" data-placeholder="Курьер Москва">
                    <option class="text-center" value="Курьер Москва">Курьер Москва</option>
                    <option class="text-center" value="Курьер Москва">Курьер Москва</option>
                  </select>
                </div>
              </div>
             
              <div class="order__delivery-descr info-text d-flex align-items-end">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
              </div>

              <div class="order__recipient">
                <label class="label d-block" for="recipient">Получатель</label>
                <input type="text" class="input" id="recipient" name="recipient" placeholder="Федор Петрович Рагозин">
              </div>

              <div class="order__address">
                <label class="label d-block" for="address">Адрес</label>
                <input type="text" class="input" id="address" name="address" placeholder="Российская Федерация,Ленина 345900">
              </div>

              <div class="order__phone">
                <label class="label d-block" for="phone">Телефон</label>
                <input type="text" class="input" id="phone" name="phone" placeholder="+1234567890">
              </div>

              <div class="order__email">
                <label class="label d-block" for="email">Email</label>
                <input type="text" class="input" id="email" name="email" placeholder="default@mail.com">
              </div>

              <div class="order__comment">
                <label class="label d-block" for="comment">Комментарий</label>
                <textarea type="text" class="input input_textarea" id="comment" name="comment" rows="3"></textarea>
              </div>
            </div>
            <!-- order__contacts -->

            <div class="d-flex flex-column flex-md-row justify-content-end align-items-center align-items-md-start mt-3">
              <div class="recaptcha mr-md-5 mb-4 mb-md-0">
                <div class="g-recaptcha" data-sitekey="6Le-w4QUAAAAAOcxwpWlVCXIwO4m6ZYghcQNuj4q"></div>
                <div class="text-danger pl-2" id="recaptchaError"></div>
              </div>

              <div class="button__wrapper order__button ml-md-5 ml-lg-0">
                <button type="submit" class="button button_square" name="messageForm">Отправить</button>
              </div>
              <span id="error"></span>
            </div>

          </form>
          <!-- order__form -->
        </div>
        <!-- page -->
      </div>
      <!-- container -->

    </main>
    <!-- main -->