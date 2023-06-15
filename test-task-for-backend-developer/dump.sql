-- Adminer 4.8.1 MySQL 5.5.5-10.11.3-MariaDB-1:10.11.3+maria~ubu2204 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `profit_category`;
CREATE TABLE `profit_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `profit_category` (`id`, `name`) VALUES
(1,	'Аренда'),
(2,	'Возврат'),
(3,	'Зарплата'),
(4,	'Транспорт'),
(6,	'Маркетинг'),
(8,	'Закупка'),
(9,	'Налоги'),
(10,	'Налоги на сотрудников'),
(11,	'Страховки'),
(12,	'Программное обеспечение'),
(13,	'Командировки'),
(14,	'Платежи из касс'),
(15,	'Списание (Из Эрпли)'),
(16,	'Прочее'),
(17,	'Прочие расходы'),
(18,	'Связь');

DROP TABLE IF EXISTS `profit_category_map`;
CREATE TABLE `profit_category_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipient` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `options` longtext DEFAULT NULL COMMENT '(DC2Type:json)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `profit_category_map` (`id`, `recipient`, `category_id`, `options`) VALUES
(80,	'FACEBK',	6,	NULL),
(86,	'aliexpress',	8,	NULL),
(94,	'GOOGLE*ADS',	6,	NULL),
(97,	'ZONE MEDIA OÜ',	12,	NULL),
(99,	'BITRIX, INC.',	12,	NULL),
(101,	'Montonio Finance UAB',	12,	NULL),
(102,	'NEXMO LTD.',	12,	NULL),
(104,	'alibaba.com',	8,	NULL),
(106,	'TELE2 EESTI AS',	18,	NULL),
(107,	'GOOGLE ADS',	6,	NULL);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) NOT NULL,
  `roles` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `code` varchar(180) NOT NULL,
  `position` varchar(180) NOT NULL,
  `name` varchar(180) NOT NULL,
  `lastname` varchar(180) NOT NULL,
  `personal_code` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(180) DEFAULT NULL,
  `birthday` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_code` (`code`),
  UNIQUE KEY `unique_user_username` (`username`),
  UNIQUE KEY `unique_user_personalCode` (`personal_code`),
  UNIQUE KEY `unique_user_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `code`, `position`, `name`, `lastname`, `personal_code`, `phone`, `email`, `birthday`) VALUES
(24,	'owner',	'[\"ROLE_OWNER\"]',	'$argon2id$v=19$m=65536,t=4,p=1$dDFWd2VLcmlnaENWUjd0Vw$OcCWqApRow/NxQSGaP2DxeG4rblVerKIThO4nx9aXvA',	'tg',	'Omanik',	'IT Solutions',	'owner',	'12345678900',	'123456',	'info@itsolutions.ee',	'1980-01-01');

-- 2023-06-15 15:40:03
