


/*Table structure for table `ad_items` */

DROP TABLE IF EXISTS `ad_items`;

CREATE TABLE `ad_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subcat_id` smallint(5) unsigned DEFAULT NULL,
  `region_id` tinyint(3) unsigned DEFAULT NULL,
  `city_id` smallint(5) unsigned DEFAULT NULL,
  `user_id` smallint(5) unsigned DEFAULT NULL,
  `title` char(40) DEFAULT NULL,
  `descr` varchar(255) DEFAULT NULL,
  `phone` char(20) DEFAULT NULL,
  `email` char(40) DEFAULT NULL,
  `url` char(30) DEFAULT NULL,
  `skype` char(20) DEFAULT NULL,
  `price` smallint(6) DEFAULT NULL,
  `contact_name` char(40) DEFAULT NULL,
  `added_at` datetime DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `ad_items` */

insert  into `ad_items`(`id`,`subcat_id`,`region_id`,`city_id`,`user_id`,`title`,`descr`,`phone`,`email`,`url`,`skype`,`price`,`contact_name`,`added_at`,`expire_date`) values (1,1,1,2,NULL,'name','оголошення','яке','я','вілредагував','щоб',0,'чи все працює',NULL,'2013-12-03'),(2,1,1,2,0,'а','це','вже','начисто','кагбе','от',0,'чи все працює',NULL,'2013-12-03'),(3,1,1,2,NULL,'name','оголошення','яке','я','вілредагував','щоб',0,'чи все працює',NULL,'2013-12-03'),(4,1,1,2,NULL,'name','оголошення','яке','я','вілредагував','щоб',0,'чи все працює',NULL,'2013-12-03'),(5,1,1,2,NULL,'name','оголошення','яке','я','вілредагував','щоб',0,'чи все працює',NULL,'2013-12-03'),(6,1,1,2,NULL,'name','оголошення','яке','я','вілредагував','щоб',0,'чи все працює',NULL,'2013-12-03'),(8,1,1,1,0,'lklk','lklk','lklk','lklk','lklk','lklk',0,'lklk',NULL,'0000-00-00'),(9,2,1,1,0,'123','шодлнригшн','олдршгртод','ргшщртоб','р гртолдт','гшрлдотдшгншг',0,'дртгшщдртлбогшрот',NULL,'0000-00-00');

/*Table structure for table `admin_mod_groups` */

DROP TABLE IF EXISTS `admin_mod_groups`;

CREATE TABLE `admin_mod_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `order_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `admin_mod_groups` */

insert  into `admin_mod_groups`(`id`,`name`,`order_id`) values (1,'Модулі',1),(2,'Адміністрування',0),(3,'Контент',2);

/*Table structure for table `admin_modules` */

DROP TABLE IF EXISTS `admin_modules`;

CREATE TABLE `admin_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `module_id` varchar(50) DEFAULT NULL,
  `rights` varchar(255) DEFAULT NULL,
  `extra` enum('0','1') DEFAULT '0',
  `order_id` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `NewIndex1` (`module_id`),
  KEY `NewIndex2` (`group`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

/*Data for the table `admin_modules` */

insert  into `admin_modules`(`id`,`group`,`name`,`module_id`,`rights`,`extra`,`order_id`) values (1,1,'Групи модулів','root_groups','','0',1),(2,1,'Модулі','root_modules','','0',2),(3,2,'Групи користувачів','admin_usergroups','','0',1),(4,2,'Користувачі','admin_users','','0',2),(6,3,'Статичні сторінки','content_pages','','1',0),(26,2,'Навігація','admin_navigation','','1',7),(16,2,'Головна сторінка адміністрування','admin_main','','0',0),(21,2,'Мій профіль користувача','user_profile','','0',0),(53,3,'Категорії','categories',NULL,'1',2),(54,3,'Підкатегорії','subcat',NULL,'1',3),(55,3,'Регіони','regions',NULL,'1',4),(56,3,'Міста','cities',NULL,'1',5);

/*Table structure for table `blog_items` */

DROP TABLE IF EXISTS `blog_items`;

CREATE TABLE `blog_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` char(30) DEFAULT NULL,
  `title` char(40) DEFAULT NULL,
  `descr` varchar(255) DEFAULT NULL,
  `text` text,
  `blog_id` smallint(6) DEFAULT NULL,
  `added_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `blog_items` */

/*Table structure for table `blogs` */

DROP TABLE IF EXISTS `blogs`;

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(40) DEFAULT NULL,
  `alias` char(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `blogs` */

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name_ukr` char(40) DEFAULT NULL,
  `name_rus` char(40) DEFAULT NULL,
  `title_ukr` char(40) DEFAULT NULL,
  `title_rus` char(40) DEFAULT NULL,
  `meta_desc_ukr` varchar(255) DEFAULT NULL,
  `meta_desc_rus` varchar(255) DEFAULT NULL,
  `keywords_ukr` varchar(200) DEFAULT NULL,
  `keywords_rus` varchar(200) DEFAULT NULL,
  `seotext_ukr` text,
  `seotext_rus` text,
  `file` char(20) DEFAULT NULL,
  `alias` char(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `categories` */

insert  into `categories`(`id`,`name_ukr`,`name_rus`,`title_ukr`,`title_rus`,`meta_desc_ukr`,`meta_desc_rus`,`keywords_ukr`,`keywords_rus`,`seotext_ukr`,`seotext_rus`,`file`,`alias`) values (1,'Категорія 1','Категория 1','Пробна','Пробная','','','','','','',NULL,'category'),(3,'Категорія 2','Категория 2','','','','','','','','',NULL,'cat');

/*Table structure for table `cities` */

DROP TABLE IF EXISTS `cities`;

CREATE TABLE `cities` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `reg_id` tinyint(3) unsigned DEFAULT NULL,
  `name_ukr` char(40) DEFAULT NULL,
  `name_rus` char(40) DEFAULT NULL,
  `title_ukr` char(40) DEFAULT NULL,
  `title_rus` char(40) DEFAULT NULL,
  `descr_ukr` varchar(255) DEFAULT NULL,
  `descr_rus` varchar(255) DEFAULT NULL,
  `keywords_ukr` varchar(255) DEFAULT NULL,
  `keywords_rus` varchar(255) DEFAULT NULL,
  `alias` char(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `cities` */

insert  into `cities`(`id`,`reg_id`,`name_ukr`,`name_rus`,`title_ukr`,`title_rus`,`descr_ukr`,`descr_rus`,`keywords_ukr`,`keywords_rus`,`alias`) values (1,1,'Місто 1','Город 1','','','','','','',''),(2,1,'Місто 2','Город 2','','','','','','','');

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(5) unsigned NOT NULL,
  `parent_type` enum('video','photo','audio','scenario','article','news') DEFAULT NULL,
  `added` datetime DEFAULT NULL,
  `name` char(150) DEFAULT '',
  `comment` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

/*Data for the table `comments` */

insert  into `comments`(`id`,`parent_id`,`parent_type`,`added`,`name`,`comment`) values (20,1,'video','2011-05-29 12:08:18','Ярослав','Комент\r\nна\r\nдекілька\r\nрядків'),(19,1,'video','2011-05-29 12:01:21','Ярослав','Тестовий комент'),(5,1,'video','2011-05-28 17:58:37','Test','Test comment'),(6,1,'video','2011-05-28 17:59:31','asdfasdf','asdfasdfasdf'),(7,1,'video','2011-05-28 18:00:20','asdfasdf','asdfasdfasdf'),(8,1,'video','2011-05-28 18:00:22','asdfasdf','asdfasdfasdf'),(9,1,'video','2011-05-28 18:01:24','asdfasdf','asdfasdfasdf'),(10,1,'video','2011-05-28 18:01:43','asdfasdf','asdfasdfasdf'),(11,1,'video','2011-05-28 18:01:59','asdfasdf','asdfasdfasdf'),(12,1,'video','2011-05-28 18:02:02','asdfasdf','asdfasdfasdf'),(13,1,'video','2011-05-28 21:26:05','asdfasdf','asdfasdfasdf'),(14,1,'video','2011-05-28 21:26:36','asdfasdf','asdfasdfasdf'),(15,1,'video','2011-05-29 10:54:55','asdfasdf','asdfasdfasdf'),(16,1,'video','2011-05-29 10:55:15','asdfasdf','asdfasdfasdf'),(17,1,'video','2011-05-29 10:56:49','asdfasdf','asdfasdfasdf'),(18,1,'video','2011-05-29 10:58:02','asdfasdf','asdfasdfasdf'),(21,1,'video','2011-05-29 12:34:22','sdfgsdfg','sdfgsdfg'),(22,1,'video','2011-05-29 12:34:34','dghdf','ertwert'),(23,1,'photo','2011-05-29 12:48:29','Вуйко','Коментар до фото'),(24,1,'scenario','2011-05-29 12:49:03','Пан інкогніто','Коментар до сценарію\r\nФайний сценарій :)'),(25,3,'article','2011-05-29 12:49:46','Хтось','Коментар до статті №2'),(26,1,'article','2011-05-29 12:50:02','Хтось','Коментар до статті №1');

/*Table structure for table `content_pages` */

DROP TABLE IF EXISTS `content_pages`;

CREATE TABLE `content_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p_id` varchar(255) DEFAULT NULL,
  `name_ukr` varchar(255) DEFAULT NULL,
  `name_rus` varchar(255) DEFAULT NULL,
  `text_ukr` text,
  `text_rus` text,
  `image` varchar(255) DEFAULT NULL,
  `title_ukr` varchar(255) DEFAULT NULL,
  `title_rus` varchar(255) DEFAULT NULL,
  `keywords_ukr` tinytext,
  `keywords_rus` tinytext,
  `descr_ukr` tinytext,
  `descr_rus` tinytext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `NewIndex1` (`p_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `content_pages` */

/*Table structure for table `navigation` */

DROP TABLE IF EXISTS `navigation`;

CREATE TABLE `navigation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_ukr` varchar(255) DEFAULT NULL,
  `name_rus` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `order_id` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

/*Data for the table `navigation` */

/*Table structure for table `regions` */

DROP TABLE IF EXISTS `regions`;

CREATE TABLE `regions` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name_ukr` char(40) DEFAULT NULL,
  `name_rus` char(40) DEFAULT NULL,
  `title_ukr` char(40) DEFAULT NULL,
  `title_rus` char(40) DEFAULT NULL,
  `descr_ukr` varchar(255) DEFAULT NULL,
  `descr_rus` varchar(255) DEFAULT NULL,
  `keywords_ukr` varchar(255) DEFAULT NULL,
  `keywords_rus` varchar(255) DEFAULT NULL,
  `alias` char(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `regions` */

insert  into `regions`(`id`,`name_ukr`,`name_rus`,`title_ukr`,`title_rus`,`descr_ukr`,`descr_rus`,`keywords_ukr`,`keywords_rus`,`alias`) values (1,'Регіон 1','Регион 1','','','','','','',''),(2,'Регіон 2','Регион 2','','','','','','','');

/*Table structure for table `subcat` */

DROP TABLE IF EXISTS `subcat`;

CREATE TABLE `subcat` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` tinyint(3) unsigned NOT NULL,
  `name_ukr` char(40) DEFAULT NULL,
  `name_rus` char(40) DEFAULT NULL,
  `title_ukr` char(40) DEFAULT NULL,
  `title_rus` char(40) DEFAULT NULL,
  `meta_desc_ukr` varchar(255) DEFAULT NULL,
  `meta_desc_rus` varchar(255) DEFAULT NULL,
  `keywords_ukr` varchar(200) DEFAULT NULL,
  `keywords_rus` varchar(200) DEFAULT NULL,
  `seotext_ukr` text,
  `seotext_rus` text,
  `file` varchar(255) DEFAULT NULL,
  `alias` char(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `NewIndex1` (`alias`),
  KEY `cat_id` (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `subcat` */

insert  into `subcat`(`id`,`cat_id`,`name_ukr`,`name_rus`,`title_ukr`,`title_rus`,`meta_desc_ukr`,`meta_desc_rus`,`keywords_ukr`,`keywords_rus`,`seotext_ukr`,`seotext_rus`,`file`,`alias`) values (1,1,'Підкатегорія 1','Подкатегория 1','','','','','','','','',NULL,'sub1'),(2,1,'Підкатегорія 2','Пробная 2','Пробна 2','Пробная 2','','','','','','',NULL,'sub2'),(3,3,'Підкатегорія 3','Подкатегория 3','','','','','','','','',NULL,'sub3'),(4,3,'Підкатегорія 4','Подкатегория 4','','','','','','','','',NULL,'sub4');

/*Table structure for table `tag_items` */

DROP TABLE IF EXISTS `tag_items`;

CREATE TABLE `tag_items` (
  `item_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `tag_items` */

/*Table structure for table `tags` */

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `name` char(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `tags` */

/*Table structure for table `user_groups` */

DROP TABLE IF EXISTS `user_groups`;

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '',
  `code` varchar(20) DEFAULT NULL,
  `is_admin` tinyint(4) DEFAULT '0',
  `admin_rights` tinytext,
  `site_rights` varchar(255) DEFAULT '',
  `order_id` int(11) DEFAULT '0',
  `affiliate` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `user_groups` */

insert  into `user_groups`(`id`,`name`,`code`,`is_admin`,`admin_rights`,`site_rights`,`order_id`,`affiliate`) values (1,'Суперюзер','root',1,'a:1:{s:4:\"edit\";a:11:{i:21;s:1:\"1\";i:16;s:1:\"1\";i:3;s:1:\"1\";i:4;s:1:\"1\";i:26;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:6;s:1:\"1\";i:53;s:1:\"1\";i:54;s:1:\"1\";i:55;s:1:\"1\";}}','',0,0),(2,'Адміністратор сайту','admin',1,'a:1:{s:4:\"edit\";a:5:{i:21;s:1:\"1\";i:4;s:1:\"1\";i:16;s:1:\"1\";i:26;s:1:\"1\";i:6;s:1:\"1\";}}','',2,0),(8,'Користувач','def_user',0,'','',4,0),(7,'Адміністратор','small_admin',1,'a:1:{s:4:\"edit\";a:5:{i:21;s:1:\"1\";i:4;s:1:\"1\";i:16;s:1:\"1\";i:26;s:1:\"1\";i:6;s:1:\"1\";}}','',3,0);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reg_id` tinyint(4) DEFAULT NULL,
  `city_id` smallint(6) DEFAULT NULL,
  `login` varchar(50) CHARACTER SET utf8 NOT NULL,
  `pass` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `first_name` varchar(100) CHARACTER SET utf8 DEFAULT '',
  `last_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 DEFAULT '',
  `country` varchar(50) CHARACTER SET utf8 DEFAULT '',
  `region` varchar(50) CHARACTER SET utf8 DEFAULT '',
  `city` varchar(50) CHARACTER SET utf8 DEFAULT '',
  `adress` varchar(50) CHARACTER SET utf8 DEFAULT '',
  `phone` varchar(20) CHARACTER SET utf8 DEFAULT '',
  `icq` varchar(20) CHARACTER SET utf8 DEFAULT '',
  `skype` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `register_date` int(11) DEFAULT NULL,
  `last_login` int(11) DEFAULT NULL,
  `last_activity` int(11) DEFAULT NULL,
  `group` int(11) DEFAULT NULL,
  `affiliate` int(11) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '0',
  `photo` varchar(100) CHARACTER SET utf8 DEFAULT '',
  `register_code` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `discount` char(10) CHARACTER SET utf8 DEFAULT '',
  `forget_code` varchar(100) CHARACTER SET utf8 DEFAULT '',
  `blog_id` int(11) DEFAULT NULL,
  `name` char(100) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_id` (`blog_id`),
  KEY `login` (`login`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`reg_id`,`city_id`,`login`,`pass`,`first_name`,`last_name`,`email`,`country`,`region`,`city`,`adress`,`phone`,`icq`,`skype`,`register_date`,`last_login`,`last_activity`,`group`,`affiliate`,`active`,`photo`,`register_code`,`discount`,`forget_code`,`blog_id`,`name`) values (1,NULL,NULL,'test','8ede080499b8bf8a97bc19a12c3da599','Yaroslav','Olexyn','slouko@sc.if.ua','','','','','555-55-55','225778320','slouko08',1283894223,1306182191,1306736274,1,0,1,'P3140026.JPG','','','',NULL,NULL),(18,1,1,'sashko','289ce47deebebcced3781155afe3d3e8','Сашко =)','','alexander.pankiv@mail.ua','','','','','555-55-55','345123567','alexander_pankiv',1302120431,1308749858,1308820143,1,NULL,1,'','','','',NULL,NULL);


