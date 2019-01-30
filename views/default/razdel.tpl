    <main class="main">
      <div class="container">
        <div class="page">
          <h1 class="page__title page__title_uppercase mb-sm-0">{$categoryName.name}</h1>
          <div id="sort" class="page__sort sort d-flex flex-column flex-sm-row justify-content-center">
            <!--<span class="link link_page link_light active">сначала новинки</span>-->
            <span class="link link_page link_light mr-3 ml-3">             
              <a href="{ControllerComponent::link($link, ['order'=>'flags','asc'=>$asc2,'page'=> 1])}" class="link link_page link_light {if $order == 'flags'} active {/if}">
                новинки
              </a>
            </span>            
            <span class="link link_page link_light mr-3 ml-3">             
              <a href="{ControllerComponent::link($link, ['order'=>'author','asc'=>$asc2,'page'=> 1])}" class="link link_page link_light {if $order == 'author'} active {/if}">
                по автору
              </a>
            </span>
            <span class="link link_page link_light mr-3 ml-3">
              <a href="{ControllerComponent::link($link, ['order'=>'name','asc'=>$asc2,'page'=> 1])}" class="link link_page link_light {if $order == 'name'} active {/if}">
                по наименованию
              </a>
            </span>   
          </div>
          
          <!-- sort -->

          <div class="page__books books d-flex flex-wrap">

            <!-- add-book.js -->
            {foreach $rsProducts as $books }            
             <!--<template id="product-template" class="d-none">-->
              <a href="{ControllerComponent::link(['controller'=>'product', 'id' => $books.id])}" 
              class="book d-flex flex-column align-items-center position-relative {if in_array($books.id, $cartProductId)}picked{/if}">
                {if isset($books.flags) && $books.flags == 1}
                    <div class="book__mark position-absolute">
                        <img src="/assets/img/new.png" alt="new">
                    </div>
                {/if}
                <div class="book__img">
                  <img src="{if isset($books.image)}{$books.image}{else}/assets/img/book.jpg{/if}" alt="{$books.name}" width="142" height="224">
                </div>
                <div class="book__descr">
                  <span class="author d-block">{$books.author}</span>
                  <span class="name d-block">{$books.name}</span>
                </div>
              </a>
            <!--</template> -->
            {/foreach}
          </div>
          <!--books -->     

          <div class="pagination__wrapper d-flex justify-content-center pt-5 pb-5">            
          {HtmlComponent::pagination($page, $count, $itemInPage, $link, ['cssLink'=>'link link_page link_light', 'cssActive'=>'link link_page link_light active', 'text_first' => false,
            'text_last' => false,
            'text_next' => false,
            'text_prev' => false ])}
          <!-- pagination -->
        </div>
      </div>

    </main>
    <!-- main -->