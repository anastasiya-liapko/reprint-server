    <main class="main">
      <div class="container">
        <div class="page book-page d-flex flex-column align-items-center align-items-xl-start flex-xl-row justify-content-between mt-5 mb-5 pb-5">

          <div class="book-page__cover flex-shrink-0 flex-grow-0 mb-5 mb-xl-0">
            <img src="{if $image}{$image}{else}/assets/img/book.jpg{/if}" alt="{$product.name}">
            <!-- $images - другие картинки книги -->
          </div>

          <div class="book-page__descr">
            <span class="page__title mt-0 mb-sm-0 d-block">{$product.name}</span>
            <span class="info__author d-block text-center">{$product.author}</span>
            <div class="d-flex align-items-baseline mb-4 mt-3">
              <span class="info__category d-block w-50">{$category.name}</span>
              <span class="info__price d-block w-50 text-right">{$product.price}</span>
            </div>
            <span class="info__subtitle d-block">Описание</span>
            <span class="info__text d-inline-block text-justify text-xl-left">{$product.dsc}</span>
            <span class="info__subtitle d-block">Еще информация:</span>
            <span class="info__text d-inline-block text-justify text-xl-left">{$product.extra}</span>

            <form id="bookForm" class="book-page__form d-flex flex-column">

              
                <div class="select__wrapper d-flex flex-column flex-md-row justify-content-between">

                {if $types}
                  <div class="select select__paper">
                    <span class="info__subtitle d-block">Бумага:</span>
                    <select name="paper" id="paper">                    
                      {foreach $types as $item }
                        <option class="text-center" {if $item.is_default == 1} selected {/if} value="{$item.id}">{$item.name}</option>
                      {/foreach}                    
                    </select>
                  </div>
                  
                {/if}

                {if $covers}
                  <div class="select select__cover ml-md-3 mr-md-3">
                    <span class="info__subtitle d-block">Переплет:</span>
                    <select name="cover" id="cover">                    
                      {foreach $covers as $item }
                        <option class="text-center" {if $item.is_default == 1} selected {/if} value="{$item.id}">{$item.name}</option>
                      {/foreach}                    
                    </select>
                  </div>
                {/if}

                {if $formats}
                  <div class="select select__format">
                    <span class="info__subtitle d-block">Формат:</span>
                    <select name="format" id="format">                    
                      {foreach $formats as $item }
                        <option class="text-center" {if $item.is_default == 1} selected {/if} value="{$item.id}">{$item.name}</option>
                      {/foreach}                    
                    </select>
                  </div>               
                {/if}

                </div>

              <div class="button__wrapper ml-auto mr-auto mr-xl-0">
                <!-- <button type="submit" id="addCart_{$itemId}" onClick="addToCart({$itemId})" class="button button_square">Добавить в корзину</button> -->
                <button type="submit" class="button button_square">Добавить в корзину</button>
              </div>
            </form>

          </div>

        </div>
      </div>

    </main>
    <!-- main -->