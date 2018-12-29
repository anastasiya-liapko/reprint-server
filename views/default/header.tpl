<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <title>{$pageTitle}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="" type="image/png">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700,900&amp;subset=cyrillic" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

    <link rel="stylesheet" href="assets/css/fonts.css">
    <link rel="stylesheet" href="assets/css/style.min.css">

    <link href="assets/css/jquery.formstyler.css" rel="stylesheet" />
    <link href="assets/css/jquery.formstyler.theme.css" rel="stylesheet" />
  </head>

  <body>

    <header class="header {if isset($currentUrl) && $currentUrl === 'index' } header_index {else} header_page {/if}">
      <div class="container d-flex flex-wrap flex-lg-nowrap justify-content-sm-between align-items-center p-0 p-lg-3">
        <div class="header__logo logo order-1 flex-grow-0 flex-shrink-0 p-3 p-lg-0">
          <a href="?controller=index&action=index">
            <img src="assets/img/logo.png" alt="">
          </a>
        </div>
        <!-- logo -->

        <div class="header__menu menu order-3 order-md-2 order-lg-2 flex-grow-1 flex-sm-grow-0 text-center p-3 p-lg-0">
          <a class="link link_dark" href="/?controller=category&id=1">КАТАЛОГ</a>
        </div>
        <!-- menu -->

        <div class="header__title title order-5 order-lg-3 flex-grow-1 flex-lg-grow-0 p-3 p-lg-0">
          <div>
            <img src="assets/img/title.png" alt="">
          </div>
        </div>
        <!-- title -->

        <div class="header__search search {if isset($currentUrl) && $currentUrl === 'index'} order-4 order-md-3 order-lg-4 {else} order-5 {/if} flex-grow-1 flex-sm-grow-0 text-center p-3 p-lg-0">
          <form action="/?controller=cart&action=index" class="search-form search-form_index position-relative {if isset($currentUrl) && $currentUrl === 'index'} d-none {else} {/if}">
            <input type="text" class="search-form__input flex-grow-1" placeholder="Поиск товаров в каталоге">
            <a href="/?controller=category&id=5" obClick="return false;" class="d-block link link_dark button button_border">ПОИСК</a>
            <span class="search-form__close position-absolute {if isset($currentUrl) && $currentUrl === 'index'} {else} d-none {/if}">x</span>
          </form>
          <button type="submit" class="search-form__open link link_dark button {if isset($currentUrl) && $currentUrl === 'index'} {else} d-none {/if}">ПОИСК</button>
        </div>
        <!-- search -->

        <a href="/?controller=cart&action=index" class="header__basket basket d-flex justify-content-end align-items-center order-2 order-md-4 order-lg-5 flex-grow-1 flex-md-grow-0 p-3 p-lg-0">
          <div class="basket__image mr-2 mr-lg-4">
            <img src="assets/img/buy.png" alt="">
          </div>
          <div class="d-flex flex-column">
            <span id="cartCntItems" class="basket__quantity">3 экз.</span>
            <span class="basket__sum">1 150 руб.</span>
          </div>
        </a>
        <!-- basket -->
      </div>
    </header>
    <!-- header -->