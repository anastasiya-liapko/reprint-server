{if $modCartTotal > 0}  
    <a href="{ControllerComponent::link(['controller'=>'cart'])}" class="header__basket basket d-flex justify-content-end align-items-center order-2 order-sm-4  order-md-4 order-lg-5 flex-grow-1 flex-md-grow-0 pl-0 pt-3 pr-3 pb-3 p-lg-0">
        <div class="basket__image d-flex align-items-center mr-2 mr-lg-4">
            <img src="assets/img/buy.png" alt="Корзина товаров">
        </div>
        <div class="d-flex flex-column">
            <span class="basket__quantity"><span id="modCartQuantity">{$modCartQuantity}</span> экз</span>
            <span class="basket__sum"><span id="modCartTotal">{$modCartTotal}</span> руб</span>
        </div>
    </a>
{else}
    <div class="header__basket basket d-flex justify-content-end align-items-center order-2 order-sm-4  order-md-4 order-lg-5 flex-grow-1 flex-md-grow-0 pl-0 pt-3 pr-3 pb-3 p-lg-0">
        <div class="basket__image d-flex align-items-center mr-2 mr-lg-4">
            <img src="assets/img/buy.png" alt="Корзина товаров">
        </div>
        <div class="d-flex flex-column">

        </div>
    </div>
{/if}