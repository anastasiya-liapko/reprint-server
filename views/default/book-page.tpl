    <main class="main">
      <div class="container">
        <div class="page book-page d-flex flex-column align-items-center align-items-xl-start flex-xl-row justify-content-between mt-5 mb-5 pb-5">

          <div class="book-page__cover flex-shrink-0 flex-grow-0 mb-5 mb-xl-0">
            <img src="assets/img/book.jpg" alt="book">
          </div>

          <div class="book-page__descr">
            <span class="page__title mt-0 mb-sm-0 d-block">Название книги</span>
            <span class="info__author d-block text-center">Автор И.О.</span>
            <div class="d-flex align-items-baseline mb-4 mt-3">
              <span class="info__category d-block w-50">Жанр(Раздел)</span>
              <span class="info__price d-block w-50 text-right">350 руб.</span>
            </div>
            <span class="info__subtitle d-block">Описание</span>
            <span class="info__text d-inline-block text-justify text-xl-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt</span>
            <span class="info__subtitle d-block">Еще информация:</span>
            <span class="info__text d-inline-block text-justify text-xl-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu</span>

            <form id="bookForm" class="book-page__form d-flex flex-column">

              <div class="select__wrapper d-flex flex-column flex-md-row justify-content-between">
                <div class="select__paper">
                  <span class="info__subtitle d-block">Бумага:</span>
                  <select name="paper" id="paper">
                    <option class="text-center" value="Глянцевая">Глянцевая</option>
                    <option class="text-center" value="Матовая">Матовая</option>
                  </select>
                </div>

                <div class="select__cover ml-md-3 mr-md-3">
                  <span class="info__subtitle d-block">Переплет:</span>
                  <select name="cover" id="cover">
                    <option class="text-center" value="Твердый">Твердый</option>
                    <option class="text-center" value="Мягкий">Мягкий</option>
                  </select>
                </div>

                <div class="select__format">
                  <span class="info__subtitle d-block">Формат:</span>
                  <select name="format" id="format">
                    <option class="text-center" value="А5">А5</option>
                    <option class="text-center" value="А4">А4</option>
                  </select>
                </div>
              </div>

              <div class="button__wrapper ml-auto mr-auto mr-xl-0">
                <button type="submit" id="addCart_{$itemId}" onClick="addToCart({$itemId})" class="button button_square">Добавить в корзину</button>
              </div>
            </form>

          </div>

        </div>
      </div>

    </main>
    <!-- main -->