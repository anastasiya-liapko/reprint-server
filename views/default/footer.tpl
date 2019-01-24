    <footer class="footer">
      <div class="container">
        <div class="footer__menu menu d-flex flex-column flex-md-row justify-content-between align-items-center pt-3 pb-3 pt-md-5 pb-md-5">  
          <!-- <a class="link link_dark link_uppercase" href="/index.php?controller=category">Каталог</a> -->

          <div class="btn-group dropup">
            <button type="button" class="link link_dark link_uppercase link_dropdown" id="dropupMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Каталог
            </button>
            <div class="dropdown-menu" id="dropupMenu">
              <a class="dropdown-item" href="/index.php?controller=category">История</a>
              <a class="dropdown-item" href="/index.php?controller=category">Фантастика</a>
            </div>
          </div>

          <a class="link link_dark link_uppercase" href="/index.php?controller=index&action=order">Как сделать заказ</a>
          <a class="link link_dark link_uppercase" href="/index.php?controller=index&action=services">Оплата и доставка</a>
          <a class="link link_dark link_uppercase" href="/index.php?controller=index&action=contacts">Контакты</a>
        </div>
      </div>

    </footer>
    <!-- footer -->


  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="    sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="assets/js/jquery.nice-select.js" type="text/javascript"></script>
  <script src="assets/js/jquery.maskedinput.js"></script>

  <script src="assets/js/mask.js"></script>
  <script src="assets/js/message-form.js"></script>
  <script src="assets/js/order-form.js"></script>
  <!--<script src="assets/js/pagination.js"></script>-->
  <!--<script src="assets/js/sort.js"></script>-->
  <script src="assets/js/book-form.js"></script>
  <script src="assets/js/search-form.js"></script>
  <script src="assets/js/add-to-cart.js"></script>
  <script src="assets/js/select.js"></script>
  <!-- <script src="assets/js/dropdown.js"></script> -->

  <!-- razdel -->
  {if isset($catId) && ($catId == 1 || $catId == 5)}
  <!--<script type="text/javascript">
    var rsProducts = {$rsProducts|json_encode};
  </script>-->
  <!--<script src="assets/js/add-book.js"></script>-->
  <!--<script src="assets/js/sort.js"></script>-->
  <!--<script src="assets/js/pagination.js"></script>-->
  {/if}

  </body>
</html>