-- Adminer 4.8.1 MySQL 5.5.5-10.7.3-MariaDB-1:10.7.3+maria~focal dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `reu_event` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `reu_event`;

DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
  `id` varchar(256) NOT NULL,
  `creator_id` varchar(256) NOT NULL,
  `title` varchar(120) NOT NULL,
  `description` varchar(300) NOT NULL,
  `date` datetime NOT NULL,
  `address` varchar(255) NOT NULL,
  `lat` float NOT NULL,
  `lon` float NOT NULL,
  `public` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `event` (`id`, `creator_id`, `title`, `description`, `date`, `address`, `lat`, `lon`, `public`, `created_at`, `updated_at`) VALUES
('047aaedc-6519-42f0-af04-892c2fe49b21',	'4f5cf2a0-c9ce-4acf-a5e5-ec7c5bb96c66',	'Anniversaire de Valentin',	'C\'est mon anniversaire',	'2024-06-06 16:00:36',	'Bischwiller 25 Rue Des Cimetières',	48.7721,	7.85158,	1,	'2022-03-28 14:01:28',	'2022-03-28 14:01:28'),
('085934c6-07d9-4bae-b480-a795fbde23a4',	'4c9529e0-1fd0-485f-b69f-37c71e909042',	'Soirée d\'entrée',	'C\'est une soirée pour la rentrée',	'2022-04-14 09:23:46',	'Toulouse 42 Boulevard Lazare Carnot',	43.6043,	1.4502,	1,	'2022-03-30 07:24:32',	'2022-03-30 07:24:32'),
('148be6a7-4204-4f52-8383-c54eaff02287',	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'Soirée poker',	'Soirée poker entre copain avec 100$ a gagné',	'2022-03-31 20:30:00',	'8 Rue Auguste Bichaton Nancy',	48.6752,	6.15602,	1,	'2022-03-30 12:15:46',	'2022-03-30 12:15:46'),
('1b2a06ba-45ae-4f42-a1c5-67da4490cfd6',	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'Fête de Calvin',	'C\'est une fête organisé par Calvin',	'2022-03-08 10:45:00',	'Nancy 8 Rue De La Faïencerie',	48.69,	6.18372,	1,	'2022-03-28 13:40:43',	'2022-03-28 13:40:43'),
('1d1e80db-d4cc-40f0-9fbb-688654673bdd',	'b63eea1c-db4c-4061-861f-b340b01d3bfc',	'Soirée jeux vidéo',	'On fera du COD, du wow etc ...',	'2022-03-30 16:45:00',	'Villers-lès-Nancy 14 Rue du Léomont',	48.6767,	6.15865,	0,	'2022-03-30 11:30:48',	'2022-03-30 11:30:48'),
('3047072b-152b-4442-946b-4b1198fff766',	'4c9529e0-1fd0-485f-b69f-37c71e909042',	'Fête de Lucas',	'C\'est une fête organisé par Lucas',	'2022-05-11 18:15:00',	'Grenoble 61 Boulevard Joseph Vallier',	45.18,	5.7065,	1,	'2022-03-28 13:44:14',	'2022-03-28 13:44:14'),
('5b036b26-465b-4514-b9b4-835f4c8e1643',	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'LAN Call of duty a la maison',	'Soirée entre pote sur MW3',	'2022-04-08 20:30:00',	'8 Rue Auguste Bichaton Nancy',	48.6752,	6.15602,	1,	'2022-03-30 12:27:44',	'2022-03-30 12:27:44'),
('6ea04df3-f17d-457b-80b3-728a281f26ce',	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'Soirée foot entre copain',	'On va regarder un super match !',	'2022-03-31 20:08:00',	'8 Rue Auguste Bichaton Nancy',	48.6752,	6.15602,	1,	'2022-03-30 12:09:26',	'2022-03-30 12:09:26'),
('bb90ae23-71e6-4d2e-a3b1-57afc45eaffe',	'4f5cf2a0-c9ce-4acf-a5e5-ec7c5bb96c66',	'dépassé',	'C\'est encore une fois trop tard',	'2015-03-06 16:01:35',	'Paris 11 Rue du Colisée',	48.8707,	2.30771,	0,	'2022-03-28 14:02:03',	'2022-03-28 14:02:03'),
('cc2a1c09-8ead-4191-9698-d3547d74d9b2',	'b63eea1c-db4c-4061-861f-b340b01d3bfc',	'Soirée lecture',	'Une super soirée lecture entre copain',	'2022-03-30 13:45:00',	'Nancy 14 Allées de la Garenne',	48.6821,	6.18178,	1,	'2022-03-30 11:31:19',	'2022-03-30 11:31:19'),
('e51dbc74-b05d-4d92-b061-c44a3f2609fd',	'4c9529e0-1fd0-485f-b69f-37c71e909042',	'Evénement privé super',	'L\'événement est privé mais il est super',	'2022-03-23 18:45:00',	'Nancy 34 Rue Bassompierre',	48.691,	6.16606,	0,	'2022-03-28 13:48:07',	'2022-03-28 13:48:07'),
('e87f4be5-03b6-476a-b770-68377f00c163',	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'Soirée Karaoké',	'Soirée Karaoké sur les musiques des années 80!',	'2022-04-08 20:30:00',	'8 Rue Auguste Bichaton Nancy',	48.6752,	6.15602,	1,	'2022-03-30 12:30:00',	'2022-03-30 12:30:00');

DROP TABLE IF EXISTS `guest`;
CREATE TABLE `guest` (
  `id` int(11) NOT NULL,
  `event_id` varchar(256) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(256) NOT NULL,
  `event_id` varchar(256) NOT NULL,
  `content` varchar(500) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `message` (`id`, `user_id`, `event_id`, `content`, `date`) VALUES
(16,	'4f5cf2a0-c9ce-4acf-a5e5-ec7c5bb96c66',	'047aaedc-6519-42f0-af04-892c2fe49b21',	'J\'envoie un message',	'2022-03-29 06:47:50'),
(17,	'4f5cf2a0-c9ce-4acf-a5e5-ec7c5bb96c66',	'047aaedc-6519-42f0-af04-892c2fe49b21',	'Je viens !',	'2022-03-29 06:49:02'),
(18,	'4f5cf2a0-c9ce-4acf-a5e5-ec7c5bb96c66',	'3047072b-152b-4442-946b-4b1198fff766',	'Je viens !',	'2022-03-29 06:49:22'),
(20,	'4f5cf2a0-c9ce-4acf-a5e5-ec7c5bb96c66',	'1b2a06ba-45ae-4f42-a1c5-67da4490cfd6',	'J\'envoie un commentaire dans la conv',	'2022-03-29 07:12:22'),
(21,	'4f5cf2a0-c9ce-4acf-a5e5-ec7c5bb96c66',	'1b2a06ba-45ae-4f42-a1c5-67da4490cfd6',	'Un super commentaire',	'2022-03-29 07:16:17'),
(24,	'4f5cf2a0-c9ce-4acf-a5e5-ec7c5bb96c66',	'047aaedc-6519-42f0-af04-892c2fe49b21',	'Salut les mecs je serais la',	'2022-03-29 16:42:54'),
(25,	'4c9529e0-1fd0-485f-b69f-37c71e909042',	'047aaedc-6519-42f0-af04-892c2fe49b21',	'Je viens !',	'2022-03-30 07:23:16'),
(26,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'085934c6-07d9-4bae-b480-a795fbde23a4',	'Je viens !',	'2022-03-30 07:25:18'),
(27,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'085934c6-07d9-4bae-b480-a795fbde23a4',	'test',	'2022-03-30 07:41:58'),
(28,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'085934c6-07d9-4bae-b480-a795fbde23a4',	'Je viens !',	'2022-03-30 08:20:57'),
(29,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'085934c6-07d9-4bae-b480-a795fbde23a4',	'Je viens pas !',	'2022-03-30 08:21:06'),
(30,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'085934c6-07d9-4bae-b480-a795fbde23a4',	'Je viens !',	'2022-03-30 08:30:16'),
(31,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'085934c6-07d9-4bae-b480-a795fbde23a4',	'Je viens !',	'2022-03-30 08:30:19'),
(32,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'085934c6-07d9-4bae-b480-a795fbde23a4',	'Je viens !',	'2022-03-30 08:35:52'),
(33,	'b63eea1c-db4c-4061-861f-b340b01d3bfc',	'047aaedc-6519-42f0-af04-892c2fe49b21',	'Je viens !',	'2022-03-30 09:04:35'),
(34,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'047aaedc-6519-42f0-af04-892c2fe49b21',	'Je viens !',	'2022-03-30 09:05:38'),
(35,	'b63eea1c-db4c-4061-861f-b340b01d3bfc',	'047aaedc-6519-42f0-af04-892c2fe49b21',	'Je viens !',	'2022-03-30 09:16:33'),
(36,	'b63eea1c-db4c-4061-861f-b340b01d3bfc',	'047aaedc-6519-42f0-af04-892c2fe49b21',	'Je viens pas !',	'2022-03-30 09:19:16'),
(37,	'b63eea1c-db4c-4061-861f-b340b01d3bfc',	'047aaedc-6519-42f0-af04-892c2fe49b21',	'Je viens !',	'2022-03-30 09:19:22'),
(66,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'047aaedc-6519-42f0-af04-892c2fe49b21',	'Je viens !',	'2022-03-30 09:39:36'),
(67,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'047aaedc-6519-42f0-af04-892c2fe49b21',	'Je viens !',	'2022-03-30 09:39:37'),
(68,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'047aaedc-6519-42f0-af04-892c2fe49b21',	'Je viens !',	'2022-03-30 09:40:16'),
(83,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'047aaedc-6519-42f0-af04-892c2fe49b21',	'fgh',	'2022-03-30 09:50:57'),
(84,	'4c9529e0-1fd0-485f-b69f-37c71e909042',	'047aaedc-6519-42f0-af04-892c2fe49b21',	'test test',	'2022-03-30 09:51:38'),
(85,	'4c9529e0-1fd0-485f-b69f-37c71e909042',	'047aaedc-6519-42f0-af04-892c2fe49b21',	'Je fais un test pour les dates',	'2022-03-30 09:55:28'),
(86,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'3047072b-152b-4442-946b-4b1198fff766',	'Je viens !',	'2022-03-30 11:28:58'),
(87,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'cc2a1c09-8ead-4191-9698-d3547d74d9b2',	'Je viens !',	'2022-03-30 11:31:39'),
(88,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'cc2a1c09-8ead-4191-9698-d3547d74d9b2',	'Je ne viens pas !',	'2022-03-30 12:03:05'),
(89,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'cc2a1c09-8ead-4191-9698-d3547d74d9b2',	'Je viens !',	'2022-03-30 12:03:40'),
(90,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'cc2a1c09-8ead-4191-9698-d3547d74d9b2',	'Je ne viens pas !',	'2022-03-30 12:03:41'),
(91,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'cc2a1c09-8ead-4191-9698-d3547d74d9b2',	'Je ne viens pas !',	'2022-03-30 12:03:43'),
(92,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'cc2a1c09-8ead-4191-9698-d3547d74d9b2',	'Je viens !',	'2022-03-30 12:03:44'),
(93,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'cc2a1c09-8ead-4191-9698-d3547d74d9b2',	'Je ne viens pas !',	'2022-03-30 12:03:44'),
(94,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'cc2a1c09-8ead-4191-9698-d3547d74d9b2',	'Je viens !',	'2022-03-30 12:03:51'),
(95,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'cc2a1c09-8ead-4191-9698-d3547d74d9b2',	'Salut je serais dispo pour la soirée !',	'2022-03-30 12:08:14'),
(96,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'cc2a1c09-8ead-4191-9698-d3547d74d9b2',	'Je ne viens pas !',	'2022-03-30 12:08:22'),
(97,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'cc2a1c09-8ead-4191-9698-d3547d74d9b2',	'Je viens !',	'2022-03-30 12:08:25'),
(98,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'148be6a7-4204-4f52-8383-c54eaff02287',	'Salut préparé de quoi manger avant de venir !',	'2022-03-30 12:16:13'),
(99,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'085934c6-07d9-4bae-b480-a795fbde23a4',	'Je ne viens pas !',	'2022-03-30 12:16:29'),
(100,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'7a77c7bf-d3bd-4752-a420-c0d0d640b8c6',	'Quelqu\'un peut ramener des manettes ?',	'2022-03-30 12:22:24'),
(101,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'1b2a06ba-45ae-4f42-a1c5-67da4490cfd6',	'Je ne viens pas !',	'2022-03-30 12:22:38'),
(102,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'1b2a06ba-45ae-4f42-a1c5-67da4490cfd6',	'Je viens !',	'2022-03-30 12:22:42'),
(103,	'56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'e87f4be5-03b6-476a-b770-68377f00c163',	'Salut oubliez pas de prendre des micros en plus !',	'2022-03-30 12:30:24'),
(104,	'4c9529e0-1fd0-485f-b69f-37c71e909042',	'e87f4be5-03b6-476a-b770-68377f00c163',	'Je viens !',	'2022-03-30 12:30:56'),
(105,	'4c9529e0-1fd0-485f-b69f-37c71e909042',	'e87f4be5-03b6-476a-b770-68377f00c163',	'Je ne viens pas !',	'2022-03-30 12:31:02');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` varchar(256) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `refresh_token` varchar(128) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `user` (`id`, `firstname`, `lastname`, `mail`, `password`, `level`, `refresh_token`, `created_at`, `updated_at`) VALUES
('26f4af4b-3aca-4b5e-984a-767732d7c6b1',	'touboo',	'Hugo',	'hugotoubo@gmail.com',	'$2y$10$2w0/S2ENvbdb9/BYEn/2ZOESV/ozS.75aCeZTs0uhMKZveL.FAsyG',	0,	'e5c1a8549fb320812e0337e032f72305c8116daf806da957136637995386613d',	'2022-03-30 09:21:17',	'2022-03-30 09:21:32'),
('4c9529e0-1fd0-485f-b69f-37c71e909042',	'Humbert',	'Lucas',	'lucas@gmail.com',	'$2y$10$Zjtnl7LRo8xgVACsy4KlXOBkeIEfTuwTJjp9CQymBxJ0Pbe7cuQhG',	10,	'50424c6b978a44ebc2c6ebcacc93d22ae3c5771f4b3691e5e2e60c483c277853',	'2022-03-28 13:02:51',	'2022-03-30 12:30:50'),
('4f5cf2a0-c9ce-4acf-a5e5-ec7c5bb96c66',	'Budzik',	'Valentin',	'valentin@gmail.com',	'$2y$10$Al5IGxQiYomYFVNdwrnenON28iNsZaKghu6mX7Mx2LlUYUGyl4dyq',	0,	'c972c561e507926edce7099d9b0d1b22ea64d683805095f62c2bca0b5297d967',	'2022-03-28 13:38:33',	'2022-03-29 20:09:32'),
('56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'Lambert',	'Calvin',	'calvin@gmail.com',	'$2y$10$qQpA4eEfAPCtnZggTJmzney7iU3sSPjsuXic3SjanGUjSZBuXKx4q',	0,	'541017a586a7c018aa2d7a324bfe9ec1e4b08efd27c71ac3f5716524e359eef7',	'2022-03-28 13:38:12',	'2022-03-30 12:28:30'),
('b63eea1c-db4c-4061-861f-b340b01d3bfc',	'Houques',	'Baptiste',	'baptiste@gmail.com',	'$2y$10$cCSKz7f71flHwNFgMUPIYOBImA1gpzsrzcXXStFICmO1IViovoBaG',	0,	'43e49ddba94f217cfd1d45c030ce4d82a0b442b1eed1f17ff4c038b741fc36bc',	'2022-03-28 13:39:03',	'2022-03-30 11:30:15');

DROP TABLE IF EXISTS `user_event`;
CREATE TABLE `user_event` (
  `user_id` varchar(256) NOT NULL,
  `event_id` varchar(256) NOT NULL,
  `choice` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_id`,`event_id`) USING BTREE,
  KEY `event_id` (`event_id`),
  CONSTRAINT `user_event_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
  CONSTRAINT `user_event_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `user_event` (`user_id`, `event_id`, `choice`) VALUES
('4c9529e0-1fd0-485f-b69f-37c71e909042',	'047aaedc-6519-42f0-af04-892c2fe49b21',	1),
('4c9529e0-1fd0-485f-b69f-37c71e909042',	'085934c6-07d9-4bae-b480-a795fbde23a4',	1),
('4c9529e0-1fd0-485f-b69f-37c71e909042',	'e87f4be5-03b6-476a-b770-68377f00c163',	0),
('4f5cf2a0-c9ce-4acf-a5e5-ec7c5bb96c66',	'047aaedc-6519-42f0-af04-892c2fe49b21',	1),
('4f5cf2a0-c9ce-4acf-a5e5-ec7c5bb96c66',	'3047072b-152b-4442-946b-4b1198fff766',	1),
('56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'047aaedc-6519-42f0-af04-892c2fe49b21',	1),
('56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'085934c6-07d9-4bae-b480-a795fbde23a4',	0),
('56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'1b2a06ba-45ae-4f42-a1c5-67da4490cfd6',	1),
('56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'3047072b-152b-4442-946b-4b1198fff766',	1),
('56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'5b036b26-465b-4514-b9b4-835f4c8e1643',	1),
('56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'6ea04df3-f17d-457b-80b3-728a281f26ce',	1),
('56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7',	'e87f4be5-03b6-476a-b770-68377f00c163',	1);

-- 2022-03-30 16:24:54
