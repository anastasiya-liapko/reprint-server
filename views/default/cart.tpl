    <main class="main">
      <div class="container">
        <div class="page">
          <form method="post" action="{ControllerComponent::link(['controller'=>'cart', 'action' => 'update'])}" id="cartForm" class="order__form pb-5 mb-2">
            <h1 class="page__title mb-3">Ваш заказ</h1>
            <span id="error">{if isset($errorMess)}{$errorMess}{/if}</span>
            <div class="order__items">

        
              {foreach $products as $key => $item}                 
              <input type="hidden" name="products[{$key}][product_id]" value="{$item.id}">
              <div class="order__item order__border-bottom pb-3 pt-3">

                <div class="d-flex flex-wrap align-items-center justify-content-between justify-content-lg-start justify-content-xl-between pr-lg-4 mt-3">

                  <div class="order__item-descr order-1 flex-md-grow-1 mb-lg-3">
                    <span class="d-block">
                        <a class="order__item-name" href="{ControllerComponent::link(['controller'=>'product', 'id' => $item.id])}">{$item.name}</a>
                    </span>
                    <span class="order__item-author d-block">{$item.author}</span>
                  </div>

                  <div class="order__item-price order__item-price_fix-width mt-3 mt-lg-0 mb-3 mb-lg-0 order-3 order-md-2">
                    <span class="number">{$item.price}</span>
                    <span class="currency">руб.</span>
                  </div>

                  <span class="order__item-multiplication sign sign__multiplication mt-3 mt-lg-0 mb-3 mb-lg-0 ml-4 mr-4 order-4 order-md-3">x</span>

                  <input type="text" name="products[{$key}][quantity]" value="{$item.quantity}" class="input order-5 order-md-4 mt-3 mt-lg-0 mb-3 mb-lg-0 quantity_js"  placeholder="кол-во">

                  {foreach $item.adv_params as $field => $param}    
                    <div class="select order-6 order-md-5 d-flex mb-3 mb-lg-0">
                        <span class="order__item-addition sign sign__addition ml-2 mr-2">+</span>
                        <select name="products[{$key}][{$field}]" class="adv_params_js">
                            {foreach $param as $v}
                                <option {if $v.is_default == 1} selected {/if} value="{$v.id}">{$v.name}</option>
                            {/foreach}
                        </select>
                    </div>
                  {/foreach}

                  <div class="order__item-price order__item-general-price d-flex justify-content-end justify-content-md-start order-9 order-md-8 mt-lg-3 mt-xl-0">
                    <span class="order__item-equal sign sign__equal ml-2 mr-2">=</span>
                    <span class="number">{$item.sum_item}</span>
                    <span class="currency">руб.</span>
                  </div>

                    <button class="order__item-del d-flex justify-content-end order-2 order-md-9 mt-lg-3 mt-xl-0" type="submit" name="delete" value="{$key}"> 
                        <span class="iconmoon icon-del"></span> 
                    </button>
                  
                </div>

              </div>
              <!-- order__item -->
              {/foreach}

              <div class="order__delivery d-flex justify-content-between order__border-bottom pb-3 pt-3">
                <span class="order__delivery-text">Доставка</span>
                <div class="order__item-price order__delivery-price order__delivery-price_fix-width">
                  <span class="order__item-addition sign sign__equal ml-2 mr-2">=</span>
                  <span class="number">{$sumDelivery}</span>
                  <span class="currency">руб.</span>
                </div>
              </div>
              <!-- order__delivery -->
              
              <div class="order__general d-flex justify-content-between pb-3 pt-3">
                <span class="order__general-text">Итого</span>
                <div class="order__item-price order__general-price order__general-price_fix-width">
                  <span class="order__item-addition sign sign__equal ml-2 mr-2">=</span>
                  <span class="number">{$itogo}</span>
                  <span class="currency">руб.</span>
                </div>
              </div>
            </div> 
            <!-- order__items -->

            <h2 class="page__title mb-5 mt-5">Получатель и адрес доставки</h2>

            <div class="order__contacts d-flex flex-wrap justify-content-between">

              <div class="order__delivery-type">
                <div class="select__delivery-type">
                  <label class="label d-block">Способ доставки:</label>
                  <select name="delivery_type" id="delivery-type" data-placeholder="Почтой">
                    <option value=""></option>
                    <option {if $requisites.delivery_type == 'courier'} selected {/if} value="courier">Курьер Москва</option>
                    <option {if $requisites.delivery_type == 'post'} selected {/if} value="post">Почтой</option>
                    <option {if $requisites.delivery_type == 'pickup'} selected {/if} value="pickup">Самовывоз</option>
                  </select>
                </div>
              </div>
             
              <div class="order__delivery-descr info-text d-flex align-items-end">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
              </div>

              <div class="order__recipient">
                <label class="label d-block" for="recipient">Получатель</label>
                <input type="text" class="input{if isset($errorRequisites.name)} error {/if}" id="recipient" name="name" value="{$requisites.name}" placeholder="Федор Петрович Рагозин">
              </div>

              <div class="order__address">
                <label class="label d-block" for="address">Адрес</label>
                <input type="text" class="input{if isset($errorRequisites.address)} error {/if}" id="address" name="address" value="{$requisites.address}" placeholder="Российская Федерация, Ленина 345900">
              </div>

              <div class="order__phone">
                <label class="label d-block" for="phone">Телефон</label>
                <input type="text" class="input{if isset($errorRequisites.phone)} error {/if}" id="phone" name="phone" value="{$requisites.phone}" placeholder="+7234567890">
              </div>

              <div class="order__email">
                <label class="label d-block" for="email">Email</label>
                <input type="email" class="input{if isset($errorRequisites.email)} error {/if}" id="email" name="email" value="{$requisites.email}" placeholder="default@mail.com">
              </div>

              <div class="order__comment">
                <label class="label d-block" for="comment">Комментарий</label>
                <textarea type="text" class="input input_textarea" id="comment" name="comment" rows="3">{$requisites.comment}</textarea>
              </div>
            </div>
            <!-- order__contacts -->

            <div class="d-flex flex-column flex-md-row justify-content-end align-items-center align-items-md-start mt-3">
              <div class="recaptcha mr-md-5 mb-4 mb-md-0">
                <div class="g-recaptcha" data-sitekey="6Le-w4QUAAAAAOcxwpWlVCXIwO4m6ZYghcQNuj4q"></div>
                <div class="text-danger pl-2" id="recaptchaError"></div>
              </div>

              <div class="button__wrapper order__button ml-md-5 ml-lg-0">
                <button type="submit" class="button button_square" name="send" value="1">Отправить</button>
              </div>
              
            </div>

          </form>
          <!-- order__form -->
        </div>
        <!-- page -->
      </div>
      <!-- container -->

    </main>
    <!-- main -->