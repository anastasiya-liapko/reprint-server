    <main class="main">
      <div class="container">
        <div class="page">
          <p class="page__title page__title_uppercase mb-sm-0">история</p>
          <div id="sort" class="page__sort sort d-flex flex-column flex-sm-row justify-content-center">
            <span class="link link_page link_light active">сначала новинки</span>
            <span class="link link_page link_light mr-3 ml-3">по году издания</span>
            <span class="link link_page link_light">по алфавиту</span>   
          </div>
          <!-- sort -->

          <div class="page__books books d-flex flex-wrap">

            <!-- add-book.js -->

            <!-- <template id="product-template" class="d-none">
              <a href="/book-page.html" class="book d-flex flex-column align-items-center position-relative">
                <div class="book__mark position-absolute">
                  <img src="img/new.png" alt="new">
                </div>
                <div class="book__img">
                  <img src="' + books[element]['image'] + '" alt="book" width="142" height="224">
                </div>
                <div class="book__descr">
                  <span class="author d-block"></span>
                  <span class="name d-block"></span>
                </div>
              </a>
            </template> -->

          </div>
          <!--books -->

          <div class="pagination d-flex justify-content-center pt-5 pb-5">
            <div class="pagination__wrapper d-flex justify-content-between align-items-center">
              <a href="#" id="page-1" class="link link_page link_light active">1</a>
              <a href="#" id="page-2" class="link link_page link_light">2</a>
              <a href="#" id="page-3" class="link link_page link_light">3</a>
              <a href="#" id="page-4" class="link link_page link_light">4</a>
              <a href="#" id="page-5" class="link link_page link_light">5</a>
              <a href="#" id="page-6" class="link link_page link_light">...</a>
              <a href="#" id="page-7" class="link link_page link_light">137</a>
            </div>
          </div>
          <!-- pagination -->
        </div>
      </div>

    </main>
    <!-- main -->