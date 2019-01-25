-- created by Babylon

-- --------------------------------

-- V1_0__baseline


SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';


DROP TABLE IF EXISTS `sections`;
CREATE TABLE `sections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(1000) NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `books`;
CREATE TABLE `books` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(1000) NOT NULL,
  `author` varchar(1000) NOT NULL,
  `section_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `dsc` text NOT NULL,
  `extra` text NOT NULL,
  `is_showed` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'отображать книгу'
)ENGINE=INNODB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `book_id` int(11) NOT NULL,
  `img` varchar(1000) NOT NULL COMMENT 'путь к картинке',
  `orderby` int(11) NOT NULL DEFAULT '0',
  `is_cover` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'переплет'
)ENGINE=INNODB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `types`;
CREATE TABLE `types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(1000) NOT NULL,
  `orderby` int(11) NOT NULL DEFAULT '0',
  `default_price` decimal(10,2) NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT 'типы бумаги';


DROP TABLE IF EXISTS `covers`;
CREATE TABLE `covers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(1000) NOT NULL,
  `orderby` int(11) NOT NULL DEFAULT '0',
  `default_price` decimal(10,2) NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT 'переплеты';


DROP TABLE IF EXISTS `formats`;
CREATE TABLE `formats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(1000) NOT NULL,
  `orderby` int(11) NOT NULL DEFAULT '0',
  `default_price` decimal(10,2) NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT 'форматы';


DROP TABLE IF EXISTS `book_types`;
CREATE TABLE `book_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `book_id` int(11) NOT NULL COMMENT 'книга',
  `type_id` int(11) NOT NULL COMMENT 'тип бумаги',
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'тип бумаги оригинала',
  `price` decimal(10,2) NOT NULL COMMENT 'цена типа для конкретной книги'
)ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT 'типы для конкретной книги';


DROP TABLE IF EXISTS `book_covers`;
CREATE TABLE `book_covers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `book_id` int(11) NOT NULL COMMENT 'книга',
  `cover_id` int(11) NOT NULL COMMENT 'переплет',
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'тип переплета оригинала',
  `price` decimal(10,2) NOT NULL COMMENT 'цена переплета для конкретной книги'
)ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT 'переплеты для конкретной книги';


DROP TABLE IF EXISTS `book_formats`;
CREATE TABLE `book_formats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `book_id` int(11) NOT NULL COMMENT 'книга',
  `format_id` int(11) NOT NULL COMMENT 'формат',
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'формат оригинала',
  `price` decimal(10,2) NOT NULL COMMENT 'цена формата для конкретной книги'
)ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT 'форматы для конкретной книги';


DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `dt` timestamp NULL DEFAULT NULL COMMENT 'дата заказа',
  `status` enum('new','allow','decline','shipped','finished') NOT NULL COMMENT 'статус (новый,принят в работу,отклонен,отправлен,завершен)',
  `name` varchar(100) NOT NULL COMMENT 'имя получателя',
  `email` varchar(100) NULL COMMENT 'email',
  `phone` varchar(100) NULL COMMENT 'телефон',
  `address` varchar(1000) NOT NULL COMMENT 'адрес',
  `comment` varchar(1000) NULL COMMENT 'комментарий пользователя',
  `delivery_type` enum('courier','post','pickup') NOT NULL COMMENT 'способ доставки (курьер, почта,самовывоз)'
)ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT 'заказ';


DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `order_id` int(11) NOT NULL COMMENT 'заказ',
  `book_id` int(11) NOT NULL COMMENT 'книга',
  `item_count` int(11) NOT NULL COMMENT 'количество книг с этим набором параметров',
  `book_type_id` int(11) NOT NULL COMMENT 'тип бумаги, связь с book_types',
  `book_cover_id` int(11) NOT NULL COMMENT 'тип перплета, связь с book_covers',
  `book_format_id` int(11) NOT NULL COMMENT 'формат, связь с book_formats'
)ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT 'предметы в заказе   уникальный ключ, чтоб нельзя было в одном заказе создать две записи о книгах, с одинаковым набором параметров';


DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `img` varchar(1000) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `dsc` text NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `adress` varchar(1000) NOT NULL,
  `phone` varchar(1000) NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8;



ALTER TABLE `book_types` ADD UNIQUE `book_types_book_id` (`book_id`,`type_id`);
ALTER TABLE `book_covers` ADD UNIQUE `book_covers_book_id` (`book_id`,`cover_id`);
ALTER TABLE `book_formats` ADD UNIQUE `book_formats_book_id` (`book_id`,`format_id`);
ALTER TABLE `order_items` ADD UNIQUE `order_items_order_id` (`order_id`,`book_id`,`book_type_id`,`book_cover_id`,`book_format_id`);

INSERT INTO `covers` (`id`, `name`, `orderby`, `default_price`) VALUES
(1,	'Листы в подборе (под переплёт)',	1,	10.00),
(2,	'Мягкий переплет (КБС)',	2,	20.00),
(3,	'Полукожаный переплёт',	3,	30.00),
(4,	'Цельнокожаный переплёт',	4,	40.00);

INSERT INTO `formats` (`id`, `name`, `orderby`, `default_price`) VALUES
(1,	'Оригинал',	1,	0.00),
(2,	'17х24',	2,	0.00),
(3,	'А4',	3,	0.00);

INSERT INTO `types` (`id`, `name`, `orderby`, `default_price`) VALUES
(1,	'Белая 80 г/м ',	1,	50.00),
(2,	'Слоновая кость 80 г/м ',	2,	60.00),
(3,	'Белая 160 г/м ',	3,	70.00),
(4,	'Слоновая кость 120 г/м ',	4,	80.00),
(5,	'Слоновая кость 160 г/м ',	5,	90.00),
(6,	'Верже',	6,	100.00);

INSERT IGNORE INTO `contacts` (`id`, `adress`, `phone`) VALUES (1,	'адрес',	'телефон');

create or replace view _order_items as
select oi.*,b.name,(b.price + ifnull(bc.price,0) + ifnull(bf.price,0) + ifnull(bt.price,0))*item_count total_price,c.name cover_name,f.name format_name,t.name type_name
from order_items oi
join books as b on (b.id=oi.book_id)
left join book_covers as bc on (bc.id=oi.book_cover_id)
left join covers as c on c.id=bc.cover_id
left join book_formats as bf on (bf.id=oi.book_format_id)
left join formats as f on f.id=bf.format_id
left join book_types as bt on (bt.id=oi.book_type_id)
left join types as t on t.id=bt.type_id;

create or replace view _orders as
select o.*,(select sum(total_price) from _order_items where order_id=o.id) total_price
from orders o;

/* Machine God set us free */
