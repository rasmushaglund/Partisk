-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
<<<<<<< HEAD
-- Host: localhost
-- Generation Time: Nov 19, 2013 at 08:49 PM
-- Server version: 5.5.32-0ubuntu0.13.04.1
-- PHP Version: 5.4.9-4ubuntu2.3
=======
-- Värd: localhost
-- Skapad: 19 nov 2013 kl 00:36
-- Serverversion: 5.6.14
-- PHP-version: 5.3.24
>>>>>>> master

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `partisk`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `party_id` int(11) NOT NULL,
  `answer` varchar(20) CHARACTER SET latin1 NOT NULL,
  `question_id` int(11) NOT NULL,
  `source` text COLLATE utf8_swedish_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `updated_by` int(11) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_date` timestamp NULL DEFAULT NULL,
  `description` text COLLATE utf8_swedish_ci,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `approved_by` int(11) NOT NULL,
  `approved_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=215 ;

--
-- Dumpning av Data i tabell `answers`
--

INSERT INTO `answers` (`id`, `party_id`, `answer`, `question_id`, `source`, `date`, `created_by`, `deleted`, `updated_by`, `created_date`, `updated_date`, `description`, `approved`, `approved_by`, `approved_date`) VALUES
(7, 4, 'ja', 14, 'http://politik.piratpartiet.se/patent-2/', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(8, 4, 'ja', 15, 'http://politik.piratpartiet.se/fra/', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(10, 2, 'nej', 17, 'http://www.moderat.se/eu/euron', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(11, 3, 'ja', 17, 'http://www.folkpartiet.se/var-politik/var-politik-a-o/euro/', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(12, 9, 'nej', 17, 'http://www.mp.se/politik/eu-och-euro', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(13, 4, 'nej', 17, 'http://politik.piratpartiet.se/eu/', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(14, 6, 'nej', 17, 'http://kristdemokraterna.se/VarPolitik/Korta-Svar-AO/Euron/', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(15, 5, 'nej', 17, 'http://www.centerpartiet.se/Centerpolitik/Politikomraden/EU/Politik-A---O/EMU/', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(16, 8, 'nej', 17, 'https://sverigedemokraterna.se/?page_id=11454', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(18, 7, 'nej', 17, 'http://www.vansterpartiet.se/politik/euron-2/', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(19, 7, 'nej', 18, 'http://www.vansterpartiet.se/politik/', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(20, 7, 'ja', 19, 'http://www.vansterpartiet.se/politik/abort/', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(21, 7, 'ja', 20, 'http://www.riksdagen.se/sv/Dokument-Lagar/Forslag/Motioner/Barnfattigdom_H102-8255882D-BC55-440F-914F-8B5C4C20EA21/?text=true', '2013-09-14 22:00:00', 2, 0, 2, '2013-10-21 12:35:49', '2013-10-22 19:47:08', '"Riksdagen beslutar vad som anförs i motionen om att riksnormen för försörjningsstöd bör höjas med 300 kronor i månaden per barn."', 0, 0, '0000-00-00 00:00:00'),
(22, 7, 'ja', 21, 'http://www.vansterpartiet.se/politik/dodshjalp/', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(23, 7, 'nej', 22, 'http://www.vansterpartiet.se/politik/abort/', '2013-09-14 22:00:00', 2, 0, 2, '2013-10-21 12:35:49', '2013-10-22 19:45:40', '"Vänsterpartiet vill även att möjligheten till dispens för barn under 18 år att ingå äktenskap ska tas bort."', 0, 0, '0000-00-00 00:00:00'),
(24, 6, 'ja', 19, 'http://kristdemokraterna.se/VarPolitik/Korta-Svar-AO/Abort/', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(25, 8, 'nej', 23, 'https://sverigedemokraterna.se/?page_id=10893', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(26, 8, 'ja', 24, 'https://sverigedemokraterna.se/?page_id=10893', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(27, 3, 'ja', 19, 'http://www.folkpartiet.se/var-politik/var-politik-a-o/abort/', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(28, 3, 'ja', 25, 'http://www.folkpartiet.se/var-politik/var-politik-a-o/karnkraft/', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(29, 3, 'nej', 26, 'http://www.folkpartiet.se/var-politik/var-politik-a-o/karnkraft/', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(30, 3, 'ja', 27, 'http://www.folkpartiet.se/var-politik/var-politik-a-o/nato/', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(31, 6, 'nej', 28, 'http://kristdemokraterna.se/VarPolitik/Korta-Svar-AO/Gardsforsaljning/', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(32, 6, 'ja', 29, 'http://kristdemokraterna.se/VarPolitik/Korta-Svar-AO/Modersmalsundervisning/', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(33, 5, 'ja', 19, 'http://www.centerpartiet.se/Centerpolitik/Politikomraden/Sociala-fragor-vard-och-omsorg/Politik-A---', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(34, 5, 'ja', 30, 'http://www.centerpartiet.se/Centerpolitik/Politikomraden/Infrastruktur-och-trafik/Politik-A---O/Alko', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(35, 5, 'ja', 31, 'http://www.centerpartiet.se/Centerpolitik/Politikomraden/Sociala-fragor-vard-och-omsorg/Politik-A---', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(36, 5, '6', 32, 'http://www.centerpartiet.se/Centerpolitik/Politikomraden/Skola-och-utbildning/Politik-A---O/Betyg/', '2013-09-14 22:00:00', 2, 0, 2, '2013-10-21 12:35:49', '2013-10-22 20:16:37', '"Centerpartiet har tillsammans med Alliansen [...] infört en ny betygsskala i sex steg och eleverna får nu betyg från år 6"', 0, 0, '0000-00-00 00:00:00'),
(37, 5, 'ja', 21, 'http://www.centerpartiet.se/Centerpolitik/Politikomraden/Sociala-fragor-vard-och-omsorg/Politik-A---', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(38, 1, 'ja', 19, 'http://www.socialdemokraterna.se/Webben-for-alla/S-kvinnor/S-kvinnor/Var-politik/Var-politik-A-O/Abort/', '2013-09-04 22:00:00', 2, 0, 2, '2013-10-21 12:35:49', '2013-10-22 08:24:55', '', 0, 0, '0000-00-00 00:00:00'),
(39, 8, 'ja', 19, 'http://sverigedemokraterna.se/?page_id=10893', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(40, 2, 'ja', 19, 'http://www.moderat.se/debatt/ulrika-karlsson-orovackande-utveckling-i-synen-pa-abort-i-europa', '2012-10-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(41, 1, '6', 32, 'http://www.socialdemokraterna.se/Var-politik/Var-politik-A-till-O/Skola/Betyg/', '2013-05-15 22:00:00', 2, 0, 2, '2013-10-21 12:35:49', '2013-10-22 20:14:20', '"Betyg i grundskolan ska finnas från årskurs 6"', 0, 0, '0000-00-00 00:00:00'),
(42, 2, '6', 32, 'http://www.moderat.se/skola-och-utbildning/grundskolan', '2012-07-11 22:00:00', 2, 0, 2, '2013-10-21 12:35:49', '2013-10-22 20:15:38', '"Dessutom har ett nytt betygssystem införts och från och med hösten 2012 ges betyg från årskurs 6."', 0, 0, '0000-00-00 00:00:00'),
(43, 3, '4', 32, 'http://www.folkpartiet.se/var-politik/var-politik-a-o/betyg/', '2013-09-14 22:00:00', 2, 0, 2, '2013-10-21 12:35:49', '2013-10-22 20:15:59', '"Vi vill [...] Införa betyg från åk 4"', 0, 0, '0000-00-00 00:00:00'),
(44, 6, '6', 32, 'http://kristdemokraterna.se/VarPolitik/Korta-Svar-AO/Betyg/', '2013-07-03 22:00:00', 2, 0, 2, '2013-10-21 12:35:49', '2013-10-22 20:18:06', '"Från höstterminen 2012 infördes betyg från årskurs sex, det tycker vi är bra för att tydliggöra kunskapsmål."', 0, 0, '0000-00-00 00:00:00'),
(45, 7, '9', 32, 'http://www.vansterpartiet.se/politik/betyg-2/', '2013-09-14 22:00:00', 2, 0, 2, '2013-10-21 12:35:49', '2013-10-22 20:16:57', '"Den typ av betyg vi istället vill se är ett intyg och omdöme som en elev får med sig efter att ha avslutat en utbildning och det första betyget ska då ges i årskurs 9."', 0, 0, '0000-00-00 00:00:00'),
(46, 8, '4', 32, 'http://www.riksdagen.se/sv/Dokument-Lagar/Forslag/Motioner/Betyg-fran-arskurs-4_GZ02Ub507/?text=true', '2011-10-02 22:00:00', 2, 0, 2, '2013-10-21 12:35:49', '2013-10-22 20:17:48', '"Vi menar dels att betyg skall införas redan i årskurs 4 i grundskolan [...]"', 0, 0, '0000-00-00 00:00:00'),
(47, 1, 'ja', 30, 'http://www.socialdemokraterna.se/Webben-for-alla/Partidistrikt/Kalmar/MediaN/Nyhetsarkiv/Alkolas-kan', '2009-05-25 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(49, 3, 'nej', 22, 'http://www.folkpartiet.se/var-politik/var-politik-a-o/aktenskap/', '2013-09-14 22:00:00', 2, 0, 2, '2013-10-21 12:35:49', '2013-10-22 19:45:16', '"Dispensmöjligheten att ingå äktenskap före 18 års ålder bör avskaffas."', 0, 0, '0000-00-00 00:00:00'),
(50, 1, 'ja', 29, 'http://www.socialdemokraterna.se/Webben-for-alla/S-kvinnor/S-kvinnor-i-Jonkopings-lan/Var-Politik/A-', '2008-10-04 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(51, 3, 'ja', 29, 'http://www.folkpartiet.se/var-politik/var-politik-a-o/modersmalsundervisning/', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(52, 6, 'ja', 29, 'http://kristdemokraterna.se/VarPolitik/Korta-Svar-AO/Modersmalsundervisning/', '2013-04-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(53, 8, 'nej', 29, 'http://sverigedemokraterna.se/?page_id=10893', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(54, 1, 'ja', 15, 'http://www.socialdemokraterna.se/Webben-for-alla/Partidistrikt/Goteborg/Politik/Var-politik-A-till-O', '2013-10-27 10:36:40', 2, 1, 2, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(55, 2, 'nej', 15, 'http://www.moderat.se/forsvar-och-krisberedskap/signalspaning', '2012-06-26 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(56, 3, 'nej', 15, 'http://www.folkpartiet.se/var-politik/var-politik-a-o/fra-forsvarets-radioanstalt/', '2010-12-16 23:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(57, 5, 'nej', 15, 'http://www.centerpartiet.se/Nyheter/Arkiv-2007/Annie-om-signalspaning/', '2007-02-07 23:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(58, 6, 'nej', 15, 'http://www.overtornea.kristdemokraterna.se/web-Overtornea-content/web-Overtornea-leftmenu/FOV16-0002', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(59, 1, 'nej', 15, 'http://www.dn.se/Pages/Article.aspx?id=1034640&epslanguage=sv', '2013-09-09 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(60, 7, 'ja', 15, 'http://www.vansterpartiet.se/v-och-mp-motsatter-sig-okad-signalspaning/', '2012-11-27 23:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(61, 9, 'ja', 15, 'http://www.mp.se/politik/internet-och-integritet', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(62, 1, 'nej', 28, 'http://www.socialdemokraterna.se/Var-politik/Var-politik-A-till-O/Sociala-fragor/Alkohol/', '2013-06-09 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(63, 2, 'ja', 28, 'http://www.moderat.se/sundsvall/alkohol-och-narkotikafragor', '2013-01-14 23:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(64, 3, 'nej', 28, 'http://www.folkpartiet.se/var-politik/var-politik-a-o/alkohol/', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(65, 5, 'ja', 28, 'http://www.centerpartiet.se/Centerpolitik/Politikomraden/Jobb-och-arbetsliv/Politik-A---O/Gardsforsa', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(66, 8, 'ja', 28, 'https://sverigedemokraterna.se/?p=4043‎', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(67, 9, 'nej', 28, 'http://www.newsmill.se/artikel/2012/03/23/folkh-lsan-m-ste-g-f-re-g-rdsf-rs-ljning', '2012-03-24 23:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(68, 1, 'ja', 26, 'http://www.socialdemokraterna.se/Var-politik/Var-politik-A-till-O/Energi/Karnkraft/', '2013-06-11 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(69, 1, 'nej', 25, 'http://www.socialdemokraterna.se/Var-politik/Var-politik-A-till-O/Energi/Karnkraft/', '2013-06-11 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(70, 2, 'nej', 26, 'http://www.moderat.se/sundsvall/energi', '2013-01-14 23:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(71, 2, 'ja', 25, 'http://www.moderat.se/sundsvall/energi', '2013-01-14 23:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(72, 5, 'ja', 26, 'http://www.centerpartiet.se/Centerpolitik/Politikomraden/Miljo-energi-och-klimat/Politik-A---O/Karnk', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(73, 5, 'nej', 25, 'http://www.centerpartiet.se/Centerpolitik/Politikomraden/Miljo-energi-och-klimat/Politik-A---O/Karnk', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(74, 6, 'nej', 26, 'http://kristdemokraterna.se/VarPolitik/Politikomraden/Miljo-och-energi/', '2012-09-26 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(75, 7, 'ja', 26, 'http://www.vansterpartiet.se/fordjupning/energi-fordjupning/', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(76, 7, 'nej', 25, 'http://www.vansterpartiet.se/fordjupning/energi-fordjupning/', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(77, 9, 'ja', 26, 'http://www.mp.se/politik/karnkraft', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(78, 9, 'nej', 25, 'http://www.mp.se/politik/karnkraft', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(79, 8, 'nej', 26, 'http://sverigedemokraterna.se/?page_id=10893', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(80, 8, 'ja', 25, 'http://sverigedemokraterna.se/?page_id=10893', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(81, 1, 'ja', 31, 'http://www.socialdemokraterna.se/Webben-for-alla/Partidistrikt/Goteborg/Politik/Var-politik-A-till-O', '2010-09-13 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(82, 3, 'ja', 31, 'http://www.folkpartiet.se/var-politik/var-politik-a-o/apoteksmarknaden/', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(83, 5, 'ja', 31, 'http://www.centerpartiet.se/Centerpolitik/Politikomraden/Sociala-fragor-vard-och-omsorg/Politik-A---', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(84, 3, 'nej', 21, 'http://www.folkpartiet.se/var-politik/var-politik-a-o/dodshjalp/', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(85, 5, 'nej', 21, 'http://www.centerpartiet.se/Centerpolitik/Politikomraden/Sociala-fragor-vard-och-omsorg/Politik-A---', '2013-09-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(86, 6, 'nej', 21, 'http://kristdemokraterna.se/VarPolitik/Korta-Svar-AO/Dodshjalp/', '2013-04-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(87, 1, 'nej', 21, 'http://www.svt.se/nyheter/sverige/partier-sager-nej-till-aktiv-dodshjalp', '2010-04-06 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(88, 2, 'nej', 21, 'http://www.svt.se/nyheter/sverige/partier-sager-nej-till-aktiv-dodshjalp', '2010-04-06 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(89, 9, 'nej', 21, 'http://www.svt.se/nyheter/sverige/partier-sager-nej-till-aktiv-dodshjalp', '2010-04-06 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(90, 1, 'nej', 27, 'http://www.socialdemokraterna.se/Internationellt/Arkiv/Gamla-internationella-A-O/NATO/', '2013-09-15 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(91, 2, 'ja', 27, 'http://www.moderat.se/sundsvall/forsvaret', '2013-01-14 23:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(92, 5, 'nej', 27, 'http://www.centerpartiet.se/Centerpolitik/Politikomraden/Forsvars--och-sakerhetspolitik/Politik-A---', '2013-09-15 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(93, 6, 'nej', 27, 'http://www.kristdemokraterna.se/VarPolitik/Korta-Svar-AO/Nato/', '2013-04-14 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(94, 7, 'nej', 27, 'http://www.vansterpartiet.se/politik/forsvaret/', '2013-09-15 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(95, 8, 'nej', 27, 'http://sverigedemokraterna.se/?page_id=10893', '2013-09-15 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(96, 9, 'nej', 27, 'http://www.mp.se/karlskrona/just-nu/ja-till-fred-nej-till-nato', '2013-09-15 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(97, 5, 'nej', 24, 'http://www.centerpartiet.se/Centerpolitik/Politikomraden/Infrastruktur-och-trafik/Politik-A---O/Jarn', '2013-09-15 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(98, 5, 'ja', 23, 'http://www.centerpartiet.se/Centerpolitik/Politikomraden/Utrikes--och-bistandsfragor/Politik-A---O/E', '2013-09-15 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(99, 3, 'ja', 23, 'http://www.folkpartiet.se/vara-politiker/cecilia-malmstrom/nar-jag-var-eu-minister/artiklar/turkiet-', '2004-10-17 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(100, 2, 'ja', 18, 'http://www.moderat.se/debatt/vinstforbud-vore-ett-misstag', '2012-08-06 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(101, 7, 'nej', 18, 'http://www.dn.se/nyheter/sverige/v-kraver-stopp-for-vinster-i-valfarden/', '2013-08-17 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(102, 9, 'nej', 18, 'http://www.mp.se/haninge/just-nu/forbud-mot-vinster-i-valfarden-beslutad-pa-kongressen', '2013-09-15 22:00:00', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(124, 1, 'ja', 14, 'http://www.folkpartiet.se/var-politik/var-politik-a-o/abort/', '2013-10-20 13:24:38', 2, 0, NULL, '2013-10-21 12:35:49', NULL, NULL, 0, 0, '0000-00-00 00:00:00'),
(130, 3, 'ja', 68, 'http://www.folkpartiet.se/var-politik/var-politik-a-o/arbetsloshetsforsakring/', '2013-10-22 10:19:01', 2, 0, NULL, '2013-10-22 10:19:01', NULL, '"Att dagens a-kassor ska ersättas med en gemensam arbetslöshetskassa i statlig regi som omfattar alla som arbetar."', 0, 0, '0000-00-00 00:00:00'),
(131, 6, 'ja', 68, 'http://www.kristdemokraterna.se/Media/Nyhetsarkiv/Vi-satsar-tre-miljarder-pa-nya-reformer/', '2013-04-14 22:00:00', 2, 0, NULL, '2013-10-22 10:20:34', NULL, '"Det är dags att införa en obligatorisk a-kassa i Sverige. Alla som arbetar och uppfyller villkoren för försäkringen bör omfattas av en arbetslöshetsförsäkring med rätt till inkomstrelaterad ersättning om man blir arbetslös."', 0, 0, '0000-00-00 00:00:00'),
(132, 5, 'ja', 68, 'http://www.centerpartiet.se/Centerpolitik/Politikomraden/Socialforsakringar-och-bidrag/Politik-A---O/A-kassaarbetsloshetsersattning/', '2013-10-21 22:00:00', 2, 0, 2, '2013-10-22 10:22:01', '2013-10-22 10:22:12', '"För Centerpartiet är en obligatorisk arbetslöshetsförsäkring en viktig del i en flexibel arbetsmarknadsmodell."', 0, 0, '0000-00-00 00:00:00'),
(133, 9, 'ja', 68, 'http://www.dn.se/nyheter/politik/mp-vill-att-a-kassan-ska-bli-obligatorisk/', '2008-02-23 23:00:00', 2, 0, NULL, '2013-10-22 10:25:05', NULL, '"Inför en obligatorisk, statlig arbetslöshetsförsäkring som slås ihop med sjukförsäkringen. Låt en ny statlig myndighet sköta sjukpenning, a-kassa och försörjningsstöd (socialbidrag). Det föreslår miljöpartiet, som samtidigt slutar sträva efter en medborgarlön."', 0, 0, '0000-00-00 00:00:00'),
(134, 1, 'nej', 68, 'http://www.dn.se/debatt/hog-tid-for-nytankande-om-den-svenska-a-kassan/', '2013-11-06 23:00:00', 6, 0, 2, '2013-10-22 10:27:26', '2013-11-07 22:17:36', '', 1, 2, '2013-11-07 22:17:36'),
(135, 7, 'nej', 68, 'http://www.dn.se/debatt/hog-tid-for-nytankande-om-den-svenska-a-kassan/', '2010-10-22 22:00:00', 2, 0, NULL, '2013-10-22 10:27:59', NULL, '', 0, 0, '0000-00-00 00:00:00'),
(136, 8, 'ja', 68, 'http://sverigedemokraterna.se/wp-content/uploads/2013/08/Sverigedemokraterna-Inriktningsprogram-2011-Arbetsmarknad.pdf', '2011-11-29 23:00:00', 2, 0, NULL, '2013-10-22 10:31:53', NULL, '"Vi anser [...] att a-kassan görs till en obligatorisk och skattefinansierad inkomstförsäkring som sköts och administreras av Försäkringskassan."', 0, 0, '0000-00-00 00:00:00'),
(137, 3, 'nej', 70, 'http://www.folkpartiet.se/var-politik/var-politik-a-o/alkohol/', '2013-10-22 10:36:28', 2, 0, NULL, '2013-10-22 10:36:28', NULL, '"Vi vill [...] Behålla Systembolagets monopol."', 0, 0, '0000-00-00 00:00:00'),
(138, 6, 'nej', 70, 'http://www.kristdemokraterna.se/VarPolitik/Korta-Svar-AO/Alkohol/', '2013-04-14 22:00:00', 2, 0, NULL, '2013-10-22 10:38:45', NULL, '"Kristdemokraterna värnar om Systembolagets försäljningsmonopol [...]"', 0, 0, '0000-00-00 00:00:00'),
(139, 5, 'nej', 70, 'http://www.centerpartiet.se/Centerpolitik/Politikomraden/Sociala-fragor-vard-och-omsorg/Politik-A---O/Alkoholpolitik/', '2013-10-22 10:39:39', 2, 0, NULL, '2013-10-22 10:39:39', NULL, '"Centerpartiet vill [...] Behålla Systembolaget som statligt monopol."', 0, 0, '0000-00-00 00:00:00'),
(140, 1, 'nej', 70, 'http://www.socialdemokraterna.se/Var-politik/Var-politik-A-till-O/Sociala-fragor/Alkohol/', '2013-06-09 22:00:00', 2, 0, NULL, '2013-10-22 10:44:24', NULL, '"Vi slår vakt om Systembolagets monopol eftersom det motverkar en försäljning som inte går att kontrollera [...]"', 0, 0, '0000-00-00 00:00:00'),
(141, 8, 'nej', 70, 'http://sverigedemokraterna.se/var-politik/var-politik-a-till-o/', '2013-10-22 10:45:30', 2, 0, NULL, '2013-10-22 10:45:30', NULL, '"Vi önskar bevara Systembolagets alkoholmonopol [...]"', 0, 0, '0000-00-00 00:00:00'),
(142, 2, 'nej', 77, 'http://www.moderat.se/skola-och-utbildning/gymnasieskolan', '2012-06-25 22:00:00', 2, 0, NULL, '2013-10-22 10:48:22', NULL, '"För de elever som väljer att läsa yrkesprogram eller lärlingsutbildning tas kravet på att läsa in högskolebehörighet bort."', 0, 0, '0000-00-00 00:00:00'),
(143, 1, 'ja', 77, 'http://www.socialdemokraterna.se/Webben-for-alla/Partidistrikt/Stockholm/Var-politik/Arkiv/A-O/Utbildning/Gymnasieskolan/', '2013-10-22 10:49:51', 2, 0, NULL, '2013-10-22 10:49:51', NULL, '"Den viktigaste prioriteringen inom gymnasieskolan är att se till att alla elever går ut med goda kunskaper och högskolebehörighet."', 0, 0, '0000-00-00 00:00:00'),
(144, 3, 'nej', 77, 'http://www.folkpartiet.se/var-politik/var-politik-a-o/gymnasieskolan/', '2013-10-22 10:53:46', 2, 0, NULL, '2013-10-22 10:53:46', NULL, '"Eleverna ska kunna välja om de vill läsa in högskolebehörighet eller inte."', 0, 0, '0000-00-00 00:00:00'),
(145, 9, 'ja', 77, 'http://www.mp.se/just-nu/mp-vill-starka-lasandet-i-skolan', '2013-10-22 10:56:42', 2, 0, NULL, '2013-10-22 10:56:42', NULL, '"Miljöpartiet vill återinföra högskolebehörigheten [...]"', 0, 0, '0000-00-00 00:00:00'),
(146, 7, 'ja', 77, 'http://www.svt.se/nyheter/blocken-oense-om-behorighet-for-larlingar', '2013-08-26 22:00:00', 2, 0, NULL, '2013-10-22 10:58:20', NULL, '', 0, 0, '0000-00-00 00:00:00'),
(147, 8, 'nej', 77, 'http://www.svt.se/nyheter/blocken-oense-om-behorighet-for-larlingar', '2013-08-26 22:00:00', 2, 0, NULL, '2013-10-22 10:58:52', NULL, '', 0, 0, '0000-00-00 00:00:00'),
(148, 1, 'ja', 20, 'http://www.socialdemokraterna.se/Var-politik/Var-politik-A-till-O/Barn/', '2013-11-15 10:25:42', 2, 1, 2, '2013-10-22 19:44:46', NULL, '"Underhållsstödet höjs med 50 kronor per barn och månad, barnbidraget med 100 kronor per barn och månad."', 0, 0, '0000-00-00 00:00:00'),
(149, 1, 'ja', 51, 'http://www.teknikensvarld.se/2011/04/10/12461/juholt-sager-ja-till-hojd-bensinskatt/', '2011-04-09 22:00:00', 2, 0, NULL, '2013-10-22 20:00:18', NULL, '"På frågan ”Ska bensinskatten höjas?” svarar Juholt – utan att tveka – ”ja”."', 0, 0, '0000-00-00 00:00:00'),
(150, 2, 'nej', 51, 'http://www.dn.se/nyheter/politik/moderat-nej-till-hojd-bensinskatt/', '2008-06-01 22:00:00', 2, 0, NULL, '2013-10-22 20:01:26', NULL, '"Statsminister Fredrik Reinfeldt säger nej till fortsatt höjd bensinskatt. Det skulle kunna slå tillbaka mot klimatarbetet, tror han"', 0, 0, '0000-00-00 00:00:00'),
(151, 3, 'nej', 51, 'http://www.folkpartiet.se/var-politik/var-politik-a-o/bensinskatt/', '2013-10-22 20:02:41', 2, 0, NULL, '2013-10-22 20:02:41', NULL, '"Vi vill [...] Behålla bensinskatten oförändrad."', 0, 0, '0000-00-00 00:00:00'),
(152, 5, 'nej', 51, 'http://www.centerpartiet.se/Centerpolitik/Politikomraden/Miljo-energi-och-klimat/Politik-A---O/Bensinpriset/', '2013-10-22 20:04:08', 2, 0, NULL, '2013-10-22 20:04:08', NULL, '"Att sänka bensinskatten är dock inte en hållbar lösning på sikt, vare sig ekonomiskt eller miljömässigt."', 0, 0, '0000-00-00 00:00:00'),
(153, 9, 'ja', 51, 'http://www.mp.se/politik/bilar-och-bensinskatt', '2013-10-22 20:05:13', 2, 0, NULL, '2013-10-22 20:05:13', NULL, '"Miljöpartiet vill [...] höja bensinskatten och satsa på modernare bilar och bättre kollektivtrafik, och"', 0, 0, '0000-00-00 00:00:00'),
(154, 6, 'nej', 51, 'http://www.sydsvenskan.se/sverige/kd-ingen-hojning-av-bensinskatt/', '2010-08-15 22:00:00', 2, 0, NULL, '2013-10-22 20:11:25', NULL, '"Kristdemokraternas partiledare Göran Hägglund lovar att arbeta för att bensinskatten inte ska höjas under nästa mandatperiod."', 0, 0, '0000-00-00 00:00:00'),
(155, 8, 'nej', 51, 'http://sverigedemokraterna.se/var-politik/var-politik-a-till-o/', '2013-10-22 20:13:10', 2, 0, NULL, '2013-10-22 20:13:10', NULL, '"Sverigedemokraterna vill ha ett stopp för fortsatta höjningar av drivmedelskatterna."', 0, 0, '0000-00-00 00:00:00'),
(156, 5, 'nej', 57, 'http://expo.se/2011/sa-tycker-riksdagspartierna-om-heltackande-slojor_3935.html', '2010-12-31 23:00:00', 2, 0, NULL, '2013-10-22 20:26:49', NULL, '"- Att föreslå lagstiftning är överflödigt. Det finns redan idag möjlighet för rektorer och arbetsgivare att själva bestämma om deras anställda ska få bära heltäckande slöja, säger Peter Svensson." ', 0, 0, '0000-00-00 00:00:00'),
(157, 3, 'ja', 57, 'http://expo.se/2011/sa-tycker-riksdagspartierna-om-heltackande-slojor_3935.html', '2010-12-31 23:00:00', 2, 0, NULL, '2013-10-22 20:28:41', NULL, '"I ett filmklipp som partiet producerade i augusti förra året säger partiledare Jan Björklund att lagarna och reglerna måste förtydligas. Förbudet ska gälla både lärare och elever:\r\n\r\n- Det är orimligt att en person med täckt ansikte ska jobba med barn i en förskola, säger Björklund i filmklippet."', 0, 0, '0000-00-00 00:00:00'),
(158, 9, 'nej', 57, 'http://expo.se/2011/sa-tycker-riksdagspartierna-om-heltackande-slojor_3935.html', '2010-12-31 23:00:00', 2, 0, NULL, '2013-10-22 20:31:52', NULL, '"- Vi vill inte förbjuda niqab på allmänna platser, säger Maria Ferm."', 0, 0, '0000-00-00 00:00:00'),
(159, 2, 'ja', 57, 'http://expo.se/2011/sa-tycker-riksdagspartierna-om-heltackande-slojor_3935.html', '2010-12-31 23:00:00', 2, 0, NULL, '2013-10-22 20:34:11', NULL, '"I ett mejl till Expo skriver Moderaternas pressekreterare Edna Cedervall att partiet inte tror på ett förbud mot heltäckande slöja bland eleverna i skolorna. Däremot vill M öppna för ett förbud mot "lärare och förskollärare att dölja sitt ansikte i sin yrkesutövning"."', 0, 0, '0000-00-00 00:00:00'),
(160, 1, 'ja', 57, 'http://expo.se/2011/sa-tycker-riksdagspartierna-om-heltackande-slojor_3935.html', '2010-12-31 23:00:00', 2, 0, NULL, '2013-10-22 20:34:49', NULL, '"Men det kan finnas vissa situationer, t.ex. i vissa yrken, där det kan ha konsekvenser om man döljer hela ansiktet. Vi tycker inte att burka ska bäras i skolan, vare sig av lärare eller av elever."', 0, 0, '0000-00-00 00:00:00'),
(161, 8, 'ja', 57, 'http://expo.se/2011/sa-tycker-riksdagspartierna-om-heltackande-slojor_3935.html', '2010-12-31 23:00:00', 2, 0, NULL, '2013-10-22 20:35:31', NULL, '"Sverigedemokraterna välkomnade det franska förbudet mot heltäckande slöjor på allmän plats. De tar tydligt ställning mot den heltäckande slöjan och förknippar plagget med terrorism. Sverige bör följa i Frankrikes fotspår, menar Åkesson i ett pressmeddelande."', 0, 0, '0000-00-00 00:00:00'),
(162, 7, 'nej', 57, 'http://expo.se/2011/sa-tycker-riksdagspartierna-om-heltackande-slojor_3935.html', '2010-12-31 23:00:00', 2, 0, 2, '2013-10-22 20:35:57', '2013-10-22 20:36:09', '"Vänsterpartiet skriver på sin sajt att det inte ska finnas något förbud mot burka, niqab eller liknande i vare sig skolan eller samhället. Samtidigt är partiet mån om att ingen ska tvingas att bära ett klädesplagg de inte vill ha:"', 0, 0, '0000-00-00 00:00:00'),
(163, 6, 'nej', 59, 'http://www.kristdemokraterna.se/VarPolitik/Korta-Svar-AO/Formogenhetsskatt/', '2013-04-14 22:00:00', 2, 0, NULL, '2013-10-27 09:54:27', NULL, '"En förmögenhetsskatt är en form av dubbelbeskattning eftersom man redan har betalat skatt på inkomsten, och ska alltså inte återinföras i någon form."', 0, 0, '0000-00-00 00:00:00'),
(164, 3, 'nej', 59, 'https://www.folkpartiet.se/var-politik/var-politik-a-o/formogenhetsskatt/', '2013-10-27 09:55:11', 2, 0, NULL, '2013-10-27 09:55:11', NULL, '"Vi vill [...] Inte återinföra förmögenhetsskatten, som drev kapital och jobb ut ur Sverige."', 0, 0, '0000-00-00 00:00:00'),
(165, 9, 'ja', 59, 'http://www.di.se/artiklar/2010/4/27/rapport-rodgrona-aterinfor-formogenhetsskatt/', '2010-04-26 22:00:00', 2, 0, NULL, '2013-10-27 09:58:08', NULL, '"Om de rödgröna partierna vinner höstens riksdagsval så kommer förmögenhetsskatten att återinföras, erfar SVT:s Rapport. Detta sedan Miljöpartiet, som tidigare motsatt sig förslaget, har ändrat sig."', 0, 0, '0000-00-00 00:00:00'),
(166, 1, 'ja', 59, 'http://www.di.se/artiklar/2010/4/27/rapport-rodgrona-aterinfor-formogenhetsskatt/', '2010-04-26 22:00:00', 2, 0, NULL, '2013-10-27 09:58:37', NULL, '"Om de rödgröna partierna vinner höstens riksdagsval så kommer förmögenhetsskatten att återinföras [...]"', 0, 0, '0000-00-00 00:00:00'),
(167, 7, 'ja', 59, 'http://www.di.se/artiklar/2010/4/27/rapport-rodgrona-aterinfor-formogenhetsskatt/', '2013-10-26 22:00:00', 2, 0, NULL, '2013-10-27 09:59:06', NULL, '"Om de rödgröna partierna vinner höstens riksdagsval så kommer förmögenhetsskatten att återinföras [...]"', 0, 0, '0000-00-00 00:00:00'),
(168, 5, 'nej', 59, 'http://www.centerpartiet.se/Centerpolitik/Politikomraden/Ekonomi-och-skatter/Politik-A---O/Ekonomisk-politik/', '2013-10-27 10:00:11', 2, 0, NULL, '2013-10-27 10:00:11', NULL, '"Andra betydelsefulla reformer som har förbättrat den svenska konkurrenskraften är avskaffad förmögenhetsskatt [...]"', 0, 0, '0000-00-00 00:00:00'),
(169, 1, 'nej', 75, 'www.socialdemokraterna.se/upload/Radslag/Skola/dokument/Skolplattform.pdf', '2007-11-15 23:00:00', 2, 0, NULL, '2013-10-27 10:20:47', NULL, '"[...] men vi säger nej till förstatligande av skolan."\r\n', 0, 0, '0000-00-00 00:00:00'),
(170, 3, 'ja', 75, 'https://www.folkpartiet.se/var-politik/var-politik-a-o/statlig-skola/', '2013-10-27 10:24:23', 2, 0, NULL, '2013-10-27 10:24:23', NULL, '"Vi vill [...] Införa ett modernt statligt huvudmannaskap."', 0, 0, '0000-00-00 00:00:00'),
(171, 7, 'ja', 75, 'http://www.dn.se/nyheter/politik/vansterpartiet-vill-forstatliga-skolan/', '2012-01-06 23:00:00', 2, 0, NULL, '2013-10-27 10:29:00', NULL, '"V:s partistyrelse ville avvakta en parlamentarisk utredning om kommunaliseringens effekter. Men kongressen valde att sätta ner foten redan nu. Beslutet fattades med röstsiffrorna 125–87."', 0, 0, '0000-00-00 00:00:00'),
(172, 8, 'ja', 75, 'http://www.di.se/artiklar/2012/5/6/sd-v-och-fp-vill-forstatliga-skolan/', '2012-05-05 22:00:00', 2, 0, NULL, '2013-10-27 10:30:49', NULL, '', 0, 0, '0000-00-00 00:00:00'),
(173, 5, 'nej', 75, 'http://www.di.se/artiklar/2012/5/6/sd-v-och-fp-vill-forstatliga-skolan/', '2012-05-05 22:00:00', 2, 0, NULL, '2013-10-27 10:31:42', NULL, '"Jag kommer aldrig att tumma på det fria skolvalet, sade C-ledaren Annie Lööf [...]"', 0, 0, '0000-00-00 00:00:00'),
(174, 1, 'nej', 53, 'http://www.socialdemokraterna.se/Var-politik/Var-politik-A-till-O/Upphovsratt-och-fildelning/', '2013-06-11 22:00:00', 2, 0, NULL, '2013-10-27 14:53:15', NULL, '"Vi tar starkt avstånd från dem som anser att det rent principiellt ska vara tillåtet att ladda ned upphovsrättsskyddat material utan att den som har skapat filmen, musiken eller boken får betalt."', 0, 0, '0000-00-00 00:00:00'),
(175, 4, 'ja', 53, 'http://politik.piratpartiet.se/fildelning-2/', '2012-10-16 22:00:00', 2, 0, NULL, '2013-10-27 14:57:25', NULL, '"Piratpartiet anser att fri, icke-kommersiell inhämtning, nyttjande, förädlande och spridning av kultur ska uppmuntras."', 0, 0, '0000-00-00 00:00:00'),
(176, 9, 'ja', 53, 'http://www.mp.se/om/partiprogram/manniskan', '2013-10-27 14:59:25', 2, 0, NULL, '2013-10-27 14:59:25', NULL, '"Kopiering och fildelning för privat bruk ska inte vara straffbart, samtidigt som upphovsmän ska ha rätt till en rimlig ersättning."', 0, 0, '0000-00-00 00:00:00'),
(177, 2, 'nej', 53, 'http://www.dn.se/nyheter/sverige/sa-tycker-partierna-om-upphovsratten/', '2009-12-31 23:00:00', 2, 0, NULL, '2013-10-27 15:01:25', NULL, '"Det är viktigt med möjligheten att göra kopior för privat bruk från lagliga digitala förlagor, men vi har inget förslag om att legalisera fildelning från olagliga förlagor. Det är viktigt att upphovsrätten respekteras."', 0, 0, '0000-00-00 00:00:00'),
(178, 3, 'nej', 53, 'http://www.dn.se/nyheter/sverige/sa-tycker-partierna-om-upphovsratten/', '2013-10-27 15:02:10', 2, 0, NULL, '2013-10-27 15:02:10', NULL, '"Nej, det anser vi inte är en bra lösning."', 0, 0, '0000-00-00 00:00:00'),
(179, 5, 'nej', 53, 'http://www.dn.se/nyheter/sverige/sa-tycker-partierna-om-upphovsratten/', '2009-12-31 23:00:00', 2, 0, NULL, '2013-10-27 15:02:57', NULL, '"Vi vill ta bort förbudet mot nedladdning av upphovsrättsskyddade verk för privat bruk. En sådan kriminalisering är inte teknikneutral eftersom samma regler inte gäller för annan kopiering för privat bruk. Tillgängliggörande av upphovsrättsskyddat material ska även fortsättningsvis vara förbjudet."', 0, 0, '0000-00-00 00:00:00'),
(180, 6, 'nej', 53, 'http://www.dn.se/nyheter/sverige/sa-tycker-partierna-om-upphovsratten/', '2009-12-31 23:00:00', 2, 0, NULL, '2013-10-27 15:03:20', NULL, '"Nej. Vi anser att upphovsmännen har rätt till sina verk, även om de finns tillgängliga på internet. I de fall upphovsmännen medger fildelning är det naturligtvis okej."', 0, 0, '0000-00-00 00:00:00'),
(181, 7, 'ja', 53, 'http://www.dn.se/nyheter/sverige/sa-tycker-partierna-om-upphovsratten/', '2009-12-31 23:00:00', 2, 0, NULL, '2013-10-27 15:04:05', NULL, '"Ja, debatten om fildelningen är i akut behov av att byta spår."', 0, 0, '0000-00-00 00:00:00'),
(182, 8, 'nej', 53, 'http://sverigedemokraterna.se/var-politik/var-politik-a-till-o/', '2013-10-27 15:05:06', 2, 0, NULL, '2013-10-27 15:05:06', NULL, '"Vad gäller frågan om spridande av upphovsrättsskyddat material står Sverigedemokraterna upp för såväl äganderätten som upphovsrätten."', 0, 0, '0000-00-00 00:00:00'),
(183, 5, 'nej', 24, 'http://www.alliansen.se/2012/05/att-aterreglera-jarnvagen-hotar-jobben/', '2012-05-01 22:00:00', 2, 0, NULL, '2013-10-27 15:12:08', NULL, '', 0, 0, '0000-00-00 00:00:00'),
(184, 3, 'nej', 24, 'http://www.alliansen.se/2012/05/att-aterreglera-jarnvagen-hotar-jobben/', '2012-05-01 22:00:00', 2, 0, NULL, '2013-10-27 15:12:34', NULL, '', 0, 0, '0000-00-00 00:00:00'),
(185, 2, 'nej', 24, 'http://www.alliansen.se/2012/05/att-aterreglera-jarnvagen-hotar-jobben/', '2012-05-01 22:00:00', 2, 0, NULL, '2013-10-27 15:12:46', NULL, '', 0, 0, '0000-00-00 00:00:00'),
(186, 6, 'nej', 24, 'http://www.alliansen.se/2012/05/att-aterreglera-jarnvagen-hotar-jobben/', '2012-05-01 22:00:00', 2, 0, NULL, '2013-10-27 15:13:03', NULL, '', 0, 0, '0000-00-00 00:00:00'),
(187, 7, 'ja', 24, 'http://www.vansterpartiet.se/aterreglera-jarnvagen/', '2012-09-12 22:00:00', 2, 0, NULL, '2013-10-27 15:14:15', NULL, '"Vi föreslår en rad förändringar, bland annat en återreglering av järnvägen som innebär att SJ får ensamrätt för kommersiell trafik på stambanorna."', 0, 0, '0000-00-00 00:00:00'),
(188, 1, 'ja', 24, 'http://www.svt.se/nyheter/sverige/lat-trafikverket-ta-hand-om-jarnvagen', '2012-05-21 22:00:00', 2, 0, NULL, '2013-10-27 15:15:06', NULL, '', 0, 0, '0000-00-00 00:00:00'),
(189, 9, 'ja', 24, 'http://www.svt.se/nyheter/sverige/lat-trafikverket-ta-hand-om-jarnvagen', '2012-05-21 22:00:00', 2, 0, NULL, '2013-10-27 15:15:42', NULL, '', 0, 0, '0000-00-00 00:00:00'),
(190, 1, 'ja', 78, 'http://www.dn.se/nyheter/sverige/krav-pa-republik-far-laggas-pa-hyllan/', '2009-02-23 23:00:00', 2, 0, NULL, '2013-10-27 21:37:08', NULL, '"Det största partiet, Socialdemokraterna, har också republikkravet inskrivet i sitt principprogram."', 0, 0, '0000-00-00 00:00:00'),
(191, 3, 'nej', 78, 'http://www.folkpartiet.se/var-politik/var-politik-a-o/monarki-och-republik/', '2013-10-27 21:39:58', 2, 0, NULL, '2013-10-27 21:39:58', NULL, '"Vi vill [...] Behålla nuvarande kompromiss om Sveriges statsskick."', 0, 0, '0000-00-00 00:00:00'),
(192, 6, 'nej', 78, 'Därför ska Sveriges statsskick även fortsättningsvis vara konstitutionell monarki.', '2012-09-26 22:00:00', 2, 0, NULL, '2013-10-27 21:41:26', NULL, '"Därför ska Sveriges statsskick även fortsättningsvis vara konstitutionell monarki."', 0, 0, '0000-00-00 00:00:00'),
(193, 2, 'nej', 78, 'http://www.moderat.se/demokrati/sveriges-grundlagar', '2012-06-14 22:00:00', 2, 0, NULL, '2013-10-27 21:43:12', NULL, '"Sveriges statsskick, monarkin, ska bevaras."', 0, 0, '0000-00-00 00:00:00'),
(194, 7, 'ja', 78, 'http://www.vansterpartiet.se/politik/monarkin/', '2013-10-27 21:44:33', 2, 0, NULL, '2013-10-27 21:44:33', NULL, '"Vänsterpartiet är aldrig berett att kompromissa om demokratin. Därför anser vi att Sverige bör vara republik med en demokratiskt vald statschef."', 0, 0, '0000-00-00 00:00:00'),
(195, 8, 'nej', 78, 'http://sverigedemokraterna.se/var-politik/var-politik-a-till-o/', '2013-10-27 21:45:38', 2, 0, NULL, '2013-10-27 21:45:38', NULL, '"Vi ställer oss positiva till dagens konstitutionella monarki med monarken som Sveriges statschef."', 0, 0, '0000-00-00 00:00:00'),
(196, 5, 'nej', 78, 'http://www.centerpartiet.se/Centerpolitik/Politikomraden/Grundlag-och-samhallsutveckling/Politik-A---O/Monarki/', '2013-10-27 21:46:59', 2, 0, NULL, '2013-10-27 21:46:59', NULL, '"Centerpartiet vill [...] bevara monarkin i dess nuvarande form – ett kungahus som endast har en representativ funktion."', 0, 0, '0000-00-00 00:00:00'),
(197, 9, 'ja', 78, 'http://www.aftonbladet.se/nyheter/valet2010/article12322089.ab', '2010-05-24 22:00:00', 2, 0, NULL, '2013-10-27 21:48:51', NULL, '"– Som demokrat måste man vara kritisk till monarkin. I grunden är det inte demokratiskt med arvstro, sa Peter Eriksson i SVT:s partiledarutfrågning i morse."', 0, 0, '0000-00-00 00:00:00'),
(198, 9, 'ja', 56, 'http://www.mp.se/om/partiprogram/valfarden', '2013-10-27 21:55:43', 2, 0, NULL, '2013-10-27 21:55:43', NULL, '"Papperslösa och asylsökande ska ha rätt till vård."', 0, 0, '0000-00-00 00:00:00'),
(199, 1, 'ja', 56, 'http://www.socialdemokraterna.se/Webben-for-alla/Landsting/Vastsverige/Kongressnyheter/Ja-till-vard-for-papperslosa/', '2013-04-04 22:00:00', 2, 0, NULL, '2013-10-27 21:56:49', NULL, '"På den socialdemokratiska partikongressen beslutades att även papperslösa ska kunna få vård efter behov, inte enbart akutsjukvård som är fallet idag."', 0, 0, '0000-00-00 00:00:00'),
(200, 5, 'ja', 56, 'http://www.centerpartiet.se/Centerpolitik/Politikomraden/Sociala-fragor-vard-och-omsorg/Politik-A---O/Papperslosa/', '2013-10-27 21:57:38', 2, 0, NULL, '2013-10-27 21:57:38', NULL, '"Centerpartiet [...] Att papperslösa och gömda ska ha rätt till vård på motsvarande villkor som övriga befolkningen"', 0, 0, '0000-00-00 00:00:00'),
(201, 8, 'nej', 56, 'http://sverigedemokraterna.se/2012/07/06/betala-inte-for-vard-till-dem-som-vistas-olagligt-i-sverige/', '2012-07-05 22:00:00', 2, 0, NULL, '2013-10-27 22:02:59', NULL, '"Betala inte för vård till dem som vistas olagligt i Sverige"', 0, 0, '0000-00-00 00:00:00'),
(202, 2, 'ja', 56, 'http://www.dn.se/nyheter/politik/alliansen-papperslosa-kan-fa-vard/', '2011-03-01 23:00:00', 2, 0, NULL, '2013-10-27 22:04:01', NULL, '', 0, 0, '0000-00-00 00:00:00'),
(203, 3, 'ja', 56, 'http://www.dn.se/nyheter/politik/alliansen-papperslosa-kan-fa-vard/', '2011-03-01 23:00:00', 2, 0, NULL, '2013-10-27 22:04:16', NULL, '', 0, 0, '0000-00-00 00:00:00'),
(204, 6, 'ja', 56, 'http://www.dn.se/nyheter/politik/alliansen-papperslosa-kan-fa-vard/', '2011-03-01 23:00:00', 2, 0, NULL, '2013-10-27 22:04:42', NULL, '', 0, 0, '0000-00-00 00:00:00'),
(205, 1, 'ja', 60, 'http://www.socialdemokraterna.se/Var-politik/Var-politik-A-till-O/Pensionar/', '2013-05-13 22:00:00', 2, 0, NULL, '2013-10-28 18:48:14', NULL, '"Idag betalar en pensionär mer i skatt än en löntagare med samma inkomst. Men pension är uppskjuten lön. Det innebär att den ska beskattas lika som lön. Allt annat är oacceptabelt."', 0, 0, '0000-00-00 00:00:00'),
(206, 9, 'ja', 60, 'http://www.mp.se/sites/default/files/mp_budgetmotion_hosten_2013.pdf', '2013-09-30 22:00:00', 2, 0, NULL, '2013-10-28 18:53:52', NULL, '"Vi delar inte alliansregeringens principiella synsätt att\r\ndet ska vara högre skatt på pension än på lön."', 0, 0, '0000-00-00 00:00:00'),
(207, 7, 'ja', 60, 'http://haninge.vansterpartiet.se/2010/07/15/lars-ohlys-tal-i-almedalen/', '2010-07-14 22:00:00', 2, 0, NULL, '2013-10-28 18:55:58', NULL, '"Vi i Vänsterpartiet vill att alla ska betala samma skatt på samma inkomst. Arbetslösa, sjuka, föräldralediga och pensionärer ska betala samma skatt på en intjänad hundralapp som den som arbetar."', 0, 0, '0000-00-00 00:00:00'),
(208, 6, 'ja', 60, 'http://www.kristdemokraterna.se/VarPolitik/Korta-Svar-AO/', '2013-10-28 19:00:55', 2, 0, NULL, '2013-10-28 19:00:55', NULL, '"Kristdemokraterna vill på sikt sänka skatten för pensionärer så att den hamnar på samma nivå som för löntagare."', 0, 0, '0000-00-00 00:00:00'),
(212, 9, 'ja', 19, 'http://www.mp.se/sites/default/files/miljopartiets_partiprogram_2013_lagupplost.pdf', '2012-12-31 23:00:00', 2, 0, NULL, '2013-11-12 22:24:59', NULL, '"Miljöpartiet värnar kvinnors rätt till abort."', 0, 0, '0000-00-00 00:00:00'),
(213, 1, 'nej', 20, 'dsa', '2013-09-14 22:00:00', 2, 0, NULL, '2013-11-15 10:25:36', NULL, 'ads', 0, 0, '0000-00-00 00:00:00'),
(214, 1, 'bla', 20, 'asdsa', '2013-11-15 10:32:27', 2, 1, 2, '2013-11-15 10:32:17', NULL, '', 0, 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Tabellstruktur `answers_tags`
--

CREATE TABLE IF NOT EXISTS `answers_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `text` text NOT NULL,
  `ip` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `referer` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `parties`
--

CREATE TABLE IF NOT EXISTS `parties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET latin1 NOT NULL,
  `website` varchar(100) CHARACTER SET latin1 NOT NULL,
  `color` text COLLATE utf8_swedish_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `last_result_parliment` float NOT NULL DEFAULT '0',
  `last_result_eu` float NOT NULL DEFAULT '0',
  `updated_by` int(11) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NULL DEFAULT NULL,
  `description` text COLLATE utf8_swedish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=10 ;

--
-- Dumpning av Data i tabell `parties`
--

INSERT INTO `parties` (`id`, `name`, `website`, `color`, `created_by`, `deleted`, `last_result_parliment`, `last_result_eu`, `updated_by`, `created_date`, `updated_date`, `description`) VALUES
(1, 'socialdemokraterna', 'http://www.socialdemokraterna.se', '#ed1b34', 2, 0, 30.7, 24.4, 2, '2013-10-21 12:58:30', '2013-10-21 20:36:55', ''),
(2, 'moderaterna', 'http://www.modarat.se', '#66bee6', 2, 0, 30.1, 18.8, NULL, '2013-10-21 12:58:30', '0000-00-00 00:00:00', NULL),
(3, 'folkpartiet', 'http://www.folkpartiet.se', '#004990', 2, 0, 7.1, 13.6, NULL, '2013-10-21 12:58:30', '0000-00-00 00:00:00', NULL),
(4, 'piratpartiet', 'http://www.piratpartiet.se', '#660087', 2, 0, 0.7, 7.1, NULL, '2013-10-21 12:58:30', '0000-00-00 00:00:00', NULL),
(5, 'centerpartiet', 'http://www.centerpartiet.se', '#099a54', 2, 0, 6.6, 5.5, NULL, '2013-10-21 12:58:30', '0000-00-00 00:00:00', NULL),
(6, 'kristdemokraterna', 'http://www.kristdemokraterna.se', '#005aa9', 2, 0, 5.6, 4.7, NULL, '2013-10-21 12:58:30', '0000-00-00 00:00:00', NULL),
(7, 'vänsterpartiet', 'http://www.vansterpartiet.se', '#ed1c24', 2, 0, 5.6, 5.7, NULL, '2013-10-21 12:58:30', '0000-00-00 00:00:00', NULL),
(8, 'sverigedemokraterna', 'http://www.sverigedemokraterna.se', '#009ddc', 2, 0, 5.7, 3.3, NULL, '2013-10-21 12:58:30', '0000-00-00 00:00:00', NULL),
(9, 'miljöpartiet', 'http://www.mp.se', '#499754', 2, 0, 7.3, 11, NULL, '2013-10-21 12:58:30', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Tabellstruktur `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) CHARACTER SET latin1 NOT NULL,
  `type` tinytext COLLATE utf8_swedish_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` text COLLATE utf8_swedish_ci,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `approved_by` int(11) DEFAULT NULL,
  `approved_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
<<<<<<< HEAD
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=82 ;
=======
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=80 ;
>>>>>>> master

--
-- Dumpning av Data i tabell `questions`
--

INSERT INTO `questions` (`id`, `title`, `type`, `created_by`, `deleted`, `updated_by`, `updated_date`, `created_date`, `description`, `approved`, `approved_by`, `approved_date`) VALUES
<<<<<<< HEAD
(14, 'Patentsystemet ska avskaffas', 'YESNO', 2, 0, 2, '2013-11-05 21:29:04', '2013-10-21 13:05:42', '', 0, 0, '0000-00-00 00:00:00'),
(15, 'FRA-lagen ska avvecklas', 'YESNO', 2, 0, 2, '2013-11-11 15:59:53', '2013-10-21 13:05:42', '', 1, 2, '2013-11-11 15:59:53'),
(17, 'Sverige ska införa euro som valuta', 'YESNO', 2, 0, 2, '2013-11-12 10:04:21', '2013-10-21 13:05:42', '', 1, 2, '2013-11-12 10:04:21'),
(18, 'Vinster i välfärden ska vara tillåtet', 'YESNO', 2, 0, 2, '2013-11-12 10:04:34', '2013-10-21 13:05:42', '', 1, 2, '2013-11-12 10:04:34'),
(19, 'Kvinnor ska ha rätt till lagliga och säkra abort', 'YESNO', 2, 0, 2, '2013-11-13 11:18:43', '2013-10-21 13:05:42', '', 1, 2, '2013-11-13 11:18:43'),
(20, 'Barnbidraget ska höjas', 'YESNO', 2, 0, 2, '2013-11-07 22:26:28', '2013-10-21 13:05:42', '', 0, 2, '2013-11-07 22:26:04'),
(21, 'Patienter ska ha rätt till dödshjälp', 'YESNO', 2, 0, 2, '2013-11-12 10:04:01', '2013-10-21 13:05:42', '', 1, 2, '2013-11-12 10:04:01'),
(22, 'Barn under 18 år ska kunna ingå i äktenskap', 'YESNO', 2, 0, 2, '2013-11-07 22:26:11', '2013-10-21 13:05:42', '', 0, 2, '2013-11-07 22:24:47'),
(23, 'Turkiet ska tillåtas gå med i EU', 'YESNO', 2, 0, 2, '2013-11-12 10:04:28', '2013-10-21 13:05:42', '', 1, 2, '2013-11-12 10:04:28'),
(24, 'Järnvägen ska återregleras', 'YESNO', 2, 0, 2, '2013-11-13 11:13:09', '2013-10-21 13:05:42', 'En återreglering av järnvägen skulle innebära att endast staten får nytja stambanorna för kommersiell trafik.', 1, 2, '2013-11-13 11:13:09'),
(25, 'Kärnkraften ska byggas ut', 'YESNO', 2, 0, 2, '2013-11-12 10:03:28', '2013-10-21 13:05:42', '', 1, 2, '2013-11-12 10:03:28'),
(26, 'Kärnkraften ska avvecklas', 'YESNO', 2, 0, 2, '2013-11-12 10:03:23', '2013-10-21 13:05:42', '', 1, 2, '2013-11-12 10:03:23'),
(27, 'Sverige ska gå med i NATO', 'YESNO', 2, 0, 2, '2013-11-12 10:04:15', '2013-10-21 13:05:42', '', 1, 2, '2013-11-12 10:04:15'),
(28, 'Gårdsförsäljning ska vara tillåtet', 'YESNO', 2, 0, 2, '2013-11-11 17:32:24', '2013-10-21 13:05:42', '', 1, 2, '2013-11-11 17:32:24'),
(29, 'Modersmålsundervisning ska vara en rättighet', 'YESNO', 2, 0, 2, '2013-11-12 10:03:42', '2013-10-21 13:05:42', '', 1, 2, '2013-11-12 10:03:42'),
(30, 'Nytillverkade bilar ska utrustas med alkolås', 'YESNO', 2, 0, 2, '2013-11-05 21:28:32', '2013-10-21 13:05:42', '', 0, 0, '0000-00-00 00:00:00'),
(31, 'Receptfria läkemedel ska kunna köpas i vanliga affärer', 'YESNO', 2, 0, 2, '2013-11-05 21:30:45', '2013-10-21 13:05:42', '', 0, 0, '0000-00-00 00:00:00'),
(32, 'Elever ska ha betyg från årskurs', 'CHOICE', 2, 0, 2, '2013-11-12 09:31:13', '2013-10-21 13:05:42', '', 0, 2, '2013-11-11 15:59:43'),
(48, 'Trängselskatt ska införas i flera städer', 'YESNO', 2, 0, 2, '2013-11-05 21:32:57', '2013-10-22 08:33:53', '', 0, 0, '0000-00-00 00:00:00'),
(49, 'Sverige ska investera i höghastighetståg', 'YESNO', 2, 0, 2, '2013-11-05 21:32:23', '2013-10-22 08:35:04', '', 0, 0, '0000-00-00 00:00:00'),
(50, 'Licensjakt på varg ska vara tillåten', 'YESNO', 2, 0, 2, '2013-11-05 21:27:49', '2013-10-22 08:39:56', '', 0, 0, '0000-00-00 00:00:00'),
(51, 'Bensinskatten ska höjas', 'YESNO', 2, 0, 2, '2013-11-08 23:10:43', '2013-10-22 08:40:34', '', 1, 2, '2013-11-08 23:10:43'),
(52, 'Statliga museer ska ha fri entré', 'YESNO', 2, 0, 2, '2013-11-05 21:31:27', '2013-10-22 08:41:35', '', 0, 0, '0000-00-00 00:00:00'),
(53, 'Icke-kommersiell kopiering av upphovsrättsskyddat material ska vara tillåten', 'YESNO', 2, 0, 2, '2013-11-11 17:32:35', '2013-10-22 08:45:02', '', 1, 2, '2013-11-11 17:32:35'),
(54, 'TV-licensen ska avskaffas', 'YESNO', 2, 0, 2, '2013-11-05 21:33:13', '2013-10-22 08:45:54', '', 0, 0, '0000-00-00 00:00:00'),
(55, 'Kommuner ska kunna säga nej till att ta emot flyktingar', 'YESNO', 2, 0, 2, '2013-11-05 21:26:49', '2013-10-22 08:47:27', '', 0, 0, '0000-00-00 00:00:00'),
(56, 'Papperslösa flyktingar ska ha rätt till vård', 'YESNO', 2, 0, 2, '2013-11-13 11:25:29', '2013-10-22 08:48:10', '', 1, 2, '2013-11-13 11:25:29'),
(57, 'Förbud för lärare att bära heltäckande slöja', 'YESNO', 2, 0, 2, '2013-11-11 17:32:02', '2013-10-22 08:49:45', '', 1, 2, '2013-11-11 17:32:02'),
(58, 'Vårdnadsbidraget ska avskaffas', 'YESNO', 2, 0, 2, '2013-11-05 21:33:35', '2013-10-22 08:51:57', '', 0, 0, '0000-00-00 00:00:00'),
(59, 'Förmögenhetsskatten ska återinföras', 'YESNO', 2, 0, 2, '2013-11-11 17:32:09', '2013-10-22 08:52:38', '', 1, 2, '2013-11-11 17:32:09'),
(60, 'Det ska vara samma skatt på pension och lön', 'YESNO', 2, 0, 2, '2013-11-13 11:23:34', '2013-10-22 08:53:39', '', 1, 2, '2013-11-13 11:23:34'),
(61, 'Rut-avdraget ska avskaffas', 'YESNO', 2, 0, 2, '2013-11-05 21:30:51', '2013-10-22 08:54:01', '', 0, 0, '0000-00-00 00:00:00'),
(62, 'Sexköpslagen ska avskaffas', 'YESNO', 2, 0, 2, '2013-11-05 21:31:02', '2013-10-22 08:57:43', '', 0, 0, '0000-00-00 00:00:00'),
(63, 'Rattfyllerister ska få hårdare straff', 'YESNO', 2, 0, 2, '2013-11-05 21:30:31', '2013-10-22 09:00:32', '', 0, 0, '0000-00-00 00:00:00'),
(64, 'Våldsbrott ska bestraffas hårdare', 'YESNO', 2, 0, 2, '2013-11-05 21:33:30', '2013-10-22 09:00:54', '', 0, 0, '0000-00-00 00:00:00'),
(65, 'Förtidspension ska vara möjlig när man är23', 'YESNO', 2, 0, 2, '2013-11-17 10:00:21', '2013-10-22 09:03:57', 'adsdsa', 0, 0, '0000-00-00 00:00:00'),
(66, 'Sjukförsäkringen ska vara tidsbegränsad', 'YESNO', 2, 0, 2, '2013-11-05 21:31:13', '2013-10-22 09:17:45', '', 0, 0, '0000-00-00 00:00:00'),
(67, 'Tandvård ska ingå i sjukförsäkringen', 'YESNO', 2, 0, 2, '2013-11-05 21:32:48', '2013-10-22 09:18:05', '', 0, 0, '0000-00-00 00:00:00'),
(68, 'A-kassan ska vara obligatorisk', 'YESNO', 6, 0, 2, '2013-11-07 22:26:17', '2013-10-22 09:19:03', '', 0, 2, '2013-11-07 22:21:49'),
(69, 'Omskärelse ska vara tillåtet endast av medicinska skäl', 'YESNO', 2, 0, 2, '2013-11-05 21:28:44', '2013-10-22 09:33:47', '', 0, 0, '0000-00-00 00:00:00'),
(70, 'Alkoholmonopolet ska avskaffas', 'YESNO', 2, 0, 2, '2013-11-08 23:10:34', '2013-10-22 09:35:16', '', 1, 2, '2013-11-08 23:10:34'),
(71, 'Svenska soldater ska tas hem ifrån Afghanistan', 'YESNO', 2, 0, 2, '2013-11-05 21:31:35', '2013-10-22 09:58:47', '', 0, 0, '0000-00-00 00:00:00'),
(72, 'Sverige ska sluta exportera vapen', 'YESNO', 2, 0, 2, '2013-11-05 21:32:31', '2013-10-22 09:59:27', '', 0, 0, '0000-00-00 00:00:00'),
(73, 'Värnplikten ska återinföras', 'YESNO', 2, 0, 2, '2013-11-05 21:33:42', '2013-10-22 10:00:04', '', 0, 0, '0000-00-00 00:00:00'),
(74, 'Sverige ska gå ur EU', 'YESNO', 2, 0, 2, '2013-11-05 21:31:45', '2013-10-22 10:00:31', '', 0, 0, '0000-00-00 00:00:00'),
(75, 'Förstatliga skolan', 'YESNO', 2, 0, 2, '2013-11-11 17:32:16', '2013-10-22 10:00:59', '', 1, 2, '2013-11-11 17:32:16'),
(76, 'Begränsa antal friskolor', 'YESNO', 2, 0, 2, '2013-11-05 21:24:17', '2013-10-22 10:02:01', '', 0, 0, '0000-00-00 00:00:00'),
(77, 'Alla gymnasieprogram ska leda till högskolebehörighet', 'YESNO', 2, 0, 2, '2013-11-08 23:10:40', '2013-10-22 10:02:27', '', 1, 2, '2013-11-08 23:10:40'),
(78, 'Monarkin ska avskaffas', 'YESNO', 2, 0, 2, '2013-11-12 10:03:48', '2013-10-22 10:03:36', '', 1, 2, '2013-11-12 10:03:48'),
(79, 'Sverige ska hålla fler folkomröstningar', 'YESNO', 2, 0, 2, '2013-11-05 21:32:06', '2013-10-22 10:04:21', '', 0, 0, '0000-00-00 00:00:00'),
(81, 'habana2', 'YESNO', 2, 1, 2, '2013-11-17 09:41:24', '2013-11-17 09:31:30', 'dsa\r\n', 1, 2, '2013-11-17 09:41:24');

-- --------------------------------------------------------

--
-- Table structure for table `question_quizzes`
--

CREATE TABLE IF NOT EXISTS `question_quizzes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `question_quizzes`
--

INSERT INTO `question_quizzes` (`id`, `question_id`, `quiz_id`) VALUES
(1, 68, 2),
(2, 76, 2),
(3, 15, 2),
(4, 59, 2),
(5, 28, 2),
(6, 75, 2),
(7, 76, 2),
(8, 65, 2),
(9, 59, 2),
(10, 26, 2),
(11, 53, 2),
(12, 51, 3),
(13, 65, 3),
(14, 75, 3),
(15, 79, 3);
=======
(14, 'Patentsystemet ska avskaffas', 'YESNO', 2, 0, 2, '2013-11-05 21:29:04', '2013-10-21 15:05:42', '', 0, 0, '0000-00-00 00:00:00'),
(15, 'FRA-lagen ska avvecklas', 'YESNO', 2, 0, 2, '2013-11-11 15:59:53', '2013-10-21 15:05:42', '', 1, 2, '2013-11-11 15:59:53'),
(17, 'Sverige ska införa euro som valuta', 'YESNO', 2, 0, 2, '2013-11-12 10:04:21', '2013-10-21 15:05:42', '', 1, 2, '2013-11-12 10:04:21'),
(18, 'Vinster i välfärden ska vara tillåtet', 'YESNO', 2, 0, 2, '2013-11-12 10:04:34', '2013-10-21 15:05:42', '', 1, 2, '2013-11-12 10:04:34'),
(19, 'Kvinnor ska ha rätt till lagliga och säkra abort', 'YESNO', 2, 0, 2, '2013-11-13 11:18:43', '2013-10-21 15:05:42', '', 1, 2, '2013-11-13 11:18:43'),
(20, 'Barnbidraget ska höjas', 'YESNO', 2, 0, 2, '2013-11-07 22:26:28', '2013-10-21 15:05:42', '', 0, 2, '2013-11-07 22:26:04'),
(21, 'Patienter ska ha rätt till dödshjälp', 'YESNO', 2, 0, 2, '2013-11-12 10:04:01', '2013-10-21 15:05:42', '', 1, 2, '2013-11-12 10:04:01'),
(22, 'Barn under 18 år ska kunna ingå i äktenskap', 'YESNO', 2, 0, 2, '2013-11-07 22:26:11', '2013-10-21 15:05:42', '', 0, 2, '2013-11-07 22:24:47'),
(23, 'Turkiet ska tillåtas gå med i EU', 'YESNO', 2, 0, 2, '2013-11-12 10:04:28', '2013-10-21 15:05:42', '', 1, 2, '2013-11-12 10:04:28'),
(24, 'Järnvägen ska återregleras', 'YESNO', 2, 0, 2, '2013-11-13 11:13:09', '2013-10-21 15:05:42', 'En återreglering av järnvägen skulle innebära att endast staten får nytja stambanorna för kommersiell trafik.', 1, 2, '2013-11-13 11:13:09'),
(25, 'Kärnkraften ska byggas ut', 'YESNO', 2, 0, 2, '2013-11-12 10:03:28', '2013-10-21 15:05:42', '', 1, 2, '2013-11-12 10:03:28'),
(26, 'Kärnkraften ska avvecklas', 'YESNO', 2, 0, 2, '2013-11-12 10:03:23', '2013-10-21 15:05:42', '', 1, 2, '2013-11-12 10:03:23'),
(27, 'Sverige ska gå med i NATO', 'YESNO', 2, 0, 2, '2013-11-12 10:04:15', '2013-10-21 15:05:42', '', 1, 2, '2013-11-12 10:04:15'),
(28, 'Gårdsförsäljning ska vara tillåtet', 'YESNO', 2, 0, 2, '2013-11-11 17:32:24', '2013-10-21 15:05:42', '', 1, 2, '2013-11-11 17:32:24'),
(29, 'Modersmålsundervisning ska vara en rättighet', 'YESNO', 2, 0, 2, '2013-11-12 10:03:42', '2013-10-21 15:05:42', '', 1, 2, '2013-11-12 10:03:42'),
(30, 'Nytillverkade bilar ska utrustas med alkolås', 'YESNO', 2, 0, 2, '2013-11-05 21:28:32', '2013-10-21 15:05:42', '', 0, 0, '0000-00-00 00:00:00'),
(31, 'Receptfria läkemedel ska kunna köpas i vanliga affärer', 'YESNO', 2, 0, 2, '2013-11-05 21:30:45', '2013-10-21 15:05:42', '', 0, 0, '0000-00-00 00:00:00'),
(32, 'Elever ska ha betyg från årskurs', 'CHOICE', 2, 0, 2, '2013-11-12 09:31:13', '2013-10-21 15:05:42', '', 0, 2, '2013-11-11 15:59:43'),
(48, 'Trängselskatt ska införas i flera städer', 'YESNO', 2, 0, 2, '2013-11-05 21:32:57', '2013-10-22 10:33:53', '', 0, 0, '0000-00-00 00:00:00'),
(49, 'Sverige ska investera i höghastighetståg', 'YESNO', 2, 0, 2, '2013-11-05 21:32:23', '2013-10-22 10:35:04', '', 0, 0, '0000-00-00 00:00:00'),
(50, 'Licensjakt på varg ska vara tillåten', 'YESNO', 2, 0, 2, '2013-11-05 21:27:49', '2013-10-22 10:39:56', '', 0, 0, '0000-00-00 00:00:00'),
(51, 'Bensinskatten ska höjas', 'YESNO', 2, 0, 2, '2013-11-08 23:10:43', '2013-10-22 10:40:34', '', 1, 2, '2013-11-08 23:10:43'),
(52, 'Statliga museer ska ha fri entré', 'YESNO', 2, 0, 2, '2013-11-05 21:31:27', '2013-10-22 10:41:35', '', 0, 0, '0000-00-00 00:00:00'),
(53, 'Icke-kommersiell kopiering av upphovsrättsskyddat material ska vara tillåten', 'YESNO', 2, 0, 2, '2013-11-11 17:32:35', '2013-10-22 10:45:02', '', 1, 2, '2013-11-11 17:32:35'),
(54, 'TV-licensen ska avskaffas', 'YESNO', 2, 0, 2, '2013-11-05 21:33:13', '2013-10-22 10:45:54', '', 0, 0, '0000-00-00 00:00:00'),
(55, 'Kommuner ska kunna säga nej till att ta emot flyktingar', 'YESNO', 2, 0, 2, '2013-11-05 21:26:49', '2013-10-22 10:47:27', '', 0, 0, '0000-00-00 00:00:00'),
(56, 'Papperslösa flyktingar ska ha rätt till vård', 'YESNO', 2, 0, 2, '2013-11-13 11:25:29', '2013-10-22 10:48:10', '', 1, 2, '2013-11-13 11:25:29'),
(57, 'Förbud för lärare att bära heltäckande slöja', 'YESNO', 2, 0, 2, '2013-11-11 17:32:02', '2013-10-22 10:49:45', '', 1, 2, '2013-11-11 17:32:02'),
(58, 'Vårdnadsbidraget ska avskaffas', 'YESNO', 2, 0, 2, '2013-11-05 21:33:35', '2013-10-22 10:51:57', '', 0, 0, '0000-00-00 00:00:00'),
(59, 'Förmögenhetsskatten ska återinföras', 'YESNO', 2, 0, 2, '2013-11-11 17:32:09', '2013-10-22 10:52:38', '', 1, 2, '2013-11-11 17:32:09'),
(60, 'Det ska vara samma skatt på pension och lön', 'YESNO', 2, 0, 2, '2013-11-13 11:23:34', '2013-10-22 10:53:39', '', 1, 2, '2013-11-13 11:23:34'),
(61, 'Rut-avdraget ska avskaffas', 'YESNO', 2, 0, 2, '2013-11-05 21:30:51', '2013-10-22 10:54:01', '', 0, 0, '0000-00-00 00:00:00'),
(62, 'Sexköpslagen ska avskaffas', 'YESNO', 2, 0, 2, '2013-11-05 21:31:02', '2013-10-22 10:57:43', '', 0, 0, '0000-00-00 00:00:00'),
(63, 'Rattfyllerister ska få hårdare straff', 'YESNO', 2, 0, 2, '2013-11-05 21:30:31', '2013-10-22 11:00:32', '', 0, 0, '0000-00-00 00:00:00'),
(64, 'Våldsbrott ska bestraffas hårdare', 'YESNO', 2, 0, 2, '2013-11-05 21:33:30', '2013-10-22 11:00:54', '', 0, 0, '0000-00-00 00:00:00'),
(65, 'Förtidspension ska vara möjlig när man är', 'YESNO', 2, 0, 2, '2013-11-05 21:26:00', '2013-10-22 11:03:57', '', 0, 0, '0000-00-00 00:00:00'),
(66, 'Sjukförsäkringen ska vara tidsbegränsad', 'YESNO', 2, 0, 2, '2013-11-05 21:31:13', '2013-10-22 11:17:45', '', 0, 0, '0000-00-00 00:00:00'),
(67, 'Tandvård ska ingå i sjukförsäkringen', 'YESNO', 2, 0, 2, '2013-11-05 21:32:48', '2013-10-22 11:18:05', '', 0, 0, '0000-00-00 00:00:00'),
(68, 'A-kassan ska vara obligatorisk', 'YESNO', 6, 0, 2, '2013-11-07 22:26:17', '2013-10-22 11:19:03', '', 0, 2, '2013-11-07 22:21:49'),
(69, 'Omskärelse ska vara tillåtet endast av medicinska skäl', 'YESNO', 2, 0, 2, '2013-11-05 21:28:44', '2013-10-22 11:33:47', '', 0, 0, '0000-00-00 00:00:00'),
(70, 'Alkoholmonopolet ska avskaffas', 'YESNO', 2, 0, 2, '2013-11-08 23:10:34', '2013-10-22 11:35:16', '', 1, 2, '2013-11-08 23:10:34'),
(71, 'Svenska soldater ska tas hem ifrån Afghanistan', 'YESNO', 2, 0, 2, '2013-11-05 21:31:35', '2013-10-22 11:58:47', '', 0, 0, '0000-00-00 00:00:00'),
(72, 'Sverige ska sluta exportera vapen', 'YESNO', 2, 0, 2, '2013-11-05 21:32:31', '2013-10-22 11:59:27', '', 0, 0, '0000-00-00 00:00:00'),
(73, 'Värnplikten ska återinföras', 'YESNO', 2, 0, 2, '2013-11-05 21:33:42', '2013-10-22 12:00:04', '', 0, 0, '0000-00-00 00:00:00'),
(74, 'Sverige ska gå ur EU', 'YESNO', 2, 0, 2, '2013-11-05 21:31:45', '2013-10-22 12:00:31', '', 0, 0, '0000-00-00 00:00:00'),
(75, 'Förstatliga skolan', 'YESNO', 2, 0, 2, '2013-11-11 17:32:16', '2013-10-22 12:00:59', '', 1, 2, '2013-11-11 17:32:16'),
(76, 'Begränsa antal friskolor', 'YESNO', 2, 0, 2, '2013-11-05 21:24:17', '2013-10-22 12:02:01', '', 0, 0, '0000-00-00 00:00:00'),
(77, 'Alla gymnasieprogram ska leda till högskolebehörighet', 'YESNO', 2, 0, 2, '2013-11-08 23:10:40', '2013-10-22 12:02:27', '', 1, 2, '2013-11-08 23:10:40'),
(78, 'Monarkin ska avskaffas', 'YESNO', 2, 0, 2, '2013-11-12 10:03:48', '2013-10-22 12:03:36', '', 1, 2, '2013-11-12 10:03:48'),
(79, 'Sverige ska hålla fler folkomröstningar', 'YESNO', 2, 0, 2, '2013-11-05 21:32:06', '2013-10-22 12:04:21', '', 0, 0, '0000-00-00 00:00:00');
>>>>>>> master

-- --------------------------------------------------------

--
-- Tabellstruktur `question_tags`
--

CREATE TABLE IF NOT EXISTS `question_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=200 ;

--
-- Dumpning av Data i tabell `question_tags`
--

INSERT INTO `question_tags` (`id`, `question_id`, `tag_id`) VALUES
(9, 76, 51),
(10, 76, 54),
(28, 55, 63),
(36, 50, 68),
(37, 50, 69),
(41, 30, 36),
(42, 30, 49),
(43, 69, 37),
(44, 69, 56),
(47, 14, 72),
(52, 63, 36),
(53, 63, 49),
(54, 63, 74),
(55, 31, 75),
(56, 31, 76),
(57, 61, 77),
(59, 62, 74),
(60, 62, 78),
(61, 66, 79),
(62, 52, 47),
(63, 71, 27),
(64, 71, 46),
(67, 74, 34),
(68, 79, 44),
(72, 49, 41),
(73, 72, 38),
(74, 72, 39),
(75, 72, 43),
(76, 67, 37),
(77, 67, 79),
(78, 67, 80),
(79, 48, 35),
(80, 48, 36),
(83, 54, 47),
(85, 64, 74),
(86, 58, 28),
(87, 73, 26),
(88, 73, 27),
(121, 22, 29),
(122, 22, 52),
(123, 68, 48),
(127, 20, 29),
(128, 20, 53),
(129, 70, 49),
(130, 70, 50),
(131, 77, 51),
(132, 51, 35),
(133, 51, 36),
(135, 15, 27),
(136, 15, 55),
(137, 57, 51),
(138, 57, 56),
(139, 59, 35),
(140, 59, 57),
(141, 75, 51),
(142, 28, 49),
(143, 53, 59),
(144, 53, 60),
(145, 53, 61),
(146, 32, 51),
(150, 26, 65),
(151, 26, 66),
(152, 26, 67),
(153, 25, 65),
(154, 25, 66),
(155, 25, 67),
(156, 29, 51),
(157, 29, 70),
(158, 78, 71),
(161, 21, 37),
(162, 21, 73),
(165, 27, 27),
(166, 27, 45),
(167, 17, 34),
(168, 17, 42),
(169, 17, 43),
(170, 23, 34),
(171, 23, 81),
(172, 18, 32),
(175, 24, 41),
(176, 24, 62),
(177, 19, 64),
(178, 60, 35),
(179, 60, 58),
(182, 56, 37),
(183, 56, 63),
(188, 81, 82),
(189, 81, 83),
(190, 81, 84),
(197, 65, 58),
(198, 65, 85),
(199, 65, 86);

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE IF NOT EXISTS `quizzes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `name`, `description`, `approved`, `date`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted`) VALUES
(1, 'bla', 'dsa', 0, '0000-00-00 00:00:00', 2, '2013-11-17 20:12:08', NULL, NULL, 0),
(2, 'bla', 'sad', 1, '2013-11-19 19:14:52', 2, '2013-11-17 20:13:18', 2, NULL, 1),
(3, 'dsadsa', 'saffsafsafsa', 1, '2013-11-17 20:39:41', 2, '2013-11-17 20:13:48', NULL, NULL, 0),
(4, 'dsadsa', 'sadafsasf', 1, '2013-11-17 20:39:41', 2, '2013-11-17 20:21:04', NULL, NULL, 0),
(5, 'hmm', 'dsadsadsadsa', 0, '2013-11-19 19:14:49', 2, '2013-11-19 19:05:59', 2, NULL, 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `quiz_results`
--

CREATE TABLE IF NOT EXISTS `quiz_results` (
  `id` varchar(40) NOT NULL,
  `data` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `version` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `quiz_results`
--

INSERT INTO `quiz_results` (`id`, `data`, `created`, `version`) VALUES
('5280015b-5ad8-4860-8091-1ee4f70e163e', '', '2013-11-10 21:59:18', 1),
('5280031b-970c-4d7f-bded-1ee4f70e163e', '{"question_agree_rate":{"1":100,"2":0,"3":33.333333333333,"4":0,"5":50,"6":50,"7":100,"8":33.333333333333,"9":100},"points_percentage":{"1":50,"2":0,"3":0,"4":0,"5":8.3333333333333,"6":8.3333333333333,"7":8.3333333333333,"8":0,"9":25}}', '2013-11-10 22:05:34', 1),
('52810025-3e88-492f-b164-29b8f70e163e', '{"question_agree_rate":{"1":50,"2":25,"3":40,"4":100,"5":25,"6":25,"7":33,"8":50,"9":67},"points_percentage":{"1":13,"2":0,"3":0,"4":38,"5":0,"6":0,"7":0,"8":0,"9":50}}', '2013-11-11 16:05:17', 1),
('52810830-2344-417c-958a-29b8f70e163e', '{"question_agree_rate":{"1":50,"2":25,"3":40,"4":100,"5":25,"6":25,"7":33,"8":50,"9":67},"points_percentage":{"1":15,"2":8,"3":15,"4":8,"5":8,"6":8,"7":8,"8":15,"9":15}}', '2013-11-11 16:40:08', 1),
('5281090d-8c00-43ea-859a-29b8f70e163e', '{"question_agree_rate":{"1":50,"2":25,"3":40,"4":100,"5":25,"6":25,"7":33,"8":50,"9":67},"points_percentage":{"1":17,"2":6,"3":14,"4":8,"5":8,"6":8,"7":8,"8":14,"9":17}}', '2013-11-11 16:43:18', 1),
('52810bd9-e3ac-423d-80f0-3267f70e163e', '{"question_agree_rate":{"1":50,"2":25,"3":40,"4":100,"5":25,"6":25,"7":33,"8":50,"9":67},"points_percentage":{"1":17,"2":6,"3":14,"4":8,"5":8,"6":8,"7":8,"8":14,"9":17}}', '2013-11-11 16:55:16', 1),
('52810c4c-90f0-4172-9ce9-3167f70e163e', '{"question_agree_rate":{"1":0,"2":50,"3":40,"4":100,"5":25,"6":25,"7":33,"8":50,"9":33},"points_percentage":{"1":0,"2":19,"3":19,"4":7,"5":11,"6":11,"7":7,"8":19,"9":7}}', '2013-11-11 16:56:57', 1),
('52811450-110c-4e83-a417-329bf70e163e', '{"question_agree_rate":{"1":0,"2":50,"3":40,"4":100,"5":25,"6":25,"7":33,"8":50,"9":33},"points_percentage":{"1":3,"2":14,"3":11,"4":17,"5":9,"6":9,"7":11,"8":14,"9":11}}', '2013-11-11 17:31:12', 1),
('528114b9-1ed8-4b53-b67b-31e4f70e163e', '{"question_agree_rate":{"1":56,"2":29,"3":50,"4":100,"5":11,"6":29,"7":57,"8":50,"9":71},"points_percentage":{"1":14,"2":5,"3":13,"4":12,"5":4,"6":8,"7":15,"8":12,"9":17}}', '2013-11-11 17:33:24', 1),
('52811ac3-ce5c-4d06-b67a-35f5f70e163e', '{"question_agree_rate":{"1":0,"2":0,"3":0,"4":0,"5":0,"6":0,"7":0,"8":0,"9":0},"points_percentage":{"1":4,"2":13,"3":0,"4":33,"5":4,"6":13,"7":13,"8":8,"9":13}}', '2013-11-11 17:59:18', 1),
('52811f7f-57c0-49e2-9ed5-36c8f70e163e', '{"question_agree_rate":{"1":0,"2":0,"3":0,"4":0,"5":0,"6":0,"7":0,"8":0,"9":0},"points_percentage":{"1":11,"2":11,"3":11,"4":11,"5":11,"6":11,"7":11,"8":11,"9":11}}', '2013-11-11 18:18:51', 1),
('5281313c-50b0-46bd-b0b2-3af0f70e163e', '{"question_agree_rate":{"1":0,"2":0,"3":0,"4":0,"5":0,"6":0,"7":0,"8":0,"9":0},"points_percentage":{"1":11,"2":11,"3":11,"4":12,"5":11,"6":11,"7":11,"8":11,"9":12}}', '2013-11-11 19:35:02', 1),
('528131aa-e1f8-43f6-a6fc-3ab7f70e163e', '{"question_agree_rate":{"1":22,"2":14,"3":20,"4":100,"5":22,"6":29,"7":57,"8":13,"9":71},"points_percentage":{"1":8,"2":6,"3":7,"4":15,"5":8,"6":10,"7":18,"8":6,"9":21}}', '2013-11-11 19:36:28', 1),
('528131e9-c560-4c3f-97ab-37daf70e163e', '{"question_agree_rate":{"1":56,"2":29,"3":50,"4":100,"5":11,"6":29,"7":57,"8":50,"9":71},"points_percentage":{"1":15,"2":6,"3":13,"4":11,"5":4,"6":7,"7":15,"8":12,"9":17}}', '2013-11-11 19:38:08', 1),
('52814fcc-a7f8-4729-b03a-452bf70e163e', '{"question_agree_rate":{"1":0,"2":0,"3":0,"4":0,"5":0,"6":0,"7":0,"8":0,"9":0},"points_percentage":{"1":4,"2":13,"3":0,"4":33,"5":4,"6":13,"7":13,"8":8,"9":13}}', '2013-11-11 21:44:54', 1),
('528150b2-73e4-4376-9bf9-4636f70e163e', '{"question_agree_rate":{"1":0,"2":0,"3":0,"4":0,"5":0,"6":0,"7":0,"8":0,"9":0},"points_percentage":{"1":11,"2":11,"3":11,"4":11,"5":11,"6":11,"7":11,"8":11,"9":11}}', '2013-11-11 21:48:43', 1),
('528150ca-dae0-4a31-b087-41e3f70e163e', '{"question_agree_rate":{"1":0,"2":0,"3":0,"4":0,"5":0,"6":0,"7":0,"8":0,"9":0},"points_percentage":{"1":11,"2":11,"3":11,"4":12,"5":11,"6":11,"7":11,"8":11,"9":12}}', '2013-11-11 21:49:23', 1),
('5281511e-9744-41b8-8bc9-452bf70e163e', '{"question_agree_rate":{"1":0,"2":0,"3":0,"4":0,"5":0,"6":0,"7":0,"8":0,"9":0},"points_percentage":{"1":11,"2":11,"3":11,"4":12,"5":11,"6":11,"7":11,"8":11,"9":12}}', '2013-11-11 21:50:41', 1),
('528152a0-b870-4cb4-977a-452cf70e163e', '{"question_agree_rate":{"1":0,"2":0,"3":0,"4":0,"5":0,"6":0,"7":0,"8":0,"9":0},"points_percentage":{"1":4,"2":13,"3":0,"4":33,"5":4,"6":13,"7":13,"8":8,"9":13}}', '2013-11-11 21:57:05', 1),
('52815340-6a80-4757-8540-452bf70e163e', '{"question_agree_rate":{"1":0,"2":29,"3":10,"4":100,"5":22,"6":14,"7":29,"8":25,"9":29},"points_percentage":{"1":1,"2":14,"3":5,"4":20,"5":11,"6":9,"7":14,"8":13,"9":14}}', '2013-11-11 22:02:25', 1),
('5281f566-1bc4-4874-9122-4636f70e163e', '{"question_agree_rate":{"1":0,"2":0,"3":0,"4":0,"5":0,"6":0,"7":0,"8":0,"9":0},"points_percentage":{"1":11,"2":11,"3":11,"4":11,"5":11,"6":11,"7":11,"8":11,"9":11}}', '2013-11-12 09:31:27', 1),
('5281f63b-e160-4f1d-94b3-452cf70e163e', '{"question_agree_rate":{"1":25,"2":0,"3":11,"4":50,"5":13,"6":17,"7":33,"8":14,"9":29},"points_percentage":{"1":15,"2":7,"3":10,"4":10,"5":10,"6":10,"7":14,"8":11,"9":14}}', '2013-11-12 09:35:03', 1),
('5281f751-302c-40f9-b043-4814f70e163e', '{"question_agree_rate":{"1":0,"2":0,"3":0,"4":0,"5":0,"6":0,"7":0,"8":0,"9":0},"points_percentage":{"1":11,"2":11,"3":11,"4":11,"5":11,"6":11,"7":11,"8":11,"9":11}}', '2013-11-12 09:39:40', 1),
('5281fb66-29b8-428a-9e74-452cf70e163e', '{"question_agree_rate":{"1":38,"2":33,"3":33,"4":50,"5":13,"6":33,"7":17,"8":29,"9":29},"points_percentage":{"1":16,"2":11,"3":16,"4":8,"5":7,"6":12,"7":7,"8":12,"9":11}}', '2013-11-12 09:57:07', 1),
('5281fd4c-1d8c-4bd2-a754-452bf70e163e', '{"question_agree_rate":{"1":78,"2":31,"3":40,"4":100,"5":39,"6":50,"7":88,"8":53,"9":82},"points_percentage":{"1":15,"2":7,"3":9,"4":8,"5":8,"6":10,"7":17,"8":11,"9":16}}', '2013-11-12 10:06:34', 1),
('5282bff5-e2a8-41bf-815b-759cf70e163e', '{"question_agree_rate":{"1":0,"2":6,"3":0,"4":67,"5":6,"6":6,"7":13,"8":6,"9":11},"points_percentage":{"1":9,"2":11,"3":8,"4":13,"5":11,"6":11,"7":13,"8":11,"9":13}}', '2013-11-12 23:56:30', 1),
('5282c158-3ff4-405a-b4c7-7a37f70e163e', '{"question_agree_rate":{"1":0,"2":50,"3":0,"4":100,"5":50,"6":50,"7":100,"8":100,"9":100},"points_percentage":{"1":9,"2":11,"3":8,"4":13,"5":11,"6":11,"7":13,"8":11,"9":13}}', '2013-11-13 00:01:50', 1),
('5282c1be-ba9c-494c-9aca-77c0f70e163e', '{"question_agree_rate":{"1":75,"2":30,"3":40,"4":100,"5":37,"6":51,"7":90,"8":56,"9":84},"points_percentage":{"1":15,"2":6,"3":9,"4":8,"5":8,"6":10,"7":16,"8":11,"9":17}}', '2013-11-13 00:21:24', 1),
('5282cbf7-ab40-41e8-8d7e-77cff70e163e', '{"question_agree_rate":{"1":0,"2":50,"3":0,"4":100,"5":38,"6":38,"7":60,"8":60,"9":60},"points_percentage":{"1":11,"2":11,"3":7,"4":15,"5":10,"6":10,"7":12,"8":12,"9":12}}', '2013-11-13 00:47:12', 1),
('5282d0bd-f55c-44cb-9d1e-79b7f70e163e', '{"question_agree_rate":{"1":73,"2":25,"3":35,"4":100,"5":44,"6":49,"7":95,"8":49,"9":91},"points_percentage":{"1":17,"2":0,"3":0,"4":19,"5":0,"6":3,"7":30,"8":3,"9":28}}', '2013-11-13 01:09:18', 1),
('5282d75c-6858-4f44-80f4-79b7f70e163e', '{"question_agree_rate":{"1":20,"2":50,"3":25,"4":100,"5":38,"6":50,"7":50,"8":50,"9":38},"points_percentage":{"1":0,"2":0,"3":0,"4":100,"5":0,"6":0,"7":0,"8":0,"9":0}}', '2013-11-13 01:35:48', 1),
('52833885-64f8-4e70-aa9e-79b7f70e163e', '{"question_agree_rate":{"1":70,"2":31,"3":48,"4":100,"5":30,"6":54,"7":83,"8":54,"9":78},"points_percentage":{"1":23,"2":0,"3":0,"4":7,"5":0,"6":4,"7":32,"8":4,"9":30}}', '2013-11-13 08:32:21', 1),
('52834144-b074-4f62-ad7c-03d3f70e163e', '{"question_agree_rate":{"1":{"result":43,"range":7,"plus_points":3},"2":{"result":31,"range":13,"plus_points":4},"3":{"result":0,"range":13,"plus_points":0},"4":{"result":100,"range":4,"plus_points":4},"5":{"result":15,"range":13,"plus_points":2},"6":{"result":18,"range":11,"plus_points":2},"7":{"result":69,"range":13,"plus_points":9},"8":{"result":78,"range":9,"plus_points":7},"9":{"result":54,"range":13,"plus_points":7}},"points_percentage":{"1":0,"2":0,"3":0,"4":27,"5":0,"6":0,"7":33,"8":33,"9":7}}', '2013-11-13 09:07:37', 1),
('528345cf-dbfc-4003-afdf-130ef70e163e', '{"question_agree_rate":{"1":{"result":0,"range":4,"points":0},"2":{"result":40,"range":10,"points":4},"3":{"result":0,"range":8,"points":0},"4":{"result":100,"range":4,"points":4},"5":{"result":25,"range":8,"points":2},"6":{"result":25,"range":8,"points":2},"7":{"result":60,"range":10,"points":6},"8":{"result":50,"range":4,"points":2},"9":{"result":40,"range":10,"points":4}},"points_percentage":{"1":{"result":0,"range":6,"points":-4},"2":{"result":0,"range":6,"points":-2},"3":{"result":0,"range":6,"points":-8},"4":{"result":67,"range":6,"points":4},"5":{"result":0,"range":6,"points":-4},"6":{"result":0,"range":6,"points":-4},"7":{"result":33,"range":6,"points":2},"8":{"result":0,"range":6,"points":0},"9":{"result":0,"range":6,"points":-2}}}', '2013-11-13 09:26:55', 1),
('52834dae-9a5c-4fe2-90da-14adf70e163e', '{"question_agree_rate":{"1":{"result":57,"range":7,"plus_points":4,"minus_points":3},"2":{"result":38,"range":16,"plus_points":6,"minus_points":10},"3":{"result":29,"range":14,"plus_points":4,"minus_points":10},"4":{"result":100,"range":6,"plus_points":6,"minus_points":0},"5":{"result":50,"range":14,"plus_points":7,"minus_points":7},"6":{"result":46,"range":13,"plus_points":6,"minus_points":7},"7":{"result":100,"range":16,"plus_points":16,"minus_points":0},"8":{"result":88,"range":8,"plus_points":7,"minus_points":1},"9":{"result":81,"range":16,"plus_points":13,"minus_points":3}},"points_percentage":{"1":{"result":3,"range":39,"points":1},"2":{"result":0,"range":39,"points":-4},"3":{"result":0,"range":39,"points":-6},"4":{"result":15,"range":39,"points":6},"5":{"result":0,"range":39,"points":0},"6":{"result":0,"range":39,"points":-1},"7":{"result":41,"range":39,"points":16},"8":{"result":15,"range":39,"points":6},"9":{"result":26,"range":39,"points":10}}}', '2013-11-13 10:01:00', 1),
('52835b08-d244-41f6-8c1b-1ec7f70e163e', '{"question_agree_rate":{"1":{"result":70,"range":43,"plus_points":30,"minus_points":13},"2":{"result":35,"range":40,"plus_points":14,"minus_points":26},"3":{"result":42,"range":48,"plus_points":20,"minus_points":28},"4":{"result":100,"range":9,"plus_points":9,"minus_points":0},"5":{"result":36,"range":45,"plus_points":16,"minus_points":29},"6":{"result":55,"range":42,"plus_points":23,"minus_points":19},"7":{"result":85,"range":39,"plus_points":33,"minus_points":6},"8":{"result":56,"range":39,"plus_points":22,"minus_points":17},"9":{"result":80,"range":45,"plus_points":36,"minus_points":9}},"points_percentage":{"1":{"result":19,"range":89,"points":17},"2":{"result":0,"range":89,"points":-12},"3":{"result":0,"range":89,"points":-8},"4":{"result":10,"range":89,"points":9},"5":{"result":0,"range":89,"points":-13},"6":{"result":4,"range":89,"points":4},"7":{"result":30,"range":89,"points":27},"8":{"result":6,"range":89,"points":5},"9":{"result":30,"range":89,"points":27}}}', '2013-11-13 10:58:58', 1),
('52838218-e3c0-4f87-aeec-2217f70e163e', '{"question_agree_rate":{"1":{"result":0,"range":0,"plus_points":0,"minus_points":0},"2":{"result":0,"range":2,"plus_points":0,"minus_points":2},"3":{"result":0,"range":2,"plus_points":0,"minus_points":2},"4":{"result":100,"range":2,"plus_points":2,"minus_points":0},"5":{"result":0,"range":2,"plus_points":0,"minus_points":2},"6":{"result":0,"range":2,"plus_points":0,"minus_points":2},"7":{"result":100,"range":2,"plus_points":2,"minus_points":0},"8":{"result":0,"range":0,"plus_points":0,"minus_points":0},"9":{"result":100,"range":2,"plus_points":2,"minus_points":0}},"points_percentage":{"1":{"result":0,"range":6,"points":0},"2":{"result":0,"range":6,"points":-2},"3":{"result":0,"range":6,"points":-2},"4":{"result":33,"range":6,"points":2},"5":{"result":0,"range":6,"points":-2},"6":{"result":0,"range":6,"points":-2},"7":{"result":33,"range":6,"points":2},"8":{"result":0,"range":6,"points":0},"9":{"result":33,"range":6,"points":2}}}', '2013-11-13 13:43:59', 0),
('52838239-be20-48a8-b9cb-1fbef70e163e', '{"question_agree_rate":{"1":{"result":0,"range":0,"plus_points":0,"minus_points":0},"2":{"result":67,"range":6,"plus_points":4,"minus_points":2},"3":{"result":0,"range":4,"plus_points":0,"minus_points":4},"4":{"result":100,"range":4,"plus_points":4,"minus_points":0},"5":{"result":50,"range":4,"plus_points":2,"minus_points":2},"6":{"result":50,"range":4,"plus_points":2,"minus_points":2},"7":{"result":67,"range":6,"plus_points":4,"minus_points":2},"8":{"result":100,"range":2,"plus_points":2,"minus_points":0},"9":{"result":67,"range":6,"plus_points":4,"minus_points":2}},"points_percentage":{"1":{"result":0,"range":12,"points":0},"2":{"result":17,"range":12,"points":2},"3":{"result":0,"range":12,"points":-4},"4":{"result":33,"range":12,"points":4},"5":{"result":0,"range":12,"points":0},"6":{"result":0,"range":12,"points":0},"7":{"result":17,"range":12,"points":2},"8":{"result":17,"range":12,"points":2},"9":{"result":17,"range":12,"points":2}}}', '2013-11-13 13:44:44', 2),
('5283b2b3-9bc0-4eab-8eca-03d3f70e163e', '{"question_agree_rate":{"1":{"result":0,"range":0,"plus_points":0,"minus_points":0},"2":{"result":0,"range":2,"plus_points":0,"minus_points":2},"3":{"result":0,"range":2,"plus_points":0,"minus_points":2},"4":{"result":100,"range":2,"plus_points":2,"minus_points":0},"5":{"result":0,"range":2,"plus_points":0,"minus_points":2},"6":{"result":0,"range":2,"plus_points":0,"minus_points":2},"7":{"result":100,"range":2,"plus_points":2,"minus_points":0},"8":{"result":0,"range":0,"plus_points":0,"minus_points":0},"9":{"result":100,"range":2,"plus_points":2,"minus_points":0}},"points_percentage":{"1":{"result":0,"range":6,"points":0},"2":{"result":0,"range":6,"points":-2},"3":{"result":0,"range":6,"points":-2},"4":{"result":33,"range":6,"points":2},"5":{"result":0,"range":6,"points":-2},"6":{"result":0,"range":6,"points":-2},"7":{"result":33,"range":6,"points":2},"8":{"result":0,"range":6,"points":0},"9":{"result":33,"range":6,"points":2}}}', '2013-11-13 17:11:32', 2),
('5284b1df-eee0-4af8-8640-19c83e7c5f7b', '{"question_agree_rate":{"1":{"result":100,"range":2,"plus_points":2,"minus_points":0},"2":{"result":50,"range":4,"plus_points":2,"minus_points":2},"3":{"result":50,"range":4,"plus_points":2,"minus_points":2},"4":{"result":100,"range":2,"plus_points":2,"minus_points":0},"5":{"result":50,"range":4,"plus_points":2,"minus_points":2},"6":{"result":50,"range":4,"plus_points":2,"minus_points":2},"7":{"result":100,"range":4,"plus_points":4,"minus_points":0},"8":{"result":100,"range":2,"plus_points":2,"minus_points":0},"9":{"result":100,"range":4,"plus_points":4,"minus_points":0}},"points_percentage":{"1":{"result":14,"range":14,"points":2},"2":{"result":0,"range":14,"points":0},"3":{"result":0,"range":14,"points":0},"4":{"result":14,"range":14,"points":2},"5":{"result":0,"range":14,"points":0},"6":{"result":0,"range":14,"points":0},"7":{"result":29,"range":14,"points":4},"8":{"result":14,"range":14,"points":2},"9":{"result":29,"range":14,"points":4}}}', '2013-11-14 13:30:36', 2),
('5284d111-61c8-4cff-ac26-17d03e7c5f7b', '{"question_agree_rate":{"1":{"result":0,"range":0,"plus_points":0,"minus_points":0},"2":{"result":0,"range":0,"plus_points":0,"minus_points":0},"3":{"result":0,"range":0,"plus_points":0,"minus_points":0},"4":{"result":0,"range":0,"plus_points":0,"minus_points":0},"5":{"result":0,"range":0,"plus_points":0,"minus_points":0},"6":{"result":0,"range":0,"plus_points":0,"minus_points":0},"7":{"result":0,"range":0,"plus_points":0,"minus_points":0},"8":{"result":0,"range":0,"plus_points":0,"minus_points":0},"9":{"result":0,"range":0,"plus_points":0,"minus_points":0}},"points_percentage":{"1":{"result":0,"range":0,"points":0},"2":{"result":0,"range":0,"points":0},"3":{"result":0,"range":0,"points":0},"4":{"result":0,"range":0,"points":0},"5":{"result":0,"range":0,"points":0},"6":{"result":0,"range":0,"points":0},"7":{"result":0,"range":0,"points":0},"8":{"result":0,"range":0,"points":0},"9":{"result":0,"range":0,"points":0}}}', '2013-11-14 13:33:20', 2),
('5284d159-92b4-43eb-80b8-17d03e7c5f7b', '{"question_agree_rate":{"1":{"result":0,"range":0,"plus_points":0,"minus_points":0},"2":{"result":0,"range":2,"plus_points":0,"minus_points":2},"3":{"result":0,"range":2,"plus_points":0,"minus_points":2},"4":{"result":100,"range":2,"plus_points":2,"minus_points":0},"5":{"result":0,"range":2,"plus_points":0,"minus_points":2},"6":{"result":0,"range":2,"plus_points":0,"minus_points":2},"7":{"result":100,"range":2,"plus_points":2,"minus_points":0},"8":{"result":0,"range":0,"plus_points":0,"minus_points":0},"9":{"result":100,"range":2,"plus_points":2,"minus_points":0}},"points_percentage":{"1":{"result":0,"range":6,"points":0},"2":{"result":0,"range":6,"points":-2},"3":{"result":0,"range":6,"points":-2},"4":{"result":33,"range":6,"points":2},"5":{"result":0,"range":6,"points":-2},"6":{"result":0,"range":6,"points":-2},"7":{"result":33,"range":6,"points":2},"8":{"result":0,"range":6,"points":0},"9":{"result":33,"range":6,"points":2}}}', '2013-11-14 13:34:39', 2),
('52851620-05c8-4016-b53f-13743e7c5f7b', '{"question_agree_rate":{"1":{"result":0,"range":0,"plus_points":0,"minus_points":0},"2":{"result":0,"range":0,"plus_points":0,"minus_points":0},"3":{"result":0,"range":0,"plus_points":0,"minus_points":0},"4":{"result":0,"range":0,"plus_points":0,"minus_points":0},"5":{"result":0,"range":0,"plus_points":0,"minus_points":0},"6":{"result":0,"range":0,"plus_points":0,"minus_points":0},"7":{"result":0,"range":0,"plus_points":0,"minus_points":0},"8":{"result":0,"range":0,"plus_points":0,"minus_points":0},"9":{"result":0,"range":0,"plus_points":0,"minus_points":0}},"points_percentage":{"1":{"result":0,"range":0,"points":0},"2":{"result":0,"range":0,"points":0},"3":{"result":0,"range":0,"points":0},"4":{"result":0,"range":0,"points":0},"5":{"result":0,"range":0,"points":0},"6":{"result":0,"range":0,"points":0},"7":{"result":0,"range":0,"points":0},"8":{"result":0,"range":0,"points":0},"9":{"result":0,"range":0,"points":0}}}', '2013-11-14 18:28:01', 2),
('5285ebc7-bc3c-4836-94f4-26283e7c5f7b', '{"question_agree_rate":{"1":{"result":0,"range":0,"plus_points":0,"minus_points":0},"2":{"result":0,"range":2,"plus_points":0,"minus_points":2},"3":{"result":0,"range":2,"plus_points":0,"minus_points":2},"4":{"result":100,"range":2,"plus_points":2,"minus_points":0},"5":{"result":0,"range":2,"plus_points":0,"minus_points":2},"6":{"result":0,"range":2,"plus_points":0,"minus_points":2},"7":{"result":100,"range":2,"plus_points":2,"minus_points":0},"8":{"result":0,"range":0,"plus_points":0,"minus_points":0},"9":{"result":100,"range":2,"plus_points":2,"minus_points":0}},"points_percentage":{"1":{"result":0,"range":6,"points":0},"2":{"result":0,"range":6,"points":-2},"3":{"result":0,"range":6,"points":-2},"4":{"result":33,"range":6,"points":2},"5":{"result":0,"range":6,"points":-2},"6":{"result":0,"range":6,"points":-2},"7":{"result":33,"range":6,"points":2},"8":{"result":0,"range":6,"points":0},"9":{"result":33,"range":6,"points":2}}}', '2013-11-15 09:40:42', 2);

-- --------------------------------------------------------

--
-- Tabellstruktur `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumpning av Data i tabell `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'moderator'),
(3, 'contributor'),
(4, 'unactivated');

-- --------------------------------------------------------

--
-- Tabellstruktur `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=87 ;

--
-- Dumpning av Data i tabell `tags`
--

INSERT INTO `tags` (`id`, `name`, `deleted`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(26, 'värnplikt', 0, 0, '2013-10-31 19:49:03', 0, '0000-00-00 00:00:00'),
(27, 'försvar', 0, 0, '2013-10-31 19:49:03', 0, '0000-00-00 00:00:00'),
(28, 'bidrag', 0, 0, '2013-10-31 19:49:20', 0, '0000-00-00 00:00:00'),
(29, 'familj', 0, 0, '2013-10-31 19:49:20', 0, '0000-00-00 00:00:00'),
(30, 'brottslighet', 0, 0, '2013-10-31 19:49:34', 0, '0000-00-00 00:00:00'),
(31, 'straff', 0, 0, '2013-10-31 19:49:34', 0, '0000-00-00 00:00:00'),
(32, 'välfärd', 0, 0, '2013-10-31 19:49:48', 0, '0000-00-00 00:00:00'),
(33, 'media', 0, 0, '2013-10-31 19:49:59', 0, '0000-00-00 00:00:00'),
(34, 'eu', 0, 0, '2013-10-31 19:50:10', 0, '0000-00-00 00:00:00'),
(35, 'skatt', 0, 0, '2013-10-31 19:50:22', 0, '0000-00-00 00:00:00'),
(36, 'trafik', 0, 0, '2013-10-31 19:50:22', 0, '0000-00-00 00:00:00'),
(37, 'vård', 0, 0, '2013-10-31 19:55:20', 0, '0000-00-00 00:00:00'),
(38, 'vapen', 0, 0, '2013-10-31 19:55:36', 0, '0000-00-00 00:00:00'),
(39, 'export', 0, 0, '2013-10-31 19:55:36', 0, '0000-00-00 00:00:00'),
(40, 'tåg', 0, 0, '2013-10-31 19:55:57', 0, '0000-00-00 00:00:00'),
(41, 'infrastruktur', 0, 0, '2013-10-31 19:55:57', 0, '0000-00-00 00:00:00'),
(42, 'euro', 0, 0, '2013-10-31 19:56:11', 0, '0000-00-00 00:00:00'),
(43, 'ekonomi', 0, 0, '2013-10-31 19:56:11', 0, '0000-00-00 00:00:00'),
(44, 'demokrati', 0, 0, '2013-10-31 19:56:26', 0, '0000-00-00 00:00:00'),
(45, 'nato', 0, 0, '2013-10-31 19:56:41', 0, '0000-00-00 00:00:00'),
(46, 'afghanistan', 0, 0, '2013-10-31 19:56:55', 0, '0000-00-00 00:00:00'),
(47, 'kultur', 0, 0, '2013-10-31 19:57:10', 0, '0000-00-00 00:00:00'),
(48, 'a-kassa', 0, 0, '2013-11-05 21:22:08', 0, '0000-00-00 00:00:00'),
(49, 'alkohol', 0, 0, '2013-11-05 21:22:52', 0, '0000-00-00 00:00:00'),
(50, 'monopol', 0, 0, '2013-11-05 21:22:52', 0, '0000-00-00 00:00:00'),
(51, 'utbildning', 0, 0, '2013-11-05 21:23:10', 0, '0000-00-00 00:00:00'),
(52, 'äktenskap', 0, 0, '2013-11-05 21:23:56', 0, '0000-00-00 00:00:00'),
(53, 'barnbidrag', 0, 0, '2013-11-05 21:24:07', 0, '0000-00-00 00:00:00'),
(54, 'friskolor', 0, 0, '2013-11-05 21:24:17', 0, '0000-00-00 00:00:00'),
(55, 'fra', 0, 0, '2013-11-05 21:24:51', 0, '0000-00-00 00:00:00'),
(56, 'religion', 0, 0, '2013-11-05 21:25:16', 0, '0000-00-00 00:00:00'),
(57, 'förmögenhetsskatt', 0, 0, '2013-11-05 21:25:44', 0, '0000-00-00 00:00:00'),
(58, 'pension', 0, 0, '2013-11-05 21:26:00', 0, '0000-00-00 00:00:00'),
(59, 'fildelning', 0, 0, '2013-11-05 21:26:29', 0, '0000-00-00 00:00:00'),
(60, 'upphovsrätt', 0, 0, '2013-11-05 21:26:29', 0, '0000-00-00 00:00:00'),
(61, 'piratkopiering', 0, 0, '2013-11-05 21:26:29', 0, '0000-00-00 00:00:00'),
(62, 'järnväg', 0, 0, '2013-11-05 21:26:37', 0, '0000-00-00 00:00:00'),
(63, 'invandring', 0, 0, '2013-11-05 21:26:49', 0, '0000-00-00 00:00:00'),
(64, 'abort', 0, 0, '2013-11-05 21:26:55', 0, '0000-00-00 00:00:00'),
(65, 'kärnkraft', 0, 0, '2013-11-05 21:27:33', 0, '0000-00-00 00:00:00'),
(66, 'miljö', 0, 0, '2013-11-05 21:27:33', 0, '0000-00-00 00:00:00'),
(67, 'energi', 0, 0, '2013-11-05 21:27:33', 0, '0000-00-00 00:00:00'),
(68, 'jakt', 0, 0, '2013-11-05 21:27:49', 0, '0000-00-00 00:00:00'),
(69, 'varg', 0, 0, '2013-11-05 21:27:49', 0, '0000-00-00 00:00:00'),
(70, 'modersmålsundervisning', 0, 0, '2013-11-12 23:32:43', 0, '0000-00-00 00:00:00'),
(71, 'monarki', 0, 0, '2013-11-05 21:28:24', 0, '0000-00-00 00:00:00'),
(72, 'patent', 0, 0, '2013-11-05 21:29:04', 0, '0000-00-00 00:00:00'),
(73, 'dödshjälp', 0, 0, '2013-11-05 21:30:07', 0, '0000-00-00 00:00:00'),
(74, 'brott', 0, 0, '2013-11-05 21:30:31', 0, '0000-00-00 00:00:00'),
(75, 'läkemedel', 0, 0, '2013-11-05 21:30:45', 0, '0000-00-00 00:00:00'),
(76, 'apotek', 0, 0, '2013-11-05 21:30:45', 0, '0000-00-00 00:00:00'),
(77, 'rut', 0, 0, '2013-11-05 21:30:51', 0, '0000-00-00 00:00:00'),
(78, 'prostitution', 0, 0, '2013-11-05 21:30:57', 0, '0000-00-00 00:00:00'),
(79, 'försäkring', 0, 0, '2013-11-05 21:31:13', 0, '0000-00-00 00:00:00'),
(80, 'tandvård', 0, 0, '2013-11-05 21:32:48', 0, '0000-00-00 00:00:00'),
(81, 'turkiet', 0, 0, '2013-11-05 21:33:03', 0, '0000-00-00 00:00:00'),
(82, 'test1', 0, 0, '2013-11-17 09:31:30', 0, '0000-00-00 00:00:00'),
(83, 'ekonomi2', 0, 0, '2013-11-17 09:41:24', 0, '0000-00-00 00:00:00'),
(84, 'politik', 0, 0, '2013-11-17 09:41:24', 0, '0000-00-00 00:00:00'),
(85, 'dsa', 0, 0, '2013-11-17 09:55:27', 0, '0000-00-00 00:00:00'),
(86, 'blu', 0, 0, '2013-11-17 09:59:22', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role_id` int(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `email` char(50) DEFAULT NULL,
  `description` text,
  `email` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

--
-- Dumpning av Data i tabell `users`
--

<<<<<<< HEAD
INSERT INTO `users` (`id`, `username`, `password`, `role_id`, `created_date`, `updated_date`, `deleted`, `created_by`, `updated_by`, `description`, `email`) VALUES
(2, 'admin', '$2a$10$WPL9Lf1FgFR5uXX32VSceeWjAzv2enWjFWs6vxC9SXpzZmwm/oBwC', 1, '2013-11-12 21:17:07', NULL, 0, 2, NULL, '', ''),
(5, 'moderator', '$2a$10$IoMnoMbaeqYEKmjrRos7P.wYXIafF09thSlLxrHCIto2cCRAB69IS', 2, '2013-10-17 13:40:11', NULL, 0, 2, NULL, NULL, ''),
(6, 'contributor', '$2a$10$K1L48./n05.eBugWMCWD8.sRI61gdHWJfJsMGsQToeAognQEmSt1y', 3, '2013-10-17 13:40:27', '0000-00-00 00:00:00', 0, 2, 0, NULL, ''),
(8, 'bla2', '$2a$10$beMpDZBhAljWJFuH7pbMa.Nrsv6qZGuIxCdnCOV8156vaPNPpfyAm', 2, '2013-11-13 12:37:52', '2013-11-13 12:37:59', 1, 2, 2, '', ''),
(9, NULL, NULL, NULL, NULL, NULL, 1, NULL, 2, NULL, '');
=======
INSERT INTO `users` (`id`, `username`, `password`, `role_id`, `created_date`, `updated_date`, `deleted`, `created_by`, `updated_by`, `email`, `description`) VALUES
(2, 'admin', '$2a$10$WPL9Lf1FgFR5uXX32VSceeWjAzv2enWjFWs6vxC9SXpzZmwm/oBwC', 1, '2013-11-12 21:17:07', NULL, 0, 2, NULL, NULL, ''),
(5, 'moderator', '$2a$10$IoMnoMbaeqYEKmjrRos7P.wYXIafF09thSlLxrHCIto2cCRAB69IS', 2, '2013-10-17 13:40:11', NULL, 0, 2, NULL, NULL, NULL),
(6, 'contributor', '$2a$10$K1L48./n05.eBugWMCWD8.sRI61gdHWJfJsMGsQToeAognQEmSt1y', 3, '2013-10-17 13:40:27', '0000-00-00 00:00:00', 0, 2, 0, NULL, NULL);
>>>>>>> master

-- --------------------------------------------------------

--
-- Tabellstruktur `user_logs`
--

CREATE TABLE IF NOT EXISTS `user_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `model` text NOT NULL,
  `action` text NOT NULL,
  `object_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `text` text NOT NULL,
  `ip` text,
  PRIMARY KEY (`id`)
<<<<<<< HEAD
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;
=======
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;
>>>>>>> master

--
-- Dumpning av Data i tabell `user_logs`
--

INSERT INTO `user_logs` (`id`, `user_id`, `model`, `action`, `object_id`, `date`, `text`, `ip`) VALUES
(1, 2, 'answer', 'add', 212, '2013-11-12 22:24:59', 'ja', '127.0.0.1'),
(2, 2, 'question', 'edit', 24, '2013-11-13 11:10:28', '', '127.0.0.1'),
(3, 2, 'question', 'edit', 24, '2013-11-13 11:13:09', '', '127.0.0.1'),
<<<<<<< HEAD
(4, 2, 'question', 'edit', 19, '2013-11-13 11:18:43', '', '127.0.0.1'),
(5, 2, 'question', 'edit', 60, '2013-11-13 11:23:34', '', '127.0.0.1'),
(6, 2, 'question', 'edit', 56, '2013-11-13 11:24:02', '', '127.0.0.1'),
(7, 2, 'question', 'edit', 56, '2013-11-13 11:25:29', '', '127.0.0.1'),
(8, 2, 'user', 'add', 8, '2013-11-13 11:37:52', 'bla', '127.0.0.1'),
(9, 2, 'user', 'edit', 8, '2013-11-13 11:38:00', '', '127.0.0.1'),
(10, 2, 'user', 'delete', 8, '2013-11-13 11:38:32', '', '127.0.0.1'),
(11, 2, 'answer', 'add', 213, '2013-11-15 10:25:36', 'nej', '127.0.0.1'),
(12, 2, 'answer', 'delete', 148, '2013-11-15 10:25:42', '', '127.0.0.1'),
(13, 2, 'answer', 'add', 214, '2013-11-15 10:32:17', 'bla', '127.0.0.1'),
(14, 2, 'answer', 'delete', 214, '2013-11-15 10:32:27', '', '127.0.0.1'),
(15, 2, 'question', 'add', 81, '2013-11-17 09:31:30', 'habana', '127.0.0.1'),
(16, 2, 'question', 'edit', 81, '2013-11-17 09:41:16', '', '127.0.0.1'),
(17, 2, 'question', 'edit', 81, '2013-11-17 09:41:24', '', '127.0.0.1'),
(18, 2, 'question', 'delete', 81, '2013-11-17 09:43:06', '', '127.0.0.1'),
(19, 2, 'question', 'edit', 65, '2013-11-17 09:52:21', '', '127.0.0.1'),
(20, 2, 'question', 'edit', 65, '2013-11-17 09:55:27', '', '127.0.0.1'),
(21, 2, 'question', 'edit', 65, '2013-11-17 09:59:22', '', '127.0.0.1'),
(22, 2, 'question', 'edit', 65, '2013-11-17 10:00:21', '', '127.0.0.1'),
(23, 2, 'quiz', 'add', 4, '2013-11-17 20:21:04', 'dsadsa', '127.0.0.1'),
(24, 2, 'quiz', 'add', 3, '2013-11-18 21:24:58', '', '127.0.0.1'),
(25, 2, 'quiz', 'add', 4, '2013-11-18 21:26:58', '', '127.0.0.1'),
(26, 2, 'quiz', 'add', 5, '2013-11-18 21:27:50', '', '127.0.0.1'),
(27, 2, 'quiz', 'add', 6, '2013-11-19 06:11:18', '', '127.0.0.1'),
(28, 2, 'quiz', 'add', 7, '2013-11-19 06:16:29', '', '127.0.0.1'),
(29, 2, 'quiz', 'add', 8, '2013-11-19 06:16:37', '', '127.0.0.1'),
(30, 2, 'quiz', 'add', 9, '2013-11-19 06:18:18', '', '127.0.0.1'),
(31, 2, 'quiz', 'add', 10, '2013-11-19 06:18:27', '', '127.0.0.1'),
(32, 2, 'quiz', 'add', 11, '2013-11-19 19:05:46', '', '127.0.0.1'),
(33, 2, 'quiz', 'add', 5, '2013-11-19 19:05:59', 'hmm', '127.0.0.1'),
(34, 2, 'quiz', 'delete', 5, '2013-11-19 19:14:49', '', '127.0.0.1'),
(35, 2, 'quiz', 'delete', 2, '2013-11-19 19:14:52', '', '127.0.0.1'),
(36, 2, 'quiz', 'add', 12, '2013-11-19 19:19:08', '', '127.0.0.1'),
(37, 2, 'quiz', 'add', 13, '2013-11-19 19:19:12', '', '127.0.0.1'),
(38, 2, 'quiz', 'add', 14, '2013-11-19 19:19:21', '', '127.0.0.1'),
(39, 2, 'quiz', 'add', 15, '2013-11-19 19:19:31', '', '127.0.0.1');
=======
(4, 2, 'question', 'edit', 19, '2013-11-13 11:18:43', '', '127.0.0.1');
>>>>>>> master

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
