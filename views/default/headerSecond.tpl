<header class="header header_page">
    <div class="container d-flex flex-wrap flex-lg-nowrap justify-content-sm-between align-items-center p-0 p-lg-3">
        <div class="header__logo logo order-1 flex-grow-0 flex-shrink-0 p-3 p-lg-0">
          <a href="/">
            <img src="assets/img/logo.png" alt="">
          </a>
        </div>
        <!-- logo -->

        <div class="header__menu menu order-3 order-md-2 order-lg-2 flex-grow-1 flex-sm-grow-0 text-center p-3 p-lg-0">

          {if isset($modCategoriesCat)} 
          <div class="dropdown"> 
            <button type="button" class="link link_dark link_uppercase link_dropdown" id="dropupMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Каталог
            </button>
            <div class="dropdown-menu" id="dropdownMenu">
                {foreach $modCategoriesCat as $cat}
                    <a class="dropdown-item" href="{ControllerComponent::link(['controller'=>'category', 'id' => $cat.id])}">{$cat.name}</a>
                {/foreach}
            </div>
          </div>
          {/if}
          
        </div>
        <!-- menu -->

        <div class="header__title title order-5 order-lg-3 flex-grow-1 flex-lg-grow-0 p-3 p-lg-0">
          <div>
            <img src="assets/img/title.png" alt="">
          </div>
        </div>
        <!-- title -->

        <div class="header__search search order-5 flex-grow-1 flex-sm-grow-0 text-center p-3 p-lg-0">

          <form action="/index.php?controller=category&id=1" method="GET" class="search-form search-form_index position-relative">
            <input type="hidden" value="category" name="controller">
            <input type="text" name="search" value="{if isset($search)}{$search}{/if}" class="search-form__input flex-grow-1" placeholder="Поиск товаров в каталоге">
            <div class="search-form__button-wrapper d-flex justify-content-center align-items-center">              
              <button type="submit" class="search-form__button button button_uppercase">ПОИСК</button>
            </div>
            <span class="search-form__close position-absolute d-none">x</span>
          </form>

          <button type="submit" class="search-form__open link link_dark button d-none">ПОИСК</button>
          
        </div>
        <!-- search -->
        {if isset($positionModHeader)}
            {include file="$positionModHeader"}
        {/if}
    </div>
</header>

        
