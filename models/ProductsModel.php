<?php

/**
 * Модель для таблицы постов
 */

/**
 * Получаем последние добавленные посты для категории $catId
 * 
 * @param integer $catId ID категории
 * @return array массив постов для категории $catId
 */
function getProductsByCat($catId) 
{
    $catId = intval($catId);

    $books = [];

    $book = [
        'name' => 'Биографии российских генералиссимусов...',
        'author' => 'Н. Бантыш-каменский.',
        'image' => 'assets/img/book.jpg'
    ];

    for ( $i = 0; $i < 100; $i++) {
        $books[] = $book;
    };

    return $books;
}