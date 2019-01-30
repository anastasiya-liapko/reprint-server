-- MySQL dump 10.13  Distrib 5.7.23, for Linux (x86_64)
--
-- Host: localhost    Database: reprint-market
-- ------------------------------------------------------
-- Server version	5.7.23-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Temporary table structure for view `_order_items`
--

DROP TABLE IF EXISTS `_order_items`;
/*!50001 DROP VIEW IF EXISTS `_order_items`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `_order_items` AS SELECT 
 1 AS `id`,
 1 AS `order_id`,
 1 AS `book_id`,
 1 AS `item_count`,
 1 AS `book_type_id`,
 1 AS `book_cover_id`,
 1 AS `book_format_id`,
 1 AS `name`,
 1 AS `total_price`,
 1 AS `cover_name`,
 1 AS `format_name`,
 1 AS `type_name`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `_orders`
--

DROP TABLE IF EXISTS `_orders`;
/*!50001 DROP VIEW IF EXISTS `_orders`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `_orders` AS SELECT 
 1 AS `id`,
 1 AS `dt`,
 1 AS `status`,
 1 AS `name`,
 1 AS `email`,
 1 AS `phone`,
 1 AS `address`,
 1 AS `comment`,
 1 AS `delivery_type`,
 1 AS `total_price`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `book_covers`
--

DROP TABLE IF EXISTS `book_covers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book_covers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL COMMENT 'книга',
  `cover_id` int(11) NOT NULL COMMENT 'переплет',
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'тип переплета оригинала',
  `price` decimal(10,2) NOT NULL COMMENT 'цена переплета для конкретной книги',
  PRIMARY KEY (`id`),
  UNIQUE KEY `book_covers_book_id` (`book_id`,`cover_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='переплеты для конкретной книги';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_covers`
--

LOCK TABLES `book_covers` WRITE;
/*!40000 ALTER TABLE `book_covers` DISABLE KEYS */;
INSERT INTO `book_covers` VALUES (1,1,1,1,0.00),(2,1,2,0,20.00),(3,1,4,0,30.00),(4,7,2,1,0.00),(5,7,4,0,100.00);
/*!40000 ALTER TABLE `book_covers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book_formats`
--

DROP TABLE IF EXISTS `book_formats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book_formats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL COMMENT 'книга',
  `format_id` int(11) NOT NULL COMMENT 'формат',
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'формат оригинала',
  `price` decimal(10,2) NOT NULL COMMENT 'цена формата для конкретной книги',
  PRIMARY KEY (`id`),
  UNIQUE KEY `book_formats_book_id` (`book_id`,`format_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='форматы для конкретной книги';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_formats`
--

LOCK TABLES `book_formats` WRITE;
/*!40000 ALTER TABLE `book_formats` DISABLE KEYS */;
INSERT INTO `book_formats` VALUES (1,1,3,0,0.00),(2,1,1,1,50.00),(3,1,2,0,20.00),(4,2,3,1,0.00),(5,2,4,0,30.00);
/*!40000 ALTER TABLE `book_formats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book_types`
--

DROP TABLE IF EXISTS `book_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL COMMENT 'книга',
  `type_id` int(11) NOT NULL COMMENT 'тип бумаги',
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'тип бумаги оригинала',
  `price` decimal(10,2) NOT NULL COMMENT 'цена типа для конкретной книги',
  PRIMARY KEY (`id`),
  UNIQUE KEY `book_types_book_id` (`book_id`,`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='типы для конкретной книги';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_types`
--

LOCK TABLES `book_types` WRITE;
/*!40000 ALTER TABLE `book_types` DISABLE KEYS */;
INSERT INTO `book_types` VALUES (1,1,1,0,20.00),(2,1,2,1,0.00),(3,1,3,0,10.00),(4,1,4,0,15.00);
/*!40000 ALTER TABLE `book_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `books` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) NOT NULL,
  `author` varchar(1000) NOT NULL,
  `section_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `dsc` text NOT NULL,
  `extra` text NOT NULL,
  `is_showed` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'отображать книгу',
  `flags` TINYINT(1) NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES (1,'Пламя и кровь. Кровь драконов','Джордж Мартин',1,600.00,'Тирион Ланнистер еще не стал заложником жестокого рока, Бран Старк еще не сделался калекой, а голова его отца Неда Старка еще не','Тирион Ланнистер еще не стал заложником жестокого рока, Бран Старк еще не сделался калекой, а голова его отца Неда Старка еще не скатилась с эшафота. Ни один человек в Королевствах не смеет даже предположить, что Дейенерис Таргариен когда-нибудь назовут Матерью Драконов. Вестерос не привел к покорности соседние государства, и Железный Трон, который, согласно поговорке, ковался в крови и пламени, далеко еще не насытился. Древняя, как сам мир, история сходит со страниц ветхих манускриптов, и только мы, септоны, можем отделить правдивые события от жалких басен, и истину от клеветнических наветов.',1,1),(2,'Метро 2033','Дмитрий Глуховский',1,479.00,'Двадцать лет спустя Третьей мировой войны последние выжившие люди прячутся на станциях и в туннелях московского метро, самого большого н','Двадцать лет спустя Третьей мировой войны последние выжившие люди прячутся на станциях и в туннелях московского метро, самого большого на Земле противоатомного бомбоубежища. Поверхность планеты заражена и непригодна для обитания, и станции метро становятся последним пристанищем для человека. Они превращаются в независимые города-государства, которые соперничают и воюют друг с другом. Они не готовы примириться даже перед лицом новой страшной опасности, которая угрожает всем людям окончательным истреблением. Артем, двадцатилетний парень со станции ВДНХ, должен пройти через все метро, чтобы спасти свой единственный дом - и все человечество. \"Метро 2033\" - культовый роман-антиутопия, один из главных российских бестселлеров нулевых. Переведен на 37 иностранных языков, заинтересовал Голливуд, превращен в атмосферные компьютерные блокбастеры, породил целую книжную вселенную и настоящую молодежную субкультуру во всем мире.',1,0),(3,'Пикник на обочине','Аркадий Стругацкий, Борис Стругацкий ',1,149.00,'Пожалуй, в истории современной мировой фантастики найдется не так много произведений, которые оставались бы популярными столь долг','Пожалуй, в истории современной мировой фантастики найдется не так много произведений, которые оставались бы популярными столь долгое время. Повесть послужила основой культового фильма Тарковского \"Сталкер\"; через три десятилетия появились не менее культовая компьютерная игра с тем же названием и целая серия повестей и романов, написанных с использованием мира \"Пикника\".',1,0),(4,'Трудно быть богом','Аркадий Стругацкий, Борис Стругацкий ',1,129.00,'Возможно, самое известное из произведений братьев Стругацких. Один из самых прославленных романов отечественной фантастики. Ув','Возможно, самое известное из произведений братьев Стругацких. Один из самых прославленных романов отечественной фантастики.',1,0),(5,'Гарри Поттер. Рождение легенды','Брайан Сибли',1,2369.00,'Окунись в яркий мир \"Гарри Поттера\", и ты узнаешь, почему не тают ледяные скульптуры на Святочном балу, где чеканят галеоны, сикли и ','Окунись в яркий мир \"Гарри Поттера\", и ты узнаешь, почему не тают ледяные скульптуры на Святочном балу, где чеканят галеоны, сикли и кнаты, как заставить гиппогрифа работать вместе с артистами, чья творческая фантазия создала замок Хогвартс и почему дементоры двигаются именно так, а не иначе... Текст и дизайн книги созданы в сотрудничестве с творческой группой и актерами, которые перенесли прославленные романы Дж.К.Ролинг на большой экран. Это уникальное издание переместит тебя в волшебный мир, поделится секретами кинопроизводства, ранее неопубликованными фотографиями и рисунками, а также эксклюзивными рассказами звезд. Тебе удастся пройтись по декорациям и макетам со съемок фильмов, заглянуть в костюмерную, гримерку и даже в святая святых - мастерскую, где создаются удивительные персонажи фильмов про Гарри Поттера...',1,0),(6,'Избранное','Айзек Азимов',1,699.00,'В сборник классика американской и мировой фантастики Айзека Азимова включены рассказы из сборника \"Путь марсиан\" (50-е - 60-е гг.) и ','В сборник классика американской и мировой фантастики Айзека Азимова включены рассказы из сборника \"Путь марсиан\" (50-е - 60-е гг.) и роман \"Сами боги\", написанный писателем в начале 70-х гг., после 15-летнего перерыва в литературном творчестве.',1,0),(7,'Королева звезд','Андрэ Нортон',1,180.00,'Колдовской мир.','',1,1),(8,'Марсианка Подкейн. Гражданин Галактики','Роберт Энсон Хайнлайн',1,312.00,'В романе, открывающем этот том классика мировой фантастики, рассказана история Подкейн Фрайз, гражданина Марсианской Республи','В романе, открывающем этот том классика мировой фантастики, рассказана история Подкейн Фрайз, гражданина Марсианской Республики, девочки, отправившейся со своим братом Кларком и дядей Томом в путешествие на Землю транзитом через Венеру - путешествие вполне предсказуемое, но завершившееся с непредсказуемым результатом. Второй роман (\"Гражданин Галактики\") повествует о жизни Торби, земного мальчика, в раннем детстве похищенного космическими работорговцами, но сбросившего невольничьи оковы и проложившего себе дорогу к звездам. И тот, и другой роман публикуются в новой редакции.',1,1),(9,'Кукловоды. Дверь в Лето','Роберт Энсон Хайнлайн',1,314.00,'Впервые на русском — полная авторская версия классического романа «Кукловоды», опубликованная в несокращенном виде уже только по','Впервые на русском — полная авторская версия классического романа «Кукловоды», опубликованная в несокращенном виде уже только после смерти Хайнлайна. Итак, в секретную службу, подчиняющуюся непосредственно президенту США и известную лишь как «Отдел», поступает сообщение о том, что в штате Айова приземлилась летающая тарелка. Это — начало вторжения; вторжения инопланетных паразитов, подчиняющих себе волю человека и быстро захватывающих огромные территории. Удастся ли остановить их иначе, чем ядерными бомбами, и не уничтожить при этом половину собственного населения? Также в книгу входит другой классический роман Хайнлайна — «Дверь в Лето». Это история талантливого изобретателя Д. Б. Дэвиса, который пытается вернуть свой бизнес, предательски отнятый бывшим компаньоном и бывшей невестой, и помочь своему коту по имени Петроний Арбитр (для друзей — Пит) отыскать Дверь в Лето. Ведь каждое живое существо на Земле стремится найти Дверь в Лето — где тепло, нет холода, нет войны, ненависти, обиды; где тебя не предаст друг, не обманет невеста. Для этого Дэвису придется преодолеть само время — и, возможно, не единожды…',1,0),(10,'Сквозь время','Вернор Виндж',1,494.00,'В ядерной войне погибло девяносто процентов населения Земли, но группе ученых из Ливерморской энергетической лаборатории удало','В ядерной войне погибло девяносто процентов населения Земли, но группе ученых из Ливерморской энергетической лаборатории удалось остановить катастрофу,  накрыв все потенциально опасные объекты куполами стасисного поля. Полвека спустя эти люди по-прежнему контролируют мелкие государства и общины, возникшие на месте прежних стран. Якобы ради сохранения мира, а на самом деле ради удержания власти они остановили развитие технологий — и готовы применить к нарушителям запрета  любые средства террора. Прогресс теперь считается злейшим врагом человечества, он загнан в глубокое подполье. Но Мастеровые еще не разгромлены и не пойман самый опасный из них, гениальный математик Пол Нейсмит, за свои  изобретения прозванный Чародеем.',1,0),(11,'Контакт','Карл Эдвард Саган',1,446.00,'\"Контакт\" - научно-фантастический роман, написанный знаменитым астрофизиком и популяризатором науки Карлом Саганом. Сначала это казалось ','\"Контакт\" - научно-фантастический роман, написанный знаменитым астрофизиком и популяризатором науки Карлом Саганом. Сначала это казалось невозможным - радиосигнал, который поступал не с Земли, а из далекого космоса. Но после расшифровки сигнала то, что казалось невозможным, стало устрашающим. В сигнале содержится информация о том, как создать машину, которая может отправиться к звездам; машину, которая может переместить человека сквозь пространство, на самую удивительную встречу в истории человечества. Кто или что там?',1,0),(12,'Левая рука тьмы','Урсула Кребер Ле Гуин',1,380.00,'Этот сборник — еще несколько загадок вселенной Хайнского цикла: закрытая для контактов планета в «Роканноне», захваченная прише','Этот сборник — еще несколько загадок вселенной Хайнского цикла: закрытая для контактов планета в «Роканноне», захваченная пришельцами Земля в «Городе иллюзий», непримиримая вражда колонистов и туземцев в «Планете изгнания», уникальная физиологическая зависимость обитателей планеты Зима от лунного цикла в «Левой руке тьмы». Необычные миры, удивительные народы, сильные и страстные герои, оригинальные фантастические идеи и прекрасный литературный слог. Волнуя умы и завоевывая многочисленные награды, книги Урсулы Ле Гуин мгновенно становились классическими.',1,0),(13,'Лучшее. Том 2. Механическое эго','Генри Каттнер',1,489.00,'В созвездии авторов, составивших Золотой век американской фантастики, Генри Каттнер - одно из самых ярких светил. Его творчеств','В созвездии авторов, составивших Золотой век американской фантастики, Генри Каттнер - одно из самых ярких светил. Его творчество уникально, неповторимо. \"Мы - Хогбены, других таких нет\", - так начинается знаменитый рассказ о Хогбенах и \"прохвессоре\", которого из-за его дурацких вопросов пришлось держать в бутылке на подоконнике. То же самое можно сказать о создателе этого удивительного семейства: \"Он - Каттнер, другого такого нет\". В двухтомник рассказов Каттнера, который мы представляем читателю, вошло лучшее из малой прозы писателя в лучших из существующих переводов - это блестящие переводы Нинель Евдокимовой, ставшие классикой переводческого искусства в жанре фантастики (цикл о Хогбенах, \"Робот-зазнайка\", \"Авессалом\"), это работы Ирины Гуровой, Светланы Васильевой, Владимира Скороденко, Олега Битова, Владимира Баканова, Игоря Почиталина и других не менее замечательных мастеров. Мы делали двухтомник с любовью, чтобы читатели, еще не знающие этого автора, его полюбили. Ну а те, кто знает, любит его давно.',1,0),(14,'Тень Великана. Бегство теней','Орсон Скотт Кард',1,424.00,'В центре повествования романов «Тень Великана» и «Тени в полете», вошедших в настоящий сборник, – судьба одного из главных соратник','В центре повествования романов «Тень Великана» и «Тени в полете», вошедших в настоящий сборник, – судьба одного из главных соратников Эндера в войне с жукерами, Джулиана Дельфики, в Боевой школе получившего прозвище «Боб» за свой маленький рост. Теперь же его зовут Великаном, и не только за рост. Напряженное действие, масштабные события, непростые этические вопросы и глубокие размышления о проблемах, стоящих перед человечеством, – все это вы найдете в эпической саге одного из лучших американских фантастов. Цикл Орсона Скотта Карда об Эндере Виггине, юноше, который изменил будущее человечества, принадлежит к лучшим произведениям писателя. В «фантастических» книжных рейтингах «Игра Эндера», первая книга цикла, неизменно попадает в пятерку лучших за всю историю жанра и даже часто оказываются в лидерах, оставляя позади книги таких гигантов фантастики, как Азимов, Кларк, Брэдбери, и других именитых авторов. Продолжение саги об Эндере – цикл произведений под общим названием «Сага теней» – составляют романы, раскрывающие закулисную историю великой борьбы и победы человечества, позволившей ему вырваться на просторы Вселенной.',1,0),(15,'Бегущий за ветром','Халед Хоссейни',2,416.00,'Ошеломляющий дебютный роман, который уже называют главным романом нового века, а его автора - живым классиком. \"Бегущий за ветром\"','Ошеломляющий дебютный роман, который уже называют главным романом нового века, а его автора - живым классиком. \"Бегущий за ветром\" - проникновенная, пробирающая до самого нутра история о дружбе и верности, о предательстве и искуплении. Нежный, тонкий, ироничный и по-хорошему сентиментальный, роман Халеда Хоссейни напоминает живописное полотно, которое можно разглядывать бесконечно. Амира и Хасана разделяла пропасть. Один принадлежал к местной аристократии, другой - к презираемому меньшинству. У одного отец был красив и важен, у другого - хром и жалок. Один был запойным читателем, другой - неграмотным. Заячью губу Хасана видели все, уродливые же шрамы Амира были скрыты глубоко внутри. Но не найти людей ближе, чем эти два мальчика. Их история разворачивается на фоне кабульской идиллии, которая вскоре сменится грозными бурями. Мальчики - словно два бумажных змея, которые подхватила эта буря и разметала в разные стороны. У каждого своя судьба, своя трагедия, но они, как и в детстве, связаны прочнейшими узами.',1,0);
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `adress` varchar(1000) NOT NULL,
  `phone` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
INSERT INTO `contacts` VALUES (1,'адрес','телефон');
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `covers`
--

DROP TABLE IF EXISTS `covers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `covers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) NOT NULL,
  `orderby` int(11) NOT NULL DEFAULT '0',
  `default_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='переплеты';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `covers`
--

LOCK TABLES `covers` WRITE;
/*!40000 ALTER TABLE `covers` DISABLE KEYS */;
INSERT INTO `covers` VALUES (1,'Листы в подборе (под переплёт)',1,10.00),(2,'Мягкий переплет (КБС)',2,20.00),(3,'Полукожаный переплёт',3,30.00),(4,'Цельнокожаный переплёт',4,40.00);
/*!40000 ALTER TABLE `covers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `flyway_schema_history`
--

DROP TABLE IF EXISTS `flyway_schema_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `flyway_schema_history` (
  `installed_rank` int(11) NOT NULL,
  `version` varchar(50) DEFAULT NULL,
  `description` varchar(200) NOT NULL,
  `type` varchar(20) NOT NULL,
  `script` varchar(1000) NOT NULL,
  `checksum` int(11) DEFAULT NULL,
  `installed_by` varchar(100) NOT NULL,
  `installed_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `execution_time` int(11) NOT NULL,
  `success` tinyint(1) NOT NULL,
  PRIMARY KEY (`installed_rank`),
  KEY `flyway_schema_history_s_idx` (`success`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flyway_schema_history`
--

LOCK TABLES `flyway_schema_history` WRITE;
/*!40000 ALTER TABLE `flyway_schema_history` DISABLE KEYS */;
INSERT INTO `flyway_schema_history` VALUES (1,'1.0','baseline','SQL','V1_0__baseline.sql',-935763312,'reprint-market','2019-01-25 08:22:07',1630,1),(2,'1.1548397846','example books data','SQL','V1_1548397846__example_books_data.sql',608249973,'reprint-market','2019-01-25 08:22:08',121,1);
/*!40000 ALTER TABLE `flyway_schema_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formats`
--

DROP TABLE IF EXISTS `formats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) NOT NULL,
  `orderby` int(11) NOT NULL DEFAULT '0',
  `default_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='форматы';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formats`
--

LOCK TABLES `formats` WRITE;
/*!40000 ALTER TABLE `formats` DISABLE KEYS */;
INSERT INTO `formats` VALUES (1,'Оригинал',1,0.00),(2,'17х24',2,0.00),(3,'А4',3,0.00);
/*!40000 ALTER TABLE `formats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `img` varchar(1000) NOT NULL COMMENT 'путь к картинке',
  `orderby` int(11) NOT NULL DEFAULT '0',
  `is_cover` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'переплет',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (1,6,'/uploads/1000259845.jpg',0,1),(2,3,'/uploads/1012209299.jpg',0,1),(3,4,'/uploads/1013198371.jpg',0,1),(4,12,'/uploads/1014301851.jpg',0,1),(5,13,'/uploads/1015344105.jpg',0,1),(6,11,'/uploads/1021174232.jpg',0,1),(7,10,'/uploads/1021611245.jpg',0,1),(8,9,'/uploads/1021611248.jpg',0,1),(9,8,'/uploads/1023209450.jpg',0,1),(10,1,'/uploads/1025127558.jpg',0,1),(11,1,'/uploads/1025127564.jpg',0,0);
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT 'заказ',
  `book_id` int(11) NOT NULL COMMENT 'книга',
  `item_count` int(11) NOT NULL COMMENT 'количество книг с этим набором параметров',
  `book_type_id` int(11) NOT NULL COMMENT 'тип бумаги, связь с book_types',
  `book_cover_id` int(11) NOT NULL COMMENT 'тип перплета, связь с book_covers',
  `book_format_id` int(11) NOT NULL COMMENT 'формат, связь с book_formats',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_items_order_id` (`order_id`,`book_id`,`book_type_id`,`book_cover_id`,`book_format_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='предметы в заказе   уникальный ключ, чтоб нельзя было в одном заказе создать две записи о книгах, с одинаковым набором параметров';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (3,4,1,1,2,1,1),(4,5,1,1,2,1,1);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dt` timestamp NULL DEFAULT NULL COMMENT 'дата заказа',
  `status` enum('new','allow','decline','shipped','finished') NOT NULL COMMENT 'статус (новый,принят в работу,отклонен,отправлен,завершен)',
  `name` varchar(100) NOT NULL COMMENT 'имя получателя',
  `email` varchar(100) DEFAULT NULL COMMENT 'email',
  `phone` varchar(100) DEFAULT NULL COMMENT 'телефон',
  `address` varchar(1000) NOT NULL COMMENT 'адрес',
  `comment` varchar(1000) DEFAULT NULL COMMENT 'комментарий пользователя',
  `delivery_type` enum('courier','post','pickup') NOT NULL COMMENT 'способ доставки (курьер, почта,самовывоз)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='заказ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'2019-01-25 06:01:47','new','Вася','test@aqua.com','+72345234523','Ленина 20','','courier'),(2,'2019-01-25 08:01:35','new','Вася','test@aqua.com','+72345234523','Ленина 20','','courier'),(3,'2019-01-25 10:36:51','new','Вася','test@aqua.com','+75464565464','Ленина 20','','courier'),(4,'2019-01-25 10:40:50','new','Вася','test@aqua.com','+75464565464','Ленина 20','','courier'),(5,'2019-01-28 12:02:56','new','1','1@g.com','+71111111111','1','1','courier');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sections`
--

DROP TABLE IF EXISTS `sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sections`
--

LOCK TABLES `sections` WRITE;
/*!40000 ALTER TABLE `sections` DISABLE KEYS */;
INSERT INTO `sections` VALUES (1,'Фантастика и фэнтези'),(2,'Любовный роман');
/*!40000 ALTER TABLE `sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `img` varchar(1000) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `dsc` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `types`
--

DROP TABLE IF EXISTS `types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) NOT NULL,
  `orderby` int(11) NOT NULL DEFAULT '0',
  `default_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='типы бумаги';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `types`
--

LOCK TABLES `types` WRITE;
/*!40000 ALTER TABLE `types` DISABLE KEYS */;
INSERT INTO `types` VALUES (1,'Белая 80 г/м ',1,50.00),(2,'Слоновая кость 80 г/м ',2,60.00),(3,'Белая 160 г/м ',3,70.00),(4,'Слоновая кость 120 г/м ',4,80.00),(5,'Слоновая кость 160 г/м ',5,90.00),(6,'Верже',6,100.00);
/*!40000 ALTER TABLE `types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `_order_items`
--

/*!50001 DROP VIEW IF EXISTS `_order_items`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 */
/*!50001 VIEW `_order_items` AS select `oi`.`id` AS `id`,`oi`.`order_id` AS `order_id`,`oi`.`book_id` AS `book_id`,`oi`.`item_count` AS `item_count`,`oi`.`book_type_id` AS `book_type_id`,`oi`.`book_cover_id` AS `book_cover_id`,`oi`.`book_format_id` AS `book_format_id`,`b`.`name` AS `name`,((((`b`.`price` + ifnull(`bc`.`price`,0)) + ifnull(`bf`.`price`,0)) + ifnull(`bt`.`price`,0)) * `oi`.`item_count`) AS `total_price`,`c`.`name` AS `cover_name`,`f`.`name` AS `format_name`,`t`.`name` AS `type_name` from (((((((`order_items` `oi` join `books` `b` on((`b`.`id` = `oi`.`book_id`))) left join `book_covers` `bc` on((`bc`.`id` = `oi`.`book_cover_id`))) left join `covers` `c` on((`c`.`id` = `bc`.`cover_id`))) left join `book_formats` `bf` on((`bf`.`id` = `oi`.`book_format_id`))) left join `formats` `f` on((`f`.`id` = `bf`.`format_id`))) left join `book_types` `bt` on((`bt`.`id` = `oi`.`book_type_id`))) left join `types` `t` on((`t`.`id` = `bt`.`type_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `_orders`
--

/*!50001 DROP VIEW IF EXISTS `_orders`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 */
/*!50001 VIEW `_orders` AS select `o`.`id` AS `id`,`o`.`dt` AS `dt`,`o`.`status` AS `status`,`o`.`name` AS `name`,`o`.`email` AS `email`,`o`.`phone` AS `phone`,`o`.`address` AS `address`,`o`.`comment` AS `comment`,`o`.`delivery_type` AS `delivery_type`,(select sum(`_order_items`.`total_price`) from `_order_items` where (`_order_items`.`order_id` = `o`.`id`)) AS `total_price` from `orders` `o` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-01-29 21:05:09
