    <main class="main">
      <div class="container">
        <div class="page book-page d-flex flex-column align-items-center align-items-xl-start flex-xl-row justify-content-between mt-5 mb-5 pb-5">

          <div class="book-page__cover flex-shrink-0 flex-grow-0 position-relative">

            <!-- Slider main container -->
            <div class="{if $images} swiper-container {else} {/if}">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    {if $images}
                        {foreach $images as $img}    
                            <div class="swiper-slide">
                                <img src="{$img.img}" alt="{$product.name}">                        
                            </div>
                        {/foreach}
                    {else}
                        <div class="swiper-slide">
                            <img src="/assets/img/book.jpg" alt="Нет фото">                        
                        </div>
                    {/if}
                </div>
            </div>
            <!-- swiper-container -->

            {if $images && count($images) > 1}
            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            {/if}

          </div>

          <div class="book-page__descr">
            <h1 class="page__title mt-0 mb-sm-0 d-block">{$product.name}</h1>
            <span class="info__author d-block text-center">{$product.author}</span>
            <div class="d-flex align-items-baseline mb-4 mt-3">          
              <a class="info__category d-block w-50" href="{ControllerComponent::link(['controller'=>'category', 'id' => $category.id])}">{$category.name}</a>
              <span class="info__price d-block w-50 text-right" >
                <span id="priceItem">{HtmlComponent::priceFormat($product.price)}</span> 
                руб.
                </span>
            </div>
            <h3 class="info__subtitle d-block">Описание</h3>
            <div class="info__text d-inline-block text-justify text-xl-left">{$product.dsc}</div>
            <h3 class="info__subtitle d-block">Еще информация:</h3>
            <div class="info__text d-inline-block text-justify text-xl-left">{$product.extra}</div>

            <form action="{ControllerComponent::link(['controller'=>'cart', 'action' => 'add'])}" method="post" id="bookForm" class="book-page__form d-flex flex-column">
                <input type="hidden" name="product_id" value="{$product.id}">
                <input type="hidden" name="quantity" value="1">

              
                <div class="select__wrapper d-flex flex-column flex-md-row justify-content-between">

                    {if $adv_params}
                        {foreach $adv_params as $name => $param}
                            <div class="select {if $name == 'cover'}ml-md-3 mr-md-3{/if}">
                                <span class="info__subtitle d-block">{$param.label}</span>
                                <select name="{$name}" class="adv_params_js">                    
                                {foreach $param.values as $item }
                                    <option {if $item.is_default == 1} selected {/if} value="{$item.id}">{$item.name}</option>
                                {/foreach}                    
                                </select>
                            </div>
                        {/foreach}
                    {/if}
                
                </div>

              <div class="button__wrapper ml-auto mr-auto mr-xl-0">            
                <button type="submit" class="button button_square">Добавить в корзину</button>
              </div>
            </form>

          </div>

        </div>
      </div>

    </main>
    <!-- main -->