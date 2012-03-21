-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost
-- Üretim Zamanı: 21 Mar 2012, 15:12:33
-- Sunucu sürümü: 5.5.16
-- PHP Sürümü: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `portapp`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `attribute`
--

CREATE TABLE IF NOT EXISTS `attribute` (
  `attributeId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `attributegroupId` int(11) unsigned NOT NULL,
  `attributeCode` varchar(255) DEFAULT NULL,
  `color` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`attributeId`),
  KEY `attributegroupId` (`attributegroupId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Tablo döküm verisi `attribute`
--

INSERT INTO `attribute` (`attributeId`, `attributegroupId`, `attributeCode`, `color`) VALUES
(1, 4, 'de', '#ff0000'),
(3, 4, 'ed', '#0000ff'),
(4, 4, NULL, '#000000'),
(5, 3, NULL, NULL),
(6, 3, NULL, NULL),
(7, 4, NULL, NULL),
(8, 4, NULL, NULL),
(9, 4, NULL, NULL),
(10, 4, NULL, NULL),
(11, 4, NULL, NULL),
(12, 3, NULL, NULL),
(13, 3, NULL, NULL),
(14, 4, NULL, 'abc'),
(15, 4, NULL, 'abc'),
(16, 4, NULL, 'abc'),
(17, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `attributegroup`
--

CREATE TABLE IF NOT EXISTS `attributegroup` (
  `attributegroupId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `isColorgroup` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`attributegroupId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Tablo döküm verisi `attributegroup`
--

INSERT INTO `attributegroup` (`attributegroupId`, `isColorgroup`) VALUES
(3, NULL),
(4, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `attributegroup_i18n`
--

CREATE TABLE IF NOT EXISTS `attributegroup_i18n` (
  `attributegroupId` int(11) unsigned NOT NULL,
  `iso639Id` int(11) unsigned NOT NULL,
  `attributegroupTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`attributegroupId`,`iso639Id`),
  KEY `iso639Id` (`iso639Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `attributegroup_i18n`
--

INSERT INTO `attributegroup_i18n` (`attributegroupId`, `iso639Id`, `attributegroupTitle`) VALUES
(3, 1, 'Beden'),
(3, 2, ''),
(4, 1, 'Renk'),
(4, 2, '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `attributeimpact`
--

CREATE TABLE IF NOT EXISTS `attributeimpact` (
  `attributeimpactId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `productId` int(11) unsigned NOT NULL,
  `attributeId` int(11) unsigned NOT NULL,
  `attributeimpactWeightRate` float unsigned DEFAULT NULL,
  `attributeimpactWeightPrice` decimal(17,2) unsigned DEFAULT NULL,
  `attributeimpactDiscountRate` float unsigned DEFAULT NULL,
  `attributeimpactDiscountPrice` decimal(17,2) unsigned DEFAULT NULL,
  PRIMARY KEY (`attributeimpactId`),
  UNIQUE KEY `productId` (`productId`,`attributeId`) USING BTREE,
  KEY `attributeId` (`attributeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `attribute_i18n`
--

CREATE TABLE IF NOT EXISTS `attribute_i18n` (
  `attributeId` int(11) unsigned NOT NULL,
  `iso639Id` int(11) unsigned NOT NULL,
  `attributeTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`attributeId`,`iso639Id`),
  KEY `iso639Id` (`iso639Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `attribute_i18n`
--

INSERT INTO `attribute_i18n` (`attributeId`, `iso639Id`, `attributeTitle`) VALUES
(1, 1, 'Kırmızı'),
(1, 2, 'red'),
(3, 1, 'Mavi'),
(3, 2, 'blue'),
(4, 1, 'Siyah'),
(4, 2, ''),
(5, 1, '38'),
(5, 2, ''),
(6, 1, '40'),
(6, 2, ''),
(7, 1, 'Saks'),
(7, 2, ''),
(8, 1, 'Kemik'),
(8, 2, ''),
(9, 1, 'Yeşil'),
(9, 2, ''),
(10, 1, 'Fuşya'),
(10, 2, ''),
(11, 1, 'Petrol'),
(11, 2, ''),
(12, 1, '42'),
(12, 2, ''),
(13, 1, '44'),
(13, 2, ''),
(14, 1, 'Mürdüm'),
(14, 2, ''),
(15, 1, 'Füme'),
(15, 2, ''),
(16, 1, 'Lacivert'),
(16, 2, ''),
(17, 1, 'Mor'),
(17, 2, '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bank`
--

CREATE TABLE IF NOT EXISTS `bank` (
  `bankCode` varchar(5) NOT NULL,
  `bankTitle` varchar(255) NOT NULL,
  PRIMARY KEY (`bankCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `bank`
--

INSERT INTO `bank` (`bankCode`, `bankTitle`) VALUES
('0010', 'Ziraat bank.'),
('0012', 'Halk bank.'),
('0015', 'Vakıf Bank'),
('0032', 'T.E.B'),
('0046', 'Akbank'),
('0056', 'Fortis'),
('0059', 'Şekerbank'),
('0062', 'Garanti Bankası'),
('0064', 'İş bankası'),
('0067', 'Yapı kredi'),
('0071', 'Dış ticaret'),
('0092', 'Citibank'),
('0096', 'TurkishBank'),
('0099', 'ING - Oyakbank'),
('0103', 'Bankeuropa'),
('0108', 'Turkland Bank'),
('0109', 'Tesktil Bank'),
('0111', 'Finansbank'),
('0123', 'HSBC'),
('0125', 'Tekfen Bank'),
('0134', 'Denizbank'),
('0135', 'AnadoluBank'),
('0203', 'Albarakaturk'),
('0204', 'FamilyFinans'),
('0205', 'Kuveyttürk'),
('0208', 'Asya Finans'),
('0900', 'AKK turizm');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bankbin`
--

CREATE TABLE IF NOT EXISTS `bankbin` (
  `bankbinId` int(11) NOT NULL AUTO_INCREMENT,
  `bankCode` varchar(5) DEFAULT NULL,
  `bankCode2` varchar(5) DEFAULT NULL,
  `bankbinBin` varchar(6) DEFAULT NULL,
  `bankbinTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`bankbinId`),
  KEY `bankCode` (`bankCode`),
  KEY `bankCode2` (`bankCode2`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=223 ;

--
-- Tablo döküm verisi `bankbin`
--

INSERT INTO `bankbin` (`bankbinId`, `bankCode`, `bankCode2`, `bankbinBin`, `bankbinTitle`) VALUES
(1, '0062', '0062', '605036', 'GARANTI '),
(2, '0062', '0062', '540669', 'MASTER  '),
(3, '0062', '0062', '520922', 'MASTER  '),
(4, '0062', '0062', '544294', 'MASTER  '),
(5, '0062', '0062', '540709', 'MASTER  '),
(6, '0062', '0062', '474151', 'VISA    '),
(7, '0062', '0062', '487074', 'VISA    '),
(8, '0062', '0062', '487075', 'VISA    '),
(9, '0062', '0062', '426889', 'VISA    '),
(10, '0062', '0062', '426886', 'VISA    '),
(11, '0062', '0062', '426887', 'VISA    '),
(12, '0062', '0062', '426888', 'VISA    '),
(13, '0062', '0062', '420557', 'VISA    '),
(14, '0062', '0062', '420556', 'VISA    '),
(15, '0062', '0062', '404308', 'VISA    '),
(16, '0062', '0062', '528939', 'MASTER  '),
(17, '0062', '0062', '520988', 'MASTER  '),
(18, '0062', '0062', '520940', 'MASTER  '),
(19, '0062', '0062', '534261', 'MASTER  '),
(20, '0062', '0062', '401738', 'VISA    '),
(21, '0062', '0062', '403666', 'VISA    '),
(22, '0062', '0062', '403280', 'VISA    '),
(23, '0062', '0062', '427315', 'VISA    '),
(24, '0062', '0062', '427314', 'VISA    '),
(25, '0062', '0062', '448472', 'VISA    '),
(26, '0062', '0062', '428968', 'VISA    '),
(27, '0062', '0062', '428967', 'VISA    '),
(28, '0062', '0062', '490175', 'VISA    '),
(29, '0062', '0062', '467295', 'VISA    '),
(30, '0062', '0062', '467294', 'VISA    '),
(31, '0062', '0062', '467293', 'VISA    '),
(32, '0062', '0062', '461668', 'VISA    '),
(33, '0062', '0062', '493845', 'VISA    '),
(34, '0062', '0062', '492193', 'VISA    '),
(35, '0062', '0062', '492187', 'VISA    '),
(36, '0062', '0062', '492186', 'VISA    '),
(37, '0062', '0062', '540037', 'MASTER  '),
(38, '0062', '0062', '540036', 'MASTER  '),
(39, '0062', '0062', '540227', 'MASTER  '),
(40, '0062', '0062', '540226', 'MASTER  '),
(41, '0062', '0062', '542030', 'MASTER  '),
(42, '0062', '0062', '545102', 'MASTER  '),
(43, '0062', '0062', '544078', 'MASTER  '),
(44, '0062', '0062', '552095', 'MASTER  '),
(45, '0062', '0062', '558699', 'MASTER  '),
(46, '0062', '0062', '554796', 'MASTER  '),
(47, '0062', '0062', '557023', 'MASTER  '),
(48, '0062', '0062', '554960', 'MASTER  '),
(49, '0062', '0062', '589318', 'MASTER  '),
(50, '0062', '0062', '541858', 'MASTER  '),
(51, '0062', '0062', '479324', 'VISA    '),
(52, '0062', '0062', '479323', 'VISA    '),
(53, '0062', '0062', '603614', 'MASTER  '),
(54, '0062', '0062', '603492', 'GARANTI '),
(55, '0062', '0062', '603480', 'GARANTI '),
(56, '0062', '0062', '642010', 'GARANTI '),
(57, '0062', '0062', '642011', 'GARANTI '),
(58, '0062', '0062', '676283', 'MASTER  '),
(59, '0062', '0062', '676255', 'MASTER  '),
(60, '0062', '0062', '676827', 'MASTER  '),
(61, '0062', '0062', '375622', 'AMEX    '),
(62, '0062', '0062', '375623', 'AMEX    '),
(63, '0062', '0062', '375624', 'AMEX    '),
(64, '0062', '0062', '375625', 'AMEX    '),
(65, '0062', '0062', '375626', 'AMEX    '),
(66, '0062', '0062', '375627', 'AMEX    '),
(67, '0062', '0062', '375628', 'AMEX    '),
(68, '0062', '0062', '375629', 'AMEX    '),
(69, '0062', '0062', '374422', 'AMEX    '),
(70, '0062', '0062', '374424', 'AMEX    '),
(71, '0062', '0062', '462274', 'VISA    '),
(72, '0062', '0062', '602970', 'GARANTI '),
(73, '0062', '0062', '405051', 'VISA    '),
(74, '0062', '0062', '724365', 'VISA    '),
(75, '0062', '0062', '514915', 'MASTER  '),
(76, '0062', '0062', '521824', 'MASTER  '),
(77, '0062', '0062', '521825', 'MASTER  '),
(78, '0062', '0062', '521832', 'MASTER  '),
(79, '0062', '0062', '410141', 'VISA    '),
(80, '0062', '0062', '413836', 'VISA    '),
(81, '0062', '0062', '405090', 'VISA    '),
(82, '0062', '0062', '553130', 'MASTER  '),
(83, '0062', '0062', '428220', 'VISA    '),
(84, '0062', '0062', '428221', 'VISA    '),
(85, '0062', '0062', '482489', 'VISA    '),
(86, '0062', '0062', '482490', 'VISA    '),
(87, '0062', '0062', '482491', 'VISA    '),
(88, '0062', '0062', '489478', 'VISA    '),
(89, '0062', '0062', '533169', 'MASTER  '),
(90, '0062', '0062', '472914', 'VISA    '),
(91, '0062', '0062', '489456', 'VISA    '),
(92, '0062', '0062', '489457', 'VISA    '),
(93, '0062', '0062', '489458', 'VISA    '),
(94, '0062', '0062', '546764', 'MASTER  '),
(95, '0062', '0134', '520303', 'MasterCard Bonus Sanal '),
(96, '0062', '0134', '520019', 'MasterCard Bonus '),
(97, '0062', '0134', '409070', 'Visa Bonus '),
(98, '0062', '0134', '510118', 'MasterCard Bonus Business '),
(99, '0062', '0134', '424360', 'Visa Bonus Plus '),
(100, '0062', '0134', '424361', 'Visa Bonus Premium '),
(101, '0062', '0134', '489457', 'Visa – IDO BONUS GOLD'),
(102, '0062', '0134', '489458', 'Visa – BONUS PLATINUM'),
(103, '0062', '0032', '440293', 'Visa Bonus '),
(104, '0062', '0032', '402458', 'Visa Bonus Plus '),
(105, '0062', '0032', '402459', 'Visa Bonus Premium '),
(106, '0062', '0032', '406015', 'Visa Bonus Plus'),
(107, '0062', '0032', '512803', 'MasterCard Bonus '),
(108, '0062', '0032', '524839', 'MasterCard Bonus Plus '),
(109, '0062', '0032', '524840', 'MasterCard Bonus Premium '),
(110, '0062', '0032', '528920', 'MasterCard Bonus Platinum'),
(111, '0062', '0032', '510221', 'MasterCard Bonus Sanal '),
(112, '0062', '0032', '553090', 'MasterCard Bonus Business '),
(113, '0062', '0032', '545124', 'MasterCard-World Signia'),
(114, '0062', '0032', '489494', 'VISA Bonus Sanal'),
(115, '0062', '0032', '512753', 'MasterCard Gold'),
(116, '0062', '0032', '524346', 'MasterCard Platinum'),
(117, '0062', '0032', '530853', 'MasterCard Bonus '),
(118, '0062', '0032', '489495', 'Visa Bonus Platinum'),
(119, '0062', '0032', '489496', 'Visa Bonus Business Platinum'),
(120, '0062', '0032', '459026', 'Visa Bonus Business Standart'),
(121, '0062', '0059', '411156', 'Visa Bonus Classic'),
(122, '0062', '0059', '411157', 'Visa Bonus Gold'),
(123, '0062', '0059', '411158', 'Visa Bonus Platinum'),
(124, '0062', '0059', '411159', 'Visa Bonus Business'),
(125, '0062', '0059', '549208', 'MasterCard Bonus Standart'),
(126, '0062', '0059', '530866', 'MasterCard Bonus Gold'),
(127, '0062', '0059', '521394', 'MasterCard Bonus Platinum'),
(128, '0062', '0059', '547311', 'MasterCard Bonus Business '),
(129, '0062', '0099', '420322', 'VISA'),
(130, '0062', '0099', '420323', 'VISA'),
(131, '0062', '0099', '420324', 'VISA'),
(132, '0062', '0099', '408579', 'VISA'),
(133, '0062', '0099', '480296', 'VISA'),
(134, '0062', '0099', '400684', 'VISA'),
(135, '0062', '0099', '510151', 'MASTER '),
(136, '0062', '0099', '532443', 'MASTER '),
(137, '0062', '0099', '542967', 'MASTER '),
(138, '0062', '0099', '542965', 'MASTER '),
(139, '0062', '0099', '554570', 'MASTER '),
(140, '0062', '0099', '547765', 'MASTER '),
(141, '0062', '0111', '549294', 'MASTER '),
(142, '0062', '0111', '428462', 'VISA'),
(143, '0062', '0062', '520097', 'Mastercard'),
(144, '0062', '0062', '522204', 'Mastercard'),
(145, '0062', '0062', '528956', 'Mastercard'),
(146, '0062', '0134', '520019', 'Mastercard'),
(147, '0062', '0134', '512017', 'Mastercard'),
(148, '0062', '0134', '512117', 'Mastercard'),
(149, '0046', '0046', '413252', 'AXESS VİSA PLATİNUM'),
(150, '0046', '0046', '435508', 'AXESS VİSA KLASİK'),
(151, '0046', '0046', '435509', 'AXESS VİSA GOLD'),
(152, '0046', '0046', '432071', 'VİSA WİNGS'),
(153, '0046', '0046', '432072', 'VİSA WİNGS (BLACK)'),
(154, '0046', '0046', '512754', 'MASTER WINGS'),
(155, '0046', '0046', '524347', 'MASTER WINGS (BLACK)'),
(156, '0046', '0046', '425669', 'WİNGS VİSA BUSİNESS'),
(157, '0046', '0046', '553056', 'WİNGS MASTER BUSİNESS'),
(158, '0046', '0046', '557113', 'AXESS KLASİK '),
(159, '0046', '0046', '520932', 'AXESS MASTER '),
(160, '0046', '0046', '557829', 'AXESS GOLD'),
(161, '0046', '0046', '521807', 'AXESS PLATİN'),
(162, '0046', '0046', '552608', 'BİZ CARD (YURTİÇİ)'),
(163, '0046', '0046', '552609', 'BİZ CARD (ENTERNASYONAL'),
(164, '0046', '0092', '450050', 'Cıtı Axess visa '),
(165, '0046', '0092', '450051', 'Cıtı Axess visa gold'),
(166, '0046', '0092', '450151', 'Cıtı Axess visa platinum'),
(167, '0046', '0092', '549220', 'Cıtı Axess MC'),
(168, '0046', '0092', '544127', 'Cıtı Axess MC gold'),
(169, '0046', '0092', '521376', 'Citi Axess MC platinum'),
(170, '0046', '0092', '450052', 'Citi Axess Platinum'),
(171, '0067', '0067', '404809', 'Yapi Kredi Bankası'),
(172, '0067', '0067', '450634', 'Yapi Kredi Bankası'),
(173, '0067', '0067', '455359', 'Yapi Kredi Bankası'),
(174, '0067', '0067', '479794', 'Yapi Kredi Bankası'),
(175, '0067', '0067', '479795', 'Yapi Kredi Bankası'),
(176, '0067', '0067', '491205', 'Yapi Kredi Bankası'),
(177, '0067', '0067', '491206', 'Yapi Kredi Bankası'),
(178, '0067', '0067', '492128', 'Yapi Kredi Bankası'),
(179, '0067', '0067', '492130', 'Yapi Kredi Bankası'),
(180, '0067', '0067', '492131', 'Yapi Kredi Bankası'),
(181, '0067', '0067', '540061', 'Yapi Kredi Bankası'),
(182, '0067', '0067', '540062', 'Yapi Kredi Bankası'),
(183, '0067', '0067', '540063', 'Yapi Kredi Bankası'),
(184, '0067', '0067', '540122', 'Yapi Kredi Bankası'),
(185, '0067', '0067', '540129', 'Yapi Kredi Bankası'),
(186, '0067', '0067', '542117', 'Yapi Kredi Bankası'),
(187, '0067', '0067', '545103', 'Yapi Kredi Bankası'),
(188, '0067', '0067', '552645', 'Yapi Kredi Bankası'),
(189, '0067', '0067', '552659', 'Yapi Kredi Bankası'),
(190, '0067', '0056', '427308', 'Fortisbank'),
(191, '0067', '0056', '438040', 'Fortisbank'),
(192, '0067', '0056', '455645', 'Fortisbank'),
(193, '0067', '0056', '549998', 'Fortisbank'),
(194, '0067', '0056', '550449', 'Fortisbank'),
(195, '0067', '0056', '552207', 'Fortisbank'),
(196, '0067', '0056', '450918', 'Fortisbank'),
(197, '0067', '0015', '493841', 'Vakıfbank'),
(198, '0067', '0015', '411979', 'Vakıfbank'),
(199, '0067', '0015', '493846', 'Vakıfbank'),
(200, '0067', '0015', '542119', 'Vakıfbank'),
(201, '0067', '0015', '540045', 'Vakıfbank'),
(202, '0067', '0015', '552101', 'Vakıfbank'),
(203, '0067', '0015', '542804', 'Vakıfbank'),
(204, '0067', '0015', '542798', 'Vakıfbank'),
(205, '0067', '0015', '540046', 'Vakıfbank'),
(206, '0067', '0015', '520017', 'Vakıfbank'),
(207, '0067', '0015', '493840', 'Vakıfbank'),
(208, '0067', '0015', '416757', 'Vakıfbank'),
(209, '0067', '0015', '411944', 'Vakıfbank'),
(210, '0067', '0015', '411943', 'Vakıfbank'),
(211, '0067', '0015', '411942', 'Vakıfbank'),
(212, '0067', '0015', '411724', 'Vakıfbank'),
(213, '0067', '0015', '409084', 'Vakıfbank'),
(214, '0067', '0015', '402940', 'Vakıfbank'),
(215, '0067', '0015', '415792', 'Vakıfbank'),
(216, '0067', '0135', '425847', 'Anadolubank'),
(217, '0067', '0135', '425846', 'Anadolubank'),
(218, '0067', '0135', '425848', 'Anadolubank'),
(219, '0067', '0135', '522240', 'Anadolubank'),
(220, '0067', '0135', '522241', 'Anadolubank'),
(221, '0067', '0135', '558593', 'Anadolubank'),
(222, '0067', '0135', '554301', 'Anadolubank');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `banner`
--

CREATE TABLE IF NOT EXISTS `banner` (
  `bannerId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `bannerTitle` varchar(255) DEFAULT NULL,
  `bannerDescription` varchar(255) DEFAULT NULL,
  `bannerStart` datetime DEFAULT NULL,
  `bannerEnd` datetime DEFAULT NULL,
  `bannerHref` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`bannerId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Tablo döküm verisi `banner`
--

INSERT INTO `banner` (`bannerId`, `bannerTitle`, `bannerDescription`, `bannerStart`, `bannerEnd`, `bannerHref`) VALUES
(1, 'Kokteyl', 'Kokteyl', '2011-09-18 21:25:00', '2012-09-18 21:25:00', NULL),
(2, 'Mezuniyet', 'Mezuniyet', '2011-09-18 21:25:00', '2012-09-18 21:25:00', 'modules/b2c/product.php?action=show&productId=3'),
(3, 'Hautecouture', 'Hautecouture', '2011-09-18 21:25:00', '2012-09-18 21:25:00', NULL),
(4, 'Uzun Abiye', 'Uzun Abiye', '2011-09-18 21:25:00', '2012-09-18 21:25:00', NULL),
(5, 'Kısa Abiye', 'Kısa Abiye', '2011-09-18 21:25:00', '2012-09-18 21:25:00', NULL),
(6, 'Büyük Beden', 'Büyük Beden', '2011-09-18 21:25:00', '2012-09-18 21:25:00', NULL),
(7, 'Tesettür', 'Tesettür', '2011-09-18 21:25:00', '2012-09-18 21:25:00', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `banner_picture`
--

CREATE TABLE IF NOT EXISTS `banner_picture` (
  `bannerId` int(11) unsigned NOT NULL,
  `pictureId` int(11) unsigned NOT NULL,
  `isDefault` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`bannerId`,`pictureId`),
  UNIQUE KEY `bannerId` (`bannerId`,`isDefault`),
  KEY `pictureId` (`pictureId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `banner_picture`
--

INSERT INTO `banner_picture` (`bannerId`, `pictureId`, `isDefault`) VALUES
(1, 358, 1),
(2, 359, 1),
(3, 360, 1),
(4, 361, 1),
(5, 362, 1),
(6, 363, 1),
(7, 364, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `brand`
--

CREATE TABLE IF NOT EXISTS `brand` (
  `brandId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `brandCode` varchar(255) DEFAULT NULL,
  `brandTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`brandId`),
  UNIQUE KEY `brandCode` (`brandCode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `brand`
--

INSERT INTO `brand` (`brandId`, `brandCode`, `brandTitle`) VALUES
(1, '01', 'Marka1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `brand_picture`
--

CREATE TABLE IF NOT EXISTS `brand_picture` (
  `brandId` int(11) unsigned NOT NULL,
  `pictureId` int(11) unsigned NOT NULL,
  `isDefault` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`brandId`,`pictureId`),
  UNIQUE KEY `brandId` (`brandId`,`isDefault`),
  KEY `pictureId` (`pictureId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `categoryId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `categoryParent` int(11) unsigned DEFAULT NULL,
  `categoryCode` varchar(255) DEFAULT NULL,
  `categorySorting` tinyint(4) unsigned DEFAULT NULL,
  PRIMARY KEY (`categoryId`),
  UNIQUE KEY `categoryCode` (`categoryCode`),
  KEY `categoryParent` (`categoryParent`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Tablo döküm verisi `category`
--

INSERT INTO `category` (`categoryId`, `categoryParent`, `categoryCode`, `categorySorting`) VALUES
(25, NULL, NULL, NULL),
(26, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `category_i18n`
--

CREATE TABLE IF NOT EXISTS `category_i18n` (
  `categoryId` int(11) unsigned NOT NULL,
  `iso639Id` int(11) unsigned NOT NULL,
  `categoryTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`categoryId`,`iso639Id`),
  KEY `categoryi18n_ibfk_2` (`iso639Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `category_i18n`
--

INSERT INTO `category_i18n` (`categoryId`, `iso639Id`, `categoryTitle`) VALUES
(25, 1, 'Kategori1'),
(25, 2, ''),
(26, 1, 'Kategori2'),
(26, 2, '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `category_picture`
--

CREATE TABLE IF NOT EXISTS `category_picture` (
  `categoryId` int(11) unsigned NOT NULL,
  `pictureId` int(11) unsigned NOT NULL,
  `isDefault` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`categoryId`,`pictureId`),
  UNIQUE KEY `categoryId` (`categoryId`,`isDefault`),
  KEY `pictureId` (`pictureId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `companyId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `companyTax` varchar(255) DEFAULT NULL,
  `companyTitle` varchar(255) DEFAULT NULL,
  `companyPhone` varchar(255) DEFAULT NULL,
  `companyFax` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`companyId`),
  UNIQUE KEY `companyTax` (`companyTax`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `company`
--

INSERT INTO `company` (`companyId`, `companyTax`, `companyTitle`, `companyPhone`, `companyFax`) VALUES
(1, '123', 'Firma1', '1', '1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `company_picture`
--

CREATE TABLE IF NOT EXISTS `company_picture` (
  `companyId` int(11) unsigned NOT NULL,
  `pictureId` int(11) unsigned NOT NULL,
  `isDefault` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`companyId`,`pictureId`),
  UNIQUE KEY `companyId` (`companyId`,`isDefault`),
  KEY `pictureId` (`pictureId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `currency`
--

CREATE TABLE IF NOT EXISTS `currency` (
  `currencyId` int(11) NOT NULL AUTO_INCREMENT,
  `currencyTitle` varchar(32) NOT NULL,
  `currencyCode` varchar(3) NOT NULL DEFAULT '0',
  `currencySign` varchar(8) NOT NULL,
  `currencyConversionRate` decimal(13,6) unsigned NOT NULL,
  `currencyStatus` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `currencyHome` tinyint(1) unsigned DEFAULT NULL,
  `iso_code_num` varchar(3) NOT NULL DEFAULT '0',
  `blank` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `format` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `decimals` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`currencyId`),
  UNIQUE KEY `currencyCode` (`currencyCode`),
  UNIQUE KEY `currencyHome` (`currencyHome`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Tablo döküm verisi `currency`
--

INSERT INTO `currency` (`currencyId`, `currencyTitle`, `currencyCode`, `currencySign`, `currencyConversionRate`, `currencyStatus`, `currencyHome`, `iso_code_num`, `blank`, `format`, `decimals`, `deleted`) VALUES
(1, 'Turkish Lira', 'TRL', 'TL', 1.000000, 1, 1, '792', 0, 0, 1, 0),
(2, 'Dollar', 'USD', '$', 1.828800, 1, NULL, '840', 0, 1, 1, 0),
(3, 'Pound', 'GBP', '£', 2.916500, 0, NULL, '826', 0, 1, 1, 0),
(4, 'Euro', 'EUR', '€', 2.535500, 1, NULL, '978', 1, 2, 1, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `iso639`
--

CREATE TABLE IF NOT EXISTS `iso639` (
  `iso639Id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `iso639A2` varchar(2) DEFAULT NULL,
  `iso639Title` varchar(255) DEFAULT NULL,
  `iso639Status` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`iso639Id`),
  UNIQUE KEY `iso639A2` (`iso639A2`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Tablo döküm verisi `iso639`
--

INSERT INTO `iso639` (`iso639Id`, `iso639A2`, `iso639Title`, `iso639Status`) VALUES
(1, 'tr', 'Türkçe', 1),
(2, 'en', 'English', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `iso639_picture`
--

CREATE TABLE IF NOT EXISTS `iso639_picture` (
  `iso639Id` int(11) unsigned NOT NULL,
  `pictureId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`iso639Id`,`pictureId`),
  KEY `pictureId` (`pictureId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `optinout`
--

CREATE TABLE IF NOT EXISTS `optinout` (
  `optinoutId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `optinoutEmail` varchar(255) NOT NULL,
  `optinoutStatus` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`optinoutId`),
  UNIQUE KEY `optinoutEmail` (`optinoutEmail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Tablo döküm verisi `optinout`
--

INSERT INTO `optinout` (`optinoutId`, `optinoutEmail`, `optinoutStatus`) VALUES
(2, 'cemselman@yahoo.com', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `pageId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pageParent` int(11) unsigned DEFAULT NULL,
  `pageSorting` int(11) unsigned DEFAULT '1',
  `pageIsDefault` tinyint(1) unsigned DEFAULT NULL,
  `pageRedirect` char(100) NOT NULL,
  PRIMARY KEY (`pageId`),
  UNIQUE KEY `pageIsDefault` (`pageIsDefault`),
  KEY `pageParent` (`pageParent`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Tablo döküm verisi `page`
--

INSERT INTO `page` (`pageId`, `pageParent`, `pageSorting`, `pageIsDefault`, `pageRedirect`) VALUES
(1, 6, 1, NULL, ''),
(2, 6, 2, NULL, ''),
(3, 6, 3, NULL, ''),
(4, 6, 4, NULL, ''),
(5, 6, 5, NULL, ''),
(6, NULL, 1, 1, 'b2c'),
(7, NULL, 2, NULL, ''),
(8, NULL, 3, NULL, ''),
(9, NULL, 4, NULL, ''),
(10, NULL, 5, NULL, 'contact');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `page_i18n`
--

CREATE TABLE IF NOT EXISTS `page_i18n` (
  `pageId` int(11) unsigned NOT NULL,
  `iso639Id` int(11) unsigned NOT NULL,
  `pageTitle` varchar(255) DEFAULT NULL,
  `pageDescription` varchar(255) DEFAULT NULL,
  `pageContent` text,
  `pageKeywords` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pageId`,`iso639Id`),
  KEY `pagei18n_ibfk_2` (`iso639Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `page_i18n`
--

INSERT INTO `page_i18n` (`pageId`, `iso639Id`, `pageTitle`, `pageDescription`, `pageContent`, `pageKeywords`) VALUES
(1, 1, 'Teslimat Koşulları', '', '<div>\r\n	Siparişleriniz, banka onayı alındıktan sonra 3 iş g&uuml;n&uuml; (Pazartesi-Cuma) i&ccedil;erisinde kargoya teslim edilir. Teslimat adresinin uzaklığına g&ouml;re anlaşmalı olduğumuz kargo şirketi 1-3 g&uuml;n i&ccedil;erisinde siparişinizi size ulaştıracaktır.</div>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	&Ouml;zel &uuml;retim &uuml;r&uuml;nlerin teslim s&uuml;releri imalat zamanına g&ouml;re farklılık g&ouml;stermektedir. Bu t&uuml;r &uuml;r&uuml;nlerin teslimat bilgileri ve s&uuml;releri &uuml;r&uuml;n sayfalarında belirtilmiştir.</div>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	Tarafımızdan kaynaklanan bir aksilik olması halinde ise size &uuml;yelik bilgilerinizden yola &ccedil;ıkılarak haber verilecektir. Bu y&uuml;zden &uuml;yelik bilgilerinizin eksiksiz ve doğru olması &ouml;nemlidir.</div>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	Bayram ve tatil g&uuml;nlerinde teslimat yapılmamaktadır. Satın aldığınız &uuml;r&uuml;nler bir teyit e-posta&#39;sı ile tarafınıza bildirilecektir. Se&ccedil;tiğiniz &uuml;r&uuml;nlerden herhangi birinin stokta mevcut olmaması durumunda konu ile ilgili bir e-posta size yollanacak ve &uuml;r&uuml;n&uuml;n ilk stoklara gireceği tarih tarafınıza bildirilecektir.</div>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	&Ouml;demesini yaptığınız &uuml;r&uuml;n eğer stoklarımızda kalmamış ise en az 4 (D&ouml;rt) en fazla 30 (otuz) g&uuml;n bekleme s&uuml;resi vardır. &Uuml;r&uuml;n bu tarihleri arasında t&uuml;keticiye g&ouml;nderilmez ise yapılan &ouml;deme kendisine iade edilir.</div>\r\n', 'teslimat, koşullar'),
(1, 2, 'Delivery Conditions', '', '', 'delivery, conditions'),
(2, 1, 'Üyelik Sözleşmesi', '', '<p>\r\n	&nbsp;</p>\r\n<p>\r\n	<strong>&Uuml;yelik Hakkında</strong></p>\r\n<p>\r\n	Mağazamıza &uuml;ye olmak i&ccedil;in &Uuml;ye İşlemleri sayfamıza giderek ilgili b&ouml;l&uuml;mleri doldurmanız yeterlidir. &Uuml;ye bilgilerinizi doğru ve eksiksiz doldurmanız iletişim ve ulaşım problemleri olasılığı a&ccedil;ısından &ccedil;ok &ouml;nemlidir.&Uuml;r&uuml;n ve hizmetlerin &ccedil;abuk ve sıhhatli ulaşması i&ccedil;in l&uuml;tfen dikkatle ve eksiksiz doldurunuz.<br />\r\n	&Uuml;ye olmak olduk&ccedil;a basit ve hızlı bir işlemdir. &Uuml;ye olmanız hi&ccedil; bir y&uuml;k&uuml;ml&uuml;l&uuml;k altına girdiğinizi ifade etmez. Ancak alışveriş yapmadan &ouml;nce Satış s&ouml;zleşmesini dikkatle okuyunuz. Dilediğiniz zaman &uuml;yeliğinizi sonlandırma hakkına sahipsiniz.</p>\r\n<p>\r\n	<strong>&Uuml;yelik İptali</strong></p>\r\n<p>\r\n	&Uuml;ye dilediği zaman &uuml;yeliğini sonlandırma hakkına sahiptir. &Uuml;yeliğinizi sonlandırdıktan sonra sitemiz ile t&uuml;m ilişkiniz kesilmiş olacaktır. &nbsp; &Uuml;yeliğinizi sonlandırmak i&ccedil;in &uuml;ye girişi yaptıktan sonra iletişim bilgileri sayfamızdan talebinizi iletmelisiniz.<br />\r\n	<br />\r\n	Aşağıdaki Durumlarda &Uuml;yelik İptal Edilemez</p>\r\n<ol>\r\n	<li>\r\n		&Uuml;ye son verdiği sipariş &uuml;zerinden 60 g&uuml;n ge&ccedil;memişse.</li>\r\n	<li>\r\n		Farklı bir e-posta adresi ile &uuml;yelik iptal talebinde bulunulduysa</li>\r\n	<li>\r\n		&Uuml;yeye Kayıtlı bilgilerinden ulaşılamıyorsa</li>\r\n</ol>\r\n<p>\r\n	Aşağıdaki Durumlarda &Uuml;yelik Tarafımızdan İptal Edilir</p>\r\n<ol>\r\n	<li>\r\n		&Uuml;ye Ahlak dışı, mesajlar g&ouml;nderiyor ya da yorum yazıyorsa</li>\r\n	<li>\r\n		Sahtekarlık girişiminde bulunduysa</li>\r\n	<li>\r\n		Sisteme veya mağazanın ismine zarar vermeye y&ouml;nelik girişimde bulunduysa.</li>\r\n</ol>\r\n<p>\r\n	<strong>&Uuml;ye G&uuml;venliği</strong></p>\r\n<p>\r\n	&Uuml;yenin g&uuml;venliği i&ccedil;in mağazamızda her t&uuml;rl&uuml; &ouml;nlem alınmıştır. Bu alınan &ouml;nlemlerin yanında sizlerde &uuml;ye bilgilerinizin g&uuml;venliğinden sorumlusunuz. Mağazamıza giriş i&ccedil;in kullandığınız bilgilerinizi hi&ccedil; kimse ile paylaşmayın, g&uuml;venli olduğundan emin olmadığınız bilgisayarlardan sisteme giriş yapmayın.Farklı AdresHer &uuml;ye İ&ccedil;in Sipariş Sonlandırırken kendi kayıtlı adresi haricinde farklı adres girebileceği bir adres b&ouml;l&uuml;m&uuml; bulunmaktadır. Adres b&ouml;l&uuml;m&uuml;n&uuml; arkadaşlarınıza hediye g&ouml;nderirken kullanabileceğiniz gibi, farklı adreslerde olduğunuz d&ouml;nemlerde kullanabilmeniz i&ccedil;in d&uuml;ş&uuml;n&uuml;lm&uuml;şt&uuml;r.<br />\r\n	&Ouml;rneğin:&nbsp;&Ccedil;alıştığınız şirketin farklı şubelerinde bulunacağınız d&ouml;nemlerde veya yazlıkta kaldığınız d&ouml;nemlerde. Y&acirc;da faturanızın size siparişinizin bir arkadaşınıza ulaşmasını istiyorsanız</p>\r\n<p>\r\n	<strong>&Uuml;r&uuml;n Yorumları</strong></p>\r\n<p>\r\n	Her &uuml;ye &uuml;r&uuml;nlere yorum yazabilir. Bilgilerinizi ve tecr&uuml;belerinizi diğer kullanıcılarla paylaştık&ccedil;a, alışveriş daha keyifli ve bilin&ccedil;li olacaktır. M&uuml;şteri yorumları tarafsız ve tecr&uuml;beye dayalı olacağı i&ccedil;in daha bilin&ccedil;li alışveriş ortamı doğacaktır.&nbsp; &Uuml;r&uuml;n yorumu yazarken dikkat etmeniz gerekenler: Genel ahlak kuralları &ccedil;er&ccedil;evesinde, diğer kullanıcılara ve &uuml;r&uuml;n&uuml;n &uuml;reticisine saygılı yorumlar yazmaya &ouml;zen g&ouml;sterin. Yorumlar incelenerek uygun g&ouml;r&uuml;lmeyen yorumlar sistemden silinmektedir.</p>\r\n<p>\r\n	&nbsp;</p>\r\n', 'üyelik, sözleşme'),
(2, 2, 'Subscription Agreement', '', '', 'subscription, agreement'),
(3, 1, 'Satış Sözleşmesi', '', 'Tüm kullanıcılar üyelik işlemlerini gerçekleştirdikleri anda şatış sözleşmesini okuduklarını ve onayladıklarını kabul etmiş sayılırlar. Satış sözleşmesi firma ile müşteri arasındaki sanal ortamda satış sözleşmesidir.\r\n<ol>\r\n<li>\r\nİş bu sözleşmenin konusu, satıcının, alıcıya satısını yaptıı, aşaıda nitelikleri ve satış fiyatı belirtilen ürünün satısı ve teslimi ile ilgili olarak 4077 sayılı Tüketicilerin Korunması Hakkındaki Kanunun; Mesafeli Sözleşmeleri Uygulama Esas ve Usulleri Hakkında Yönetmelik hükümleri gereince tarafların hak ve yükümlülüklerinin kapsamaktadır.\r\n</li><li>\r\nSatıcı Bilgileri:<br/>\r\n[FİRMA ADI]<br/>\r\n[FİRMA POSTA ADRESİ]<br/>\r\n[FİRMA E-POSTA ADRESİ]<br/>\r\n[FİRMA TELEFON NUMARASI]<br/>\r\n</li><li>\r\nAlıcı Bilgileri:<br/>\r\nTüm üyeler: Elektronik ticaret mağazasına üye olup alışveriş yapan tüm alıcılar. (Bundan sonra alıcı veya müşteri olarak anılacaktır).\r\n</li><li>\r\nSözleşme Konusu ve Ürün Bilgileri:<br/>\r\nMal/Ürün veya Hizmetin; Türü, Miktarı, Marka/Modeli, Rengi, Adedi, Satış Bedeli ve Ödeme Sekli, sitede belirtildiği gibi olup, bu vaatler alıcıya bildirilmeden deişiklik gösterebilmektedir.\r\n</li><li>\r\nGenel Hükümler:\r\n<ol><li>\r\nALICI, Madde 4’de belirtilen sözleşme konusu ürünün temel nitelikleri, satış fiyatı ve ödeme sekli ile teslimata ilişkin tüm ön bilgileri okuyup bilgi sahibi olduğunu ve elektronik ortamda gerekli teyidi verdiğini beyan eder.\r\n</li><li>\r\nSözleşme konusu ürün, yasal 30 günlük süreyi asmamak koşulu ile her bir ürün için alicinin yerleşim yerinin uzaklığına bağlı olarak ön bilgiler içinde açıklanan süre içinde alici veya gösterdiği adresteki kişi veya kuruluşa teslim edilir.\r\n</li><li>\r\nSözleşme konusu ürün, alıcıdan başka bir kişi veya kuruluşa teslim edilecek ise, teslim edilecek kişi veya kurulusun teslimatı kabul etmemesinden dolayı SATICI sorumlu tutulamaz.\r\n</li><li>\r\nSATICI , sözlesme konusu ürünün saglam, eksiksiz, siparişte belirtilen niteliklere uygun ve varsa garanti belgeleri ve kullanim kilavuzlari ile birlikte teslim edilmesinden sorumludur.\r\n</li><li>\r\nSözleşme konusu ürünün teslimati için is bu sözlesmenin elektronik ortamda onaylanmis olmasi ve satis bedelinin alicinin tercih ettigi ödeme sekli ile ödenmis olmasi sarttir. Herhangi bir nedenle ürün bedeli ödenmez veya banka kayitlarinda iptal edilir ise, SATICI ürünün teslimi yükümlülügünden kurtulmus kabul edilir.\r\n</li><li>\r\nÜrünün tesliminden sonra aliciya ait kredi kartinin alicinin kusurundan kaynaklanmayan bir sekilde yetkisiz kisilerce haksiz veya hukuka aykiri olarak kullanilmasi nedeni ile ilgili banka veya finans kurulusun ürün bedelini SATICI ya ödememesi halinde, ALICI kendisi veya satis sözlesmesinde belirttigi kisi veya kuruma teslim edilmis olan ürünü 3 isgünü içinde SATICI ya göndermek zorundadir. Böyle bir durumda nakliye giderleri aliciya aittir.\r\n</li><li>\r\nSATICI mücbir sebepler veya nakliyeyi engelleyen hava muhalefeti, ulasimin kesilmesi gibi olaganüstü durumlar nedeni ile sözlesme konusu ürünü süresi içinde teslim edemez ise, durumu aliciya bildirmekle yükümlüdür. Bu takdirde alici siparişinin iptal edilmesini, sözlesme konusu ürünün varsa emsali ile degistirilmesini, ve/veya teslimat süresinin engelleyici durumun ortadan kalkmasina kadar ertelenmesi haklarindan birini kullanabilir. Alicinin siparişi iptal etmesi halinde, SATICI 7 gün içinde aliciya ait kredi karti fisinin iptali ve ilgili tutarin alicinin hesabina iade edilmesi konusunda ilgili banka nezdinde girisimde bulunur ve yapilan islem elektronik posta araciligi ile ALICIya bildirilir. Böyle bir durumda ilgili bankadan kaynaklanan gecikmelerden dolayi SATICI sorumlu tutulamaz.\r\n</li><li>\r\nALICI ve/veya ALICInin teslimat yapilmasi istedigi kisi ve/veya kurumlara teslim edilmis olan ürünlerin arizali veya bozuk olmasi durumunda, garanti sartlari içinde gerekli onarim veya degistirme isleminin yapilmasi için ilgili ürün veya ürünler SATICIya, ALICI tarafinin teslim aldigi tarihten baslayarak 7 gün içinde gönderilir ve nakliye giderleri SATICI tarafindan karsilanir. Böyle bir durumda 7 günlük sürenin dolmasi halinde, ALICI teslim almis oldugu ürünü ilgili servisine götürmek zorundadir.\r\n</li><li>\r\nİş bu sözlesme, alici tarafindan elektronik olarak onaylandiktan (üyelik gerçeklestirildikten) sonra geçerlilik kazanir.\r\n</li></ol>\r\n</li><li>\r\nCayma Hakkı:<br/>\r\nAlici, sözlesme konusu ürürünün kendisine veya gösterdigi adresteki kisi/kurulusa tesliminden itibaren yedi (7) gün içinde cayma hakkina sahiptir. Cayma hakkinin kullanilabilmesi için bu süre içinde SATICIya faks veya elektronik posta ile bildirimde bulunulmasi ve ürünün 7. madde hükümleri çerçevesinde kullanilmamis ve ambalajinin zarar görmemis olmasi sarttir. Bu hakkin kullanilmasi halinde, 3. kisiye veya Aliciya teslim edilen ürünün SATICIya gönderildigine dair kargo teslim tutanagi örnegi ile satis faturasi aslinin iadesi zorunludur. Bu belgelerin ulasmasini takip eden 7 gün içinde ürün bedelinin ALICInin kredi karti hesabina iade edilmesi için SATICI ilgili banka nezdinde girisimde bulunur. Ürün bedelinin iadesinde banka tarafindaki aksakliklardan dolayi SATICI sorumlu tutulamaz. Satış faturasinin aslinin gönderilmemesi durumunda katma deger vergisi ve varsa diger yasal yükümlülükler iade edilmez. Cayma hakki nedeni ile iade edilen ürünün kargo bedeli ALICIya aittir. Ayrica, niteligi itibariyla iade edilemeyecek ürünler, tek kullanimlik ürünler, kopyalanabilir yazilim ve programlar, hizli bozulan veya son kullanim tarihi geçen ürünler için cayma hakki kullanılamaz. Her türlü yazilim ve programlar, DVD, VCD, CD ve kasetler, Bilgisayar ve kirtasiye sarf malzemeleri (toner, kartus, serit v.b) ve Hür türlü kozmetik ürünlerinde cayma hakkinin kullanilmasi, ürünün ambalajinin açilmamis, bozulmamis ve ürünün kullanilmamis olmasi sartina baglidir.\r\n</li><li>\r\nYetkili Mahkeme:<br/>\r\nİş bu sözlesmenin uygulanmasında, Sanayi ve Ticaret Bakanlığınca ilan edilen değere kadar Tüketici Hakem Heyetleri ile ALICInın veya SATICInın yerleşim yerindeki TÜKETİCİ MAHKEMELERI yetkilidir. Siparişin elektronik ortamda onaylanmasi durumunda, ALICI is bu sözlesmenin tüm hükümlerini kabul etmiş sayılır.\r\n</li>\r\n</ol>', ''),
(3, 2, 'Sales Agreement', '', '', ''),
(4, 1, 'Garanti ve İade Koşulları', '', '<p>\r\n	&nbsp;</p>\r\n<p>\r\n	<strong>Garanti Koşulları</strong></p>\r\n<p>\r\n	T&uuml;m &uuml;r&uuml;nler aksi belirtilmediği takdirde &uuml;retici firmaların garantisi altındadır. Garanti koşullarının ge&ccedil;erli olabilmesi i&ccedil;in kargo teslimatı esnasında &uuml;r&uuml;n&uuml; mutlaka kontrol ediniz. Herhangi bir hasar g&ouml;rd&uuml;ğ&uuml;n&uuml;zde tutanak tutturarak &uuml;r&uuml;n&uuml; teslim almayınız. &Uuml;r&uuml;n &uuml;zerinde yapılan değişiklikler,&uuml;r&uuml;n&uuml;n deforme olması ya da &uuml;r&uuml;n&uuml;n orijinal dizaynının bozulması garanti kapsamı dışındadır.</p>\r\n<p>\r\n	<strong>&Uuml;r&uuml;n İade Koşulları</strong></p>\r\n<p>\r\n	Sitemiz &uuml;zerinden satın aldığınız &uuml;r&uuml;n&uuml;n hatalı &ccedil;ıkması halinde teslimat tarihinden itibaren en ge&ccedil; 7 g&uuml;n i&ccedil;erisinde sayfamızdaki online destek b&ouml;l&uuml;m&uuml;nden bizimle iletişim kurmanız gerekmektedir. Bu bilgileri takiben kargo şirketi ile bize ulaştıracağınız hatalı &uuml;r&uuml;n yenisi ile değiştirilecektir. Sipariş edilen &uuml;r&uuml;n hatası m&uuml;şteri kullanımından oluşmuşsa veya 7 g&uuml;nl&uuml;k s&uuml;re i&ccedil;erisinde &uuml;r&uuml;n kullanılmışsa &uuml;r&uuml;n&uuml;n iade ve değişimi yapılmaz. &Uuml;r&uuml;n iadesi ve değiştirme şartları olarak, 4077 sayılı T&uuml;keticinin Korunması Hakkında Kanun gereği uygulamalar esastır.</p>\r\n', 'garanti'),
(4, 2, 'Warranty Conditions', '', '', 'warranty'),
(5, 1, 'Gizlilik ve Güvenlik', '', '<p>\r\n	&nbsp;</p>\r\n<p>\r\n	M&uuml;şterilerimizin g&uuml;venliğine &ccedil;ok &ouml;nem vermekteyiz. Kullanıcılara ait kişisel ve gizli bilgilerin t&uuml;m&uuml;, g&uuml;venli elektronik sistemlerde standartlara uygun olarak saklanmaktadır. Firmamız, en gelişmiş g&uuml;venlik sistemleri ile korunmakta ve alışveriş yapanlar i&ccedil;in y&uuml;zde y&uuml;z g&uuml;venlik sağlamaktadır. Firmamız &uuml;yelerinin kişisel bilgilerine, kredi kartı verilerine ve t&uuml;m diğer hassas bilgilerine Firmamız personeli de dahil olmak &uuml;zere, hi&ccedil;bir &uuml;&ccedil;&uuml;nc&uuml; şahıs, izinli veya izinsiz erişemez. Bu &ccedil;er&ccedil;evede en son g&uuml;venlik teknolojisi olan SSL ve SET metotlarını kullanmaktadır. SET ve SSL ile daha detaylı bilgilere aşağıdan ulaşabilirsiniz.&nbsp;<br />\r\n	<br />\r\n	Mağazamızdan ayrılırken mutlaka &uuml;ye işlemleri altındaki G&uuml;venli &Ccedil;ıkışı tıkladıktan sonra terk edin. G&uuml;venli &ccedil;ıkış yapmadan aynı pencerede başka sayfa g&ouml;r&uuml;nt&uuml;lemeyin.&nbsp;<br />\r\n	<br />\r\n	Elektronik Ticaret, &uuml;r&uuml;n, hizmet ya da bilginin satılması ve satın alınması s&uuml;recini kapsayan ticari işlemlerin internet &uuml;zerinden ger&ccedil;ekleştirilmesidir. İnternet gibi herkese a&ccedil;ık a ortamlarında dolaşan hassas bilgilerin, k&ouml;t&uuml; niyetli kişilerin eline ge&ccedil;mesine engel olmak i&ccedil;in her &ouml;deme sisteminin, g&uuml;venlikle ilgili olarak yerine getirmesi gereken bazı zorunluluklar vardır.</p>\r\n<p>\r\n	Bunların başlıcaları;</p>\r\n<p>\r\n	Gizlilik (Confidentiality):İşlem bilgilerinin &uuml;&ccedil;&uuml;nc&uuml; partiler tarafından değil sadece doğru kişi yada kuruluş tarafından g&ouml;r&uuml;lebilmesi.&nbsp;&Ouml;rnek: Kredi kartı numarasının başkaları tarafından ele ge&ccedil;irilmesine engel olmak.&nbsp;<br />\r\n	<br />\r\n	Bilgi b&uuml;t&uuml;nl&uuml;ğ&uuml; (Integrity of data):Bilginin kaynağında &uuml;retildiği şekliyle, değişmeden alıcıya ulaşmasını sağlamak. &Ouml;rnek: Satın alma bedeli gibi , alınan &uuml;r&uuml;n yada hizmete ilişkin &ouml;deme bilgilerin değiştirilmemesi.&nbsp;<br />\r\n	<br />\r\n	Kimliğin kanıtlanması (Authentication):Kredi kartının ge&ccedil;erliliğinin , kart sahibi ve mağazanın kimliklerinin doğrulunu kanıtlanması. &Ouml;rnek: Kredi kartı bilgilerinin g&ouml;nderen kişinin kart sahibi olduğunun doğrulanması.&nbsp;&nbsp;<br />\r\n	<br />\r\n	İnkar edememe (Non-repudiation):&nbsp;Alıcının yada satıcının, yaptığı işlem sonrası, o işlemi yaptığını inkar edememesi olarak &ouml;zetlenebilir.&nbsp;<br />\r\n	<br />\r\n	SSL (Secure Sockets Layer):SSL, web &uuml;zerindeki iletişim g&uuml;venliği i&ccedil;in kullanılan ve bilgi transferinin gizliliğini ve b&uuml;t&uuml;nl&uuml;ğ&uuml;n&uuml; sağlayan g&uuml;venlik protokol&uuml;d&uuml;r. Web siteleri ve tarayıcılar tarafından yaygın olarak desteklenen SSL, m&uuml;şteri ve mağaza arasındaki mesajların şifrelenmesini ve sadece doru adreste deşifre edilmesini salar.&nbsp;<br />\r\n	<br />\r\n	Netscape Communications Corporation tarafından geliştirilen SSL teknolojisinde hem istemci (bilgi alan) hem de sunucu (bilgi g&ouml;nderen) bilgisayarda bir doğrulama (authentication, iki bilgisayarın karşılıklı olarak birbirini tanıması) mekanizması kullanılır.&nbsp;&nbsp;<br />\r\n	<br />\r\n	SSL , bir internet işleminde rol alan partilerin kimliklerinin doğruluğunu kanıtlamak i&ccedil;in dijital sertifikalar kullanmaktadır. Dijital sertifika sahibi, kendisine g&ouml;nderilecek mesajı şifrelemesi i&ccedil;in diğer partiye sertifikası ile birlikte şifreleme anahtarını g&ouml;nderir. Sertifika ile g&ouml;nderilen anahtar ile şifrelenen mesaj ancak sertifika sahibi tarafından deşifre edilebileceğinden mesajın doğru kişi tarafından okunması sağlanır.&nbsp;&nbsp;<br />\r\n	<br />\r\n	SSL, şifreleme sistemi olarak A&ccedil;ık Anahtar Şifreleme Y&ouml;ntemini kullanır. Bu y&ouml;ntem sayesinde SSL web &uuml;zerindeki iletişimde hem transfer edilen bilginin gizliliğini ve b&uuml;t&uuml;nl&uuml;ğ&uuml;n&uuml; sağlamakta , hem de istemci ve sunucunun kimliklerini doğrulamaktadır. Ancak SSL, işlemi ger&ccedil;ekleştiren kişinin kredi kartı sahibi olduğunu kanıtlayamamakta ve mağazanın kredi kartı bilgilerine girişini engelleyememektedir.&nbsp;<br />\r\n	<br />\r\n	SET (Secure Electronic Transaction):Internet &uuml;zerinden kredi kartı ile yapılan &ouml;deme sistemleri arasında t&uuml;m d&uuml;nyanın kabul ettiği mevcut en g&uuml;venli standart olan SET protokol&uuml;, Visa ve Mastercardın i&ccedil;inde bulunduğu bir konsorsiyum tarafından elektronik ticarette g&uuml;venliği sağlamak amacıyla geliştirilmiştir ve bir end&uuml;stri standardı haline gelmiştir.&nbsp;<br />\r\n	<br />\r\n	A&ccedil;ık Anahtar Şifrelemesini (Public Key Cryptography) ve DES (Data Encryption Standard), RSA (Rivest, Shamir, Adleman) şifreleme metotlarının birleşimini kullanan SET protokol&uuml;nde alışveriş, sanal c&uuml;zdan ve sertifika aracılığı ile daha g&uuml;venli bir ortamda ger&ccedil;ekleştirilir.&nbsp;<br />\r\n	<br />\r\n	SET, alışveriş işlemi sırasında &ouml;deme bilgisi gizliliğini ve b&uuml;t&uuml;nl&uuml;ğ&uuml;n&uuml;, kart kullanıcısının ger&ccedil;ek kart sahibi olduğunu ve işyerinin banka ile anlaşmalı bir işyeri olduğunu garantiler.&nbsp;Kredi kartı sahibi ve mağazanın yanı sıra kartın ait olduğu banka (issuer bank) ve POSun ait olduu banka (acquirer bank)yı da kapsadığından u&ccedil;tan uca &ouml;deme protokol&uuml; olarak kabul edilen SET , online işlemlerde rol alan t&uuml;m partilerin doğruluğunu kanıtlamaktadır. Aynı zamanda kredi kartı ve sipariş bilgileri farklı olarak şifrelendiğinden kredi kartı bilgilerinin mağaza tarafından g&ouml;r&uuml;lmesi engellenmektedir.&nbsp;<br />\r\n	<br />\r\n	Veri gizliliğinin korunması:&nbsp;Veri gizliliği a&ccedil;ık anahtar kriptografisi kullanılarak yapılan şifreleme ile sağlanmaktadır. Mesajı okuyacak parti , mesajı şifreleyecek tarafa a&ccedil;ık anahtarını (public key) g&ouml;nderir. Mesajın g&ouml;nderileceği partinin a&ccedil;ık anahtarı ile şifrelenen mesaj yalnızca mesajı alan partinin sahip olduğu ilgili kapalı anahtarla (private key) deşifre edilebilmektedir.&nbsp;<br />\r\n	<br />\r\n	Veri b&uuml;t&uuml;nl&uuml;ğ&uuml;n&uuml;n korunması:&nbsp;Mesaj , &ouml;zetlenmek (message digest) &uuml;zere daha &ouml;nce belirlenmiş sabit bir uzunlukta yeniden işlenir (hash) ve şifrelenir. Mesajı alan parti orijinal mesajı deşifre edip aynı sabit uzunlukta işledikten sonra deşifre ettiği mesaj &ouml;zeti ile karşılaştırır. Her iki &ouml;zetin aynı olması halinde verinin b&uuml;t&uuml;nl&uuml;ğ&uuml;n&uuml;n korunduğu kanıtlanır.&nbsp;<br />\r\n	<br />\r\n	İşleme katılan diğer partilerin kimliklerinin doğrulanması:&nbsp;İşleme katılan diğer partilerin kimliklerinin doğrulanması bir &quot;g&uuml;ven hiyerarşisi&quot; gerektirmektedir. SET protokol&uuml; , sertifika y&ouml;netimini desteklemek i&ccedil;in bu g&uuml;ven hiyerarşisini tanımlamıştır. Dijital sertifika, g&uuml;ven zincirinin bir &uuml;st seviyesindeki otorite tarafından &uuml;retilen bir dijital imzadır. Dijital sertifikalar, partilerin doğruluğunu kanıtlamakta kullanılmaktadır.</p>\r\n', 'güvenlik'),
(5, 2, 'Secure Shopping', '', '', 'security'),
(6, 1, 'Ana Sayfa', NULL, NULL, NULL),
(6, 2, 'Home', NULL, NULL, NULL),
(7, 1, 'Müşteri Hizmetleri', NULL, 'Alışverişinizin her aşamasında, kendinizi güvende hissedebilmeniz için en çok merak edilen konuları ve sıkça sorulan soruları size yardımcı olabilmek amacıyla aşağıda listeledik. Dilerseniz <a href="modules/contact/">iletişim formu</a>ndan bize ulaşabilirsiniz.\r\n\r\n<h4>Siparişim Ulaşmadı</h4>\r\nSiparişiniz ulaşmadıysa sipariş kodunuzla birlikte <a href="modules/contact/">iletişim formu</a>ndan bize ulaşabilirsiniz.\r\n', NULL),
(7, 2, 'Customer Services', NULL, NULL, NULL),
(8, 1, 'Sıkça Sorulan Sorular', '', '<p>\r\n	&nbsp;</p>\r\n<ol>\r\n	<li>\r\n		Nasıl alışveriş yaparım?<br />\r\n		Sitemizden alışveriş yapmak i&ccedil;in &ouml;ncelikle &uuml;ye olmanız gerekmektedir. &Uuml;yeliğinizi ana sayfamızdaki &quot;&Uuml;ye Kayıt&quot; linkini kullanarak yapabilirsiniz. &Uuml;ye girişi yaptıktan sonra satın almak istediğiniz &uuml;r&uuml;nleri &uuml;r&uuml;n sayfalarında bulunan &quot;sepete at&quot; butonunu kullanarak alışveriş sepetinize dilediğiniz kadar &uuml;r&uuml;n&uuml;, mevcut stoğu ge&ccedil;meyecek adette sepetinize atabilirsiniz. Satın almak istediğiniz t&uuml;m &uuml;r&uuml;nleri sepetinize attıktan sonra, alışveriş sepetim sayfasına giderek kontrok edebilir ve sipariş vermek i&ccedil;in &quot;satın al&quot; butonunu kullanarak bir sonraki aşamaya ge&ccedil;ebilirsiniz. Siparişinizi oluştururken; &ouml;ncelikle fatura ve teslimat bilgilerinizi girmeniz, &ouml;deme tipinizi se&ccedil;erek, g&uuml;venli &ouml;deme sayfasında &ouml;deme işleminizi tamamlamanız ve siparişinizi onaylamanız gerekmektedir.</li>\r\n	<li>\r\n		Parolamı unuttum, ne yapmalıyım?<br />\r\n		&quot;Parolamı Unuttum&quot; linkine tıklayarak&nbsp;<a href="modules/b2c/reminder.php">parola yenileme sayfası</a>na gidip &uuml;ye olduğunuz e-posta adresinizi girerek yeni şifrenizin &uuml;ye olduğunuz e-posta adresine g&ouml;nderilmesini sağlayabilirsiniz.</li>\r\n	<li>\r\n		Kayıt sırasında TC Kimlik numaramı neden girmek zorundayım?<br />\r\n		29/08/2006 tarihli, 26274 sayili Resmi Gazetede teblig edildigi &uuml;zere 1/1/2007 tarihinden itibaren kesilen faturalarda T.C. Kimlik Numarasi yazma zorunlulugu getirilmistir.&nbsp;<a href="http://tckimlik.nvi.gov.tr/" target="_blank">T.C. Kimlik Numaranizi &ouml;grenmek i&ccedil;in tıklayın.</a></li>\r\n</ol>\r\n', ''),
(8, 2, 'FAQ', '', '', ''),
(9, 1, 'Hakkımızda', '', '', ''),
(9, 2, 'About Us', '', '', ''),
(10, 1, 'İletişim', NULL, NULL, NULL),
(10, 2, 'Contact Us', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `page_picture`
--

CREATE TABLE IF NOT EXISTS `page_picture` (
  `pageId` int(11) unsigned NOT NULL,
  `pictureId` int(11) unsigned NOT NULL,
  `isDefault` int(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`pageId`,`pictureId`),
  UNIQUE KEY `pageId` (`pageId`,`isDefault`),
  KEY `pictureId` (`pictureId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `paymentId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `paymentgroupId` int(11) unsigned DEFAULT NULL,
  `paymentPeriod` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`paymentId`),
  UNIQUE KEY `paymenttypeId` (`paymentgroupId`,`paymentPeriod`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Tablo döküm verisi `payment`
--

INSERT INTO `payment` (`paymentId`, `paymentgroupId`, `paymentPeriod`) VALUES
(10, 1, 1),
(11, 2, 1),
(26, 3, 1),
(13, 4, 1),
(8, 4, 3),
(25, 4, 6),
(12, 5, 1),
(4, 5, 3),
(5, 5, 6),
(9, 6, 1),
(17, 6, 3),
(18, 6, 6);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `paymentgroup`
--

CREATE TABLE IF NOT EXISTS `paymentgroup` (
  `paymentgroupId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `paymentgroupType` varchar(255) DEFAULT NULL,
  `paymentgroupSorting` tinyint(4) unsigned DEFAULT NULL,
  `paymentgroupClass` varchar(255) DEFAULT NULL,
  `paymentgroupStatus` tinyint(1) unsigned DEFAULT NULL,
  `bankCode` varchar(5) DEFAULT NULL,
  `paymentgroupMethod` varchar(255) DEFAULT NULL,
  `paymentgroupGate1` varchar(255) DEFAULT NULL,
  `paymentgroupGate2` varchar(255) DEFAULT NULL,
  `paymentgroupMid` varchar(255) DEFAULT NULL,
  `paymentgroupTid` varchar(255) DEFAULT NULL,
  `paymentgroupPosnetid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`paymentgroupId`),
  KEY `bankCode` (`bankCode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Tablo döküm verisi `paymentgroup`
--

INSERT INTO `paymentgroup` (`paymentgroupId`, `paymentgroupType`, `paymentgroupSorting`, `paymentgroupClass`, `paymentgroupStatus`, `bankCode`, `paymentgroupMethod`, `paymentgroupGate1`, `paymentgroupGate2`, `paymentgroupMid`, `paymentgroupTid`, `paymentgroupPosnetid`) VALUES
(1, 'mt', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'pd', 2, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'cc', 3, NULL, 1, '0067', '3dpay', 'https://www.posnet.ykb.com/PosnetWebService/XML', 'https://www.posnet.ykb.com/3DSWebService/YKBPaymentService', '6783406546', '67599225', '16916'),
(4, 'cc', 4, 'creditcard world', 1, '0067', '3dpay', 'https://www.posnet.ykb.com/PosnetWebService/XML', 'https://www.posnet.ykb.com/3DSWebService/YKBPaymentService', '6783906412', '67326201', '17981'),
(5, 'cc', 5, 'creditcard bonus', 1, '0062', '3dpay', NULL, 'https://sanalposprov.garanti.com.tr/servlet/gt3dengine', '9258469', '10012077', NULL),
(6, 'cc', 6, 'creditcard axess', 1, '0046', '3dpay', NULL, 'https://www.sanalakpos.com/servlet/est3Dgate', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `paymentgroup_i18n`
--

CREATE TABLE IF NOT EXISTS `paymentgroup_i18n` (
  `paymentgroupId` int(11) unsigned NOT NULL,
  `iso639Id` int(11) unsigned NOT NULL,
  `paymentgroupTitle` varchar(255) DEFAULT NULL,
  `paymentgroupContent` text,
  PRIMARY KEY (`paymentgroupId`,`iso639Id`),
  KEY `paymenttypei18n_ibfk_2` (`iso639Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `paymentgroup_i18n`
--

INSERT INTO `paymentgroup_i18n` (`paymentgroupId`, `iso639Id`, `paymentgroupTitle`, `paymentgroupContent`) VALUES
(1, 1, 'Havale ile Ödeme', 'Siparişinizi onayladıktan sonra ekranda göreceğiniz sipariş kodunuzu lütfen kaydedin ve bu sipariş kodunu para transferi sırasında açıklamalar bölümüne girmeyi unutmayın.'),
(1, 2, 'Money Transfer', 'Please keep the order number after submitting'),
(2, 1, 'Teslimatta Ödeme', 'Siparişinizi onayladıktan sonra ekranda göreceğiniz sipariş kodunuzu lütfen kaydedin ve bu sipariş kodunu teslimat sırasında kontrol etmeyi unutmayın.'),
(2, 2, 'Payment on Delivery', 'Please keep the order number after submitting'),
(3, 1, 'Diğer Kredi Kartları', 'Diğer kredi kartları ile ödeme yapmak için lütfen aşağıdaki bilgileri doldurun'),
(3, 2, 'Other Credit Cards', 'Other Credit Cards'),
(4, 1, 'WORLD Kredi Kartı', 'WORLD kredi kartınızla ödeme yapmak için lütfen aşağıdaki bilgileri doldurun'),
(4, 2, 'WORLD Credit Card', 'Please fill below form to complete the payment'),
(5, 1, 'BONUS Kredi Kartı', 'BONUS kredi kartınızla ödeme yapmak için lütfen aşağıdaki bilgileri doldurun'),
(5, 2, 'BONUS Credit Card', 'Please fill below form to complete the payment'),
(6, 1, 'AXESS Kredi Kartı', 'AXESS kredi kartınızla ödeme yapmak için lütfen aşağıdaki bilgileri doldurun'),
(6, 2, 'AXESS Credit Card', 'Please fill below form to complete the payment');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `paymentgroup_picture`
--

CREATE TABLE IF NOT EXISTS `paymentgroup_picture` (
  `paymentgroupId` int(11) unsigned NOT NULL,
  `pictureId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`paymentgroupId`,`pictureId`),
  KEY `pictureId` (`pictureId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `paymentgroup_transportation`
--

CREATE TABLE IF NOT EXISTS `paymentgroup_transportation` (
  `paymentgroupId` int(11) unsigned NOT NULL,
  `transportationId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`paymentgroupId`,`transportationId`),
  KEY `paymenttype_transportation_ibfk_2` (`transportationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `paymentgroup_transportation`
--

INSERT INTO `paymentgroup_transportation` (`paymentgroupId`, `transportationId`) VALUES
(1, 18),
(2, 18),
(3, 18),
(4, 18),
(5, 18),
(6, 18);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `paymentimpact`
--

CREATE TABLE IF NOT EXISTS `paymentimpact` (
  `paymentimpactId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `paymentId` int(11) unsigned NOT NULL,
  `paymentimpactWeightRate` float unsigned DEFAULT NULL,
  `paymentimpactWeightPrice` decimal(17,2) unsigned DEFAULT NULL,
  `paymentimpactDiscountRate` float unsigned DEFAULT NULL,
  `paymentimpactDiscountPrice` decimal(17,2) unsigned DEFAULT NULL,
  PRIMARY KEY (`paymentimpactId`),
  KEY `paymentId` (`paymentId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Tablo döküm verisi `paymentimpact`
--

INSERT INTO `paymentimpact` (`paymentimpactId`, `paymentId`, `paymentimpactWeightRate`, `paymentimpactWeightPrice`, `paymentimpactDiscountRate`, `paymentimpactDiscountPrice`) VALUES
(1, 10, NULL, NULL, NULL, 5.00),
(2, 11, NULL, 5.00, NULL, NULL),
(3, 8, 0.03, NULL, NULL, NULL),
(4, 25, 0.06, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `payment_i18n`
--

CREATE TABLE IF NOT EXISTS `payment_i18n` (
  `paymentId` int(11) unsigned NOT NULL,
  `iso639Id` int(11) unsigned NOT NULL,
  `paymentTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`paymentId`,`iso639Id`),
  KEY `iso639Id` (`iso639Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `payment_i18n`
--

INSERT INTO `payment_i18n` (`paymentId`, `iso639Id`, `paymentTitle`) VALUES
(4, 1, '3 taksit'),
(5, 1, '6 taksit'),
(8, 1, '3 taksit'),
(9, 1, 'Tek çekim'),
(9, 2, '1 slip'),
(10, 1, 'Peşin'),
(10, 2, 'Cash'),
(11, 1, 'Peşin'),
(11, 2, 'Cash'),
(12, 1, 'Tek çekim'),
(13, 1, 'Tek çekim'),
(17, 1, '3 taksit'),
(17, 2, NULL),
(18, 1, '6 taksit'),
(18, 2, NULL),
(25, 1, '6 taksit'),
(26, 1, 'Tek çekim');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `permissionId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `permissionParent` int(11) unsigned DEFAULT NULL,
  `permissionHref` varchar(255) DEFAULT NULL,
  `permissionSorting` tinyint(4) unsigned DEFAULT NULL,
  PRIMARY KEY (`permissionId`),
  KEY `permissionParent` (`permissionParent`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=85 ;

--
-- Tablo döküm verisi `permission`
--

INSERT INTO `permission` (`permissionId`, `permissionParent`, `permissionHref`, `permissionSorting`) VALUES
(1, 38, '/modules/admin/index.php?action=logout', NULL),
(2, 38, '#', NULL),
(3, 38, '#', NULL),
(4, 38, '#', NULL),
(5, 38, '#', NULL),
(6, 38, '#', NULL),
(7, 2, '/modules/admin/modules/page/page.php', NULL),
(8, 3, '/modules/admin/modules/ecommerce/category.php', NULL),
(9, 3, '/modules/admin/modules/ecommerce/brand.php', NULL),
(10, 3, '/modules/admin/modules/ecommerce/product.php', NULL),
(11, 3, '/modules/admin/modules/ecommerce/attributegroup.php', NULL),
(12, 3, '/modules/admin/modules/ecommerce/productorder.php', NULL),
(13, 3, '/modules/admin/modules/ecommerce/transportation.php', NULL),
(14, 3, '/modules/admin/modules/ecommerce/paymentgroup.php', NULL),
(15, 3, '/modules/admin/modules/ecommerce/currency.php', NULL),
(16, 3, '/modules/admin/modules/ecommerce/taxonomy.php', NULL),
(17, 4, '/modules/admin/modules/settings/iso639.php', NULL),
(18, 4, '/modules/admin/modules/settings/banner.php', NULL),
(19, 4, '/modules/admin/modules/settings/company.php', NULL),
(20, 5, '/modules/admin/modules/user/user.php', NULL),
(21, 5, '/modules/admin/modules/user/role.php', NULL),
(22, 5, '/modules/admin/modules/user/permission.php', NULL),
(23, 6, '/modules/admin/modules/report/usertrack.php', NULL),
(24, 6, '/modules/admin/modules/report/userticket.php', NULL),
(26, 3, '/modules/admin/modules/ecommerce/supplier.php', NULL),
(27, 3, '/modules/admin/modules/ecommerce/productattribute.php', NULL),
(28, 3, '/modules/admin/modules/ecommerce/import.php', NULL),
(30, NULL, '#', NULL),
(31, 30, '/modules/b2b/index.php?action=logout', 1),
(32, NULL, '#', NULL),
(33, 32, '/modules/b2c/index.php?action=logout', 1),
(34, 32, '/modules/b2c/user.php', 2),
(35, 32, '/modules/b2c/address.php', 3),
(36, 32, '/modules/b2c/sales.php', 5),
(37, 32, '/modules/b2c/productorder.php?action=listProductorder', 4),
(38, NULL, '#', NULL),
(39, 30, '/modules/b2b/retailer.php', 2),
(40, 30, '/modules/b2b/user.php', 3),
(41, 30, '/modules/b2b/salescampaign.php', 9),
(42, 3, '/modules/admin/modules/ecommerce/salescampaign.php', NULL),
(43, 30, '/modules/b2b/product.php', 10),
(51, 30, '/modules/b2b/sales.php', 6),
(52, 30, '/modules/b2b/address.php', 4),
(61, 38, '#', NULL),
(62, 61, '/modules/admin/modules/survey/survey.php', NULL),
(63, 3, '/modules/admin/modules/ecommerce/productgroup.php', NULL),
(66, 4, '/modules/admin/modules/settings/template.php', NULL),
(67, 4, '/modules/admin/modules/settings/email.php', NULL),
(68, 30, '/modules/b2b/productorder.php?action=listProductorder', 5),
(69, 30, '/modules/b2b/category.php', 11),
(70, 30, '/modules/b2b/brand.php', 12),
(71, 32, '/modules/b2c/wishlist.php', 6),
(72, 30, '/modules/b2b/wishlist.php', 8),
(73, 30, '/modules/b2b/productcompare.php', 7),
(74, 3, '/modules/admin/modules/ecommerce/voucher.php', NULL),
(75, 5, '/modules/admin/modules/user/usergroup.php', NULL),
(76, 32, '/modules/b2c/userpoint.php', 7),
(77, 30, '/modules/b2b/page.php', NULL),
(78, 30, '/modules/contact/index.php', NULL),
(79, 32, '/modules/contact/index.php', NULL),
(80, 32, '/modules/b2c/productgroup.php', NULL),
(81, 32, '/modules/b2c/brand.php', NULL),
(82, 32, '/modules/b2c/category.php', NULL),
(83, 32, '/modules/b2c/page.php', NULL),
(84, 32, '/modules/b2c/product.php', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `permission_i18n`
--

CREATE TABLE IF NOT EXISTS `permission_i18n` (
  `permissionId` int(11) unsigned NOT NULL,
  `iso639Id` int(11) unsigned NOT NULL,
  `permissionTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`permissionId`,`iso639Id`),
  KEY `pageadmini18n_ibfk_2` (`iso639Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `permission_i18n`
--

INSERT INTO `permission_i18n` (`permissionId`, `iso639Id`, `permissionTitle`) VALUES
(1, 1, 'Çıkış'),
(1, 2, 'Logout'),
(2, 1, 'İçerik Yönetimi'),
(2, 2, 'Content Management'),
(3, 1, 'E-Ticaret Ayarları'),
(3, 2, 'E-Commerce Settings'),
(4, 1, 'Genel Ayarlar'),
(4, 2, 'General Settings'),
(5, 1, 'Kullanıcı ve Yetki Ayarları'),
(5, 2, 'Users and Permissions'),
(6, 1, 'Raporlar'),
(6, 2, 'Reports'),
(7, 1, 'Sayfalar'),
(7, 2, 'Pages'),
(8, 1, 'Kategoriler'),
(8, 2, 'Categories'),
(9, 1, 'Markalar'),
(9, 2, 'Brands'),
(10, 1, 'Ürünler'),
(10, 2, 'Products'),
(11, 1, 'Ürün Özellikleri'),
(11, 2, 'Product Specs'),
(12, 1, 'Ürün Siparişleri'),
(12, 2, 'Orders'),
(13, 1, 'Taşıma'),
(13, 2, 'Carrier'),
(14, 1, 'Ödeme Şekilleri'),
(14, 2, 'Payment Types'),
(15, 1, 'Para Birimleri'),
(15, 2, 'Currencies'),
(16, 1, 'Vergi Ayarları'),
(16, 2, 'Taxes'),
(17, 1, 'Dil Ayarları'),
(17, 2, 'Languages'),
(18, 1, 'Banner Ayarları'),
(18, 2, 'Banners'),
(19, 1, 'Firma Bilgileri'),
(19, 2, 'Company Information'),
(20, 1, 'Kullanıcılar'),
(20, 2, 'Users'),
(21, 1, 'Roller'),
(21, 2, 'Roles'),
(22, 1, 'Yetkiler'),
(22, 2, 'Permissions'),
(23, 1, 'Kullanıcı Takibi'),
(23, 2, 'User Tracking'),
(24, 1, 'Kullanıcı Mesajları'),
(24, 2, 'User Messages'),
(26, 1, 'Tedarikçiler'),
(26, 2, 'Suppliers'),
(27, 1, 'Ürün Stok Yönetimi'),
(27, 2, 'Product Stock Management'),
(28, 1, 'XML - İçe Aktar'),
(28, 2, 'Import XML'),
(30, 1, 'B2B'),
(30, 2, 'B2B'),
(31, 1, 'Çıkış'),
(31, 2, 'Logout'),
(32, 1, 'B2C'),
(32, 2, 'B2C'),
(33, 1, 'Çıkış'),
(33, 2, 'Logout'),
(34, 1, 'Kişisel Bilgilerim'),
(34, 2, 'Personal Information'),
(35, 1, 'Adres Bilgilerim'),
(35, 2, 'Address Information'),
(36, 1, 'Alışveriş Sepetim'),
(36, 2, 'Shopping Basket'),
(37, 1, 'Siparişlerim'),
(37, 2, 'Orders'),
(38, 1, 'Yönetim Paneli'),
(38, 2, 'Admin Panel'),
(39, 1, 'Firma Bilgilerim'),
(39, 2, 'Company Information'),
(40, 1, 'Kişisel Bilgilerim'),
(40, 2, 'Personal Information'),
(41, 1, 'Kampanyalı Satışlar'),
(41, 2, 'Sales Campaigns'),
(42, 1, 'Kampanyalı Satışlar'),
(42, 2, 'Sales Campaigns'),
(43, 1, 'Ürünler'),
(43, 2, 'Products'),
(51, 1, 'Alışveriş Sepetim'),
(51, 2, 'Shopping Basket'),
(52, 1, 'Adres Bilgilerim'),
(52, 2, 'Address Information'),
(61, 1, 'Anket Yönetimi'),
(61, 2, 'Survey Management'),
(62, 1, 'Anket Listesi'),
(62, 2, 'Survey List'),
(63, 1, 'Ürün Grupları'),
(63, 2, 'Product Groups'),
(66, 1, 'Şablon Yönetimi'),
(66, 2, 'Template Management'),
(67, 1, 'E-posta Ayarları'),
(67, 2, 'E-mail Settings'),
(68, 1, 'Siparişlerim'),
(68, 2, 'Orders'),
(69, 1, 'Kategoriler'),
(69, 2, 'Categories'),
(70, 1, 'Markalar'),
(70, 2, 'Brands'),
(71, 1, 'Alışveriş Listem'),
(71, 2, 'Wish List'),
(72, 1, 'Alışveriş Listem'),
(72, 2, 'Wish List'),
(73, 1, 'Ürün Karşılaştırma'),
(73, 2, 'Product Compare'),
(74, 1, 'Hediye Çeki'),
(74, 2, 'Gift Voucher'),
(75, 1, 'Kullanıcı grupları'),
(75, 2, 'User groups'),
(76, 1, 'Hediye Puanlarım'),
(76, 2, 'Gift Points');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `picture`
--

CREATE TABLE IF NOT EXISTS `picture` (
  `pictureId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pictureFile` varchar(255) NOT NULL,
  PRIMARY KEY (`pictureId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=371 ;

--
-- Tablo döküm verisi `picture`
--

INSERT INTO `picture` (`pictureId`, `pictureFile`) VALUES
(350, '1323070531.jpg'),
(353, '1323071405.jpg'),
(354, '1323071888.jpg'),
(355, '1323071931.jpg'),
(356, '1323071952.jpg'),
(357, '1323071973.jpg'),
(358, '1323072450.png'),
(359, '1323072459.png'),
(360, '1323072473.png'),
(361, '1323072479.png'),
(362, '1323072485.png'),
(363, '1323072490.png'),
(364, '1323072495.png'),
(365, '1323114965.png'),
(366, '1323194679.jpg'),
(367, '1323345572.jpg'),
(368, '1323376179.jpg'),
(369, '1325713052.jpg'),
(370, '1325713123.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `postaladdress`
--

CREATE TABLE IF NOT EXISTS `postaladdress` (
  `postaladdressId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL,
  `postaladdressContent` varchar(255) DEFAULT NULL,
  `postaladdressCity` varchar(255) DEFAULT NULL,
  `postaladdressCounty` varchar(255) DEFAULT NULL,
  `postaladdressPostalcode` varchar(255) DEFAULT NULL,
  `postaladdressCountry` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`postaladdressId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=102 ;

--
-- Tablo döküm verisi `postaladdress`
--

INSERT INTO `postaladdress` (`postaladdressId`, `userId`, `postaladdressContent`, `postaladdressCity`, `postaladdressCounty`, `postaladdressPostalcode`, `postaladdressCountry`) VALUES
(24, 2, 'teslimat sokak no:1', 'istanbul', 'üsküdar', '34000', 'Türkiye'),
(28, 2, 'fatura sokak no:12', 'istanbul', 'üsküdar', '34000', 'Türkiye'),
(29, 1, '111wqwqw12', 'wqwq', 'wed', 'dww', 'defsf'),
(30, 1, 'wed', 'edwd', 'ed', 'eded', 'edw'),
(48, 3, '133336', 'W', 'W', 'W', 'W'),
(54, 3, '1222235555', '1', '1', '1', '1'),
(58, 2, 'q', 'q', 'q', 'q', 'q'),
(73, 3, '23456', 'w32d', 'we', 'qedw', 'wew'),
(74, 3, '12222', 'dqwe', 'qdwed', 'qwdwedqwd', 'ad'),
(80, 2, 'fatura adresi 1', 'İstanbul', 'Ataşehir', '34758', 'Türkiye'),
(86, 2, 'teslimat adresi 1', 'istanbul', 'ataşehir', '34758', 'Türkiye'),
(96, 3, '1', '1', '1', '1', '1'),
(98, 2, '1', '1', '1', '1', '1'),
(99, 11, 'aas', 'efweg', 'ergwrth', 'erhety', 'ryjyuk'),
(100, 11, 'erg', 'rgqer', 'gwrthr', 'thetyrrrrr', 'jryu5uk'),
(101, 11, 'wrger', 'gwrthr', 'hetyj', 'ryujry', '6uıl6ol');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `productId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `productCode` varchar(255) DEFAULT NULL,
  `productTitle` varchar(50) DEFAULT NULL,
  `productContent` text,
  `productVideo` text,
  `productHit` int(11) unsigned DEFAULT NULL,
  `categoryId` int(11) unsigned DEFAULT NULL,
  `brandId` int(11) unsigned DEFAULT NULL,
  `taxonomyId` int(11) unsigned DEFAULT NULL,
  `warrantyId` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`productId`),
  UNIQUE KEY `productCode` (`productCode`),
  KEY `brandId` (`brandId`),
  KEY `taxonomyId` (`taxonomyId`),
  KEY `categoryId` (`categoryId`),
  KEY `warrantyId` (`warrantyId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Tablo döküm verisi `product`
--

INSERT INTO `product` (`productId`, `productCode`, `productTitle`, `productContent`, `productVideo`, `productHit`, `categoryId`, `brandId`, `taxonomyId`, `warrantyId`) VALUES
(2, '11105', 'Şifon Elbise', '<p>\r\n	G&ouml;ğ&uuml;s altı payet-boncuk işlemeli şifon elbise</p>\r\n', '', 81, 25, 1, 1, 1),
(3, '11110', 'Üçlü Takım', '<p>\r\n	Bel kısmı işlemeli&nbsp; tafta bustiyer-etek t&uuml;l bolerolu &uuml;&ccedil;l&uuml; takım</p>\r\n', NULL, 72, 26, 1, 1, 1),
(4, '11115', 'Bustiyer', '<p>\r\n	Tek omuz ve eteği kendi kumaşından g&uuml;l s&uuml;slemeli tafta bustiyer -etek ikili takım</p>\r\n', NULL, NULL, 25, 1, 1, 1),
(5, '11116', 'Tül Elbise', '<p>\r\n	G&ouml;ğ&uuml;s altı g&uuml;l s&uuml;slemeli saten ve işlemeli t&uuml;l elbise</p>\r\n', '<iframe src="http://player.vimeo.com/video/35663673?title=0&byline=0&portrait=0" width="600" height="337" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>', 7, 25, 1, 1, 1),
(6, '11119', 'Tafta Elbise', '<p>\r\n	G&ouml;ğ&uuml;s altı taş s&uuml;sl&uuml; bolerolu tafta elbise</p>\r\n', NULL, NULL, 25, 1, 1, 1),
(7, '11120', 'Saten Elbise', '<p>\r\n	G&ouml;ğ&uuml;s ve kal&ccedil;ası nakış boncuk işlemeli saten elbise</p>\r\n', NULL, 22, 26, 1, 1, 1),
(8, '11121', 'Bolerolu Elbise', '<p>\r\n	Boyu kısmı boncuk işlemeli bolerolu tafta elbise</p>\r\n', NULL, 90, 26, 1, 1, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `productattribute`
--

CREATE TABLE IF NOT EXISTS `productattribute` (
  `productattributeId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `productId` int(11) unsigned NOT NULL,
  `productattributeCode` varchar(255) DEFAULT NULL,
  `productattributeQuantity` int(11) unsigned DEFAULT NULL,
  `productattributeCost` double(8,2) unsigned DEFAULT NULL,
  `productattributePrice` double(8,2) unsigned DEFAULT NULL,
  PRIMARY KEY (`productattributeId`),
  UNIQUE KEY `productattributeCode` (`productattributeCode`) USING BTREE,
  KEY `productId` (`productId`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1035 ;

--
-- Tablo döküm verisi `productattribute`
--

INSERT INTO `productattribute` (`productattributeId`, `productId`, `productattributeCode`, `productattributeQuantity`, `productattributeCost`, `productattributePrice`) VALUES
(2, 2, '11105-38-SAKS', 3, NULL, 389.00),
(3, 2, '11105-40-SAKS', 3, 389.00, 389.00),
(5, 3, '11110-38-BLACK', 2, 389.00, 389.00),
(6, 3, '11110-40-BLACK', 4, 389.00, 389.00),
(7, 3, '11110-42-BLACK', 4, 389.00, 389.00),
(22, 2, '11105-42-SAKS', 2, 389.00, 389.00),
(24, 4, '11115-38-BLACK', 0, 389.00, 389.00),
(25, 4, '11115-40-BLACK', 2, 389.00, 389.00),
(27, 4, '11115-42-BLACK', 0, 389.00, 389.00),
(31, 5, '11116-38-KEMIK', 0, 290.00, 290.00),
(32, 5, '11116-40-KEMIK', 0, 290.00, 290.00),
(34, 5, '11116-42-KEMIK', 1, 290.00, 290.00),
(38, 5, '11116-38-GREEN', 2, 290.00, 290.00),
(46, 5, '11116-40-GREEN', 0, 290.00, 290.00),
(62, 5, '11116-42-GREEN', 2, 290.00, 290.00),
(94, 5, '11116-38-FUSYA', 2, 290.00, 290.00),
(158, 5, '11116-40-FUSYA', 2, 290.00, 290.00),
(286, 5, '11116-42-FUSYA', 2, 290.00, 290.00),
(538, 6, '11119-38-PETROL', 0, 259.00, 259.00),
(539, 6, '11119-40-PETROL', 0, 259.00, 259.00),
(541, 6, '11119-38-FUSYA', 0, 259.00, 259.00),
(545, 6, '11119-40-FUSYA', 0, 259.00, 259.00),
(553, 6, '11119-38-YESIL', 0, 259.00, 259.00),
(569, 6, '11119-40-YESIL', 0, 259.00, 259.00),
(570, 7, '11120-38-MURDUM', 2, 450.00, 450.00),
(571, 7, '11120-40-MURDUM', 3, 450.00, 450.00),
(573, 7, '11120-42-MURDUM', 3, 450.00, 450.00),
(577, 7, '11120-44-MURDUM', 3, 450.00, 450.00),
(585, 7, '11120-38-FUME', 3, 450.00, 450.00),
(601, 7, '11120-40-FUME', 3, 450.00, 450.00),
(633, 7, '11120-42-FUME', 3, 450.00, 450.00),
(697, 7, '11120-44-FUME', 3, 450.00, 450.00),
(825, 7, '11120-38-LACIVERT', 3, 450.00, 450.00),
(826, 7, '11120-40-LACIVERT', 3, 450.00, 450.00),
(828, 7, '11120-42-LACIVERT', 3, 450.00, 450.00),
(832, 7, '11120-44-LACIVERT', 3, 450.00, 450.00),
(841, 8, '11121-38-MOR', 0, 259.00, 259.00),
(842, 8, '11121-40-MOR', 0, 259.00, 259.00),
(844, 8, '11121-42-MOR', 0, 259.00, 259.00),
(848, 8, '11121-44-MOR', 2, 259.00, 259.00),
(856, 8, '11121-38-PETROL', 2, 259.00, 259.00),
(872, 8, '11121-40-PETROL', 2, 259.00, 259.00),
(904, 8, '11121-42-PETROL', 2, 259.00, 259.00),
(968, 8, '11121-44-PETROL', 2, 259.00, 259.00),
(969, 8, '11121-38-FUSYA', 2, 259.00, 259.00),
(971, 8, '11121-40-FUSYA', 2, 259.00, 259.00),
(975, 8, '11121-42-FUSYA', 2, 259.00, 259.00),
(983, 8, '11121-44-FUSYA', 2, 259.00, 259.00),
(999, 8, '11121-38-YESIL', 2, 259.00, 259.00),
(1031, 8, '11121-40-YESIL', 2, 259.00, 259.00),
(1032, 8, '11121-42-YESIL', 2, 259.00, 259.00),
(1034, 8, '11121-44-YESIL', 2, 259.00, 259.00);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `productattributemovement`
--

CREATE TABLE IF NOT EXISTS `productattributemovement` (
  `productattributemovementId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `productattributeId` int(11) unsigned NOT NULL,
  `productattributemovementQuantity` int(11) unsigned NOT NULL,
  `productattributemovementPriceOC` double(8,2) unsigned DEFAULT NULL,
  `productattributemovementDate` date DEFAULT NULL,
  `supplierId` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`productattributemovementId`),
  KEY `productattributeId` (`productattributeId`) USING BTREE,
  KEY `supplierId` (`supplierId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=111 ;

--
-- Tablo döküm verisi `productattributemovement`
--

INSERT INTO `productattributemovement` (`productattributemovementId`, `productattributeId`, `productattributemovementQuantity`, `productattributemovementPriceOC`, `productattributemovementDate`, `supplierId`) VALUES
(51, 3, 2, 389.00, '2011-11-01', 1),
(55, 22, 2, 389.00, '2011-11-01', 1),
(57, 5, 4, 389.00, '2011-11-01', 1),
(59, 6, 4, 389.00, '2011-11-01', 1),
(61, 7, 4, 389.00, '2011-11-01', 1),
(62, 24, 2, 389.00, '2011-11-01', 1),
(63, 25, 2, 389.00, '2011-11-01', 1),
(64, 27, 2, 389.00, '2011-11-01', 1),
(65, 31, 2, 290.00, '2011-11-01', 1),
(66, 34, 2, 290.00, '2011-11-01', 1),
(67, 32, 2, 290.00, '2011-11-01', 1),
(68, 38, 2, 290.00, '2011-11-01', 1),
(69, 46, 2, 290.00, '2011-11-01', 1),
(70, 62, 2, 290.00, '2011-11-01', 1),
(71, 94, 2, 290.00, '2011-11-01', 1),
(72, 158, 2, 290.00, '2011-11-01', 1),
(73, 286, 2, 290.00, '2011-11-01', 1),
(74, 538, 2, 259.00, '2011-11-01', 1),
(75, 539, 2, 259.00, '2011-11-01', 1),
(76, 541, 2, 259.00, '2011-11-01', 1),
(77, 545, 4, 259.00, '2011-11-01', 1),
(78, 553, 2, 259.00, '2011-11-01', 1),
(79, 569, 2, 259.00, '2011-11-01', 1),
(82, 570, 3, 450.00, '2011-12-01', 1),
(83, 571, 3, 450.00, '2011-12-01', 1),
(84, 573, 3, 450.00, '2011-12-01', 1),
(85, 577, 3, 450.00, '2011-12-01', 1),
(86, 585, 3, 450.00, '2011-12-01', 1),
(87, 601, 3, 450.00, '2011-12-01', 1),
(88, 633, 3, 450.00, '2011-12-01', 1),
(89, 697, 3, 450.00, '2011-12-01', 1),
(90, 825, 3, 450.00, '2011-12-01', 1),
(91, 826, 3, 450.00, '2011-12-01', 1),
(92, 828, 3, 450.00, '2011-12-01', 1),
(93, 832, 3, 450.00, '2011-12-01', 1),
(94, 841, 2, 259.00, '2011-12-01', 1),
(95, 842, 2, 259.00, '2011-12-01', 1),
(96, 844, 2, 259.00, '2011-12-01', 1),
(97, 848, 2, 259.00, '2011-12-01', 1),
(98, 856, 2, 259.00, '2011-12-01', 1),
(99, 872, 2, 259.00, '2011-12-01', 1),
(100, 904, 2, 259.00, '2011-12-01', 1),
(101, 968, 2, 259.00, '2011-12-01', 1),
(102, 969, 2, 259.00, '2011-12-01', 1),
(103, 971, 2, 259.00, '2011-12-01', 1),
(104, 975, 2, 259.00, '2011-12-01', 1),
(105, 983, 2, 259.00, '2011-12-01', 1),
(106, 999, 2, 259.00, '2011-12-01', 1),
(107, 1031, 2, 259.00, '2011-12-01', 1),
(108, 1032, 2, 259.00, '2011-12-01', 1),
(109, 1034, 2, 259.00, '2011-12-01', 1),
(110, 2, 4, NULL, NULL, NULL);

--
-- Tetikleyiciler `productattributemovement`
--
DROP TRIGGER IF EXISTS `ai s productattributemovement t productattribute`;
DELIMITER //
CREATE TRIGGER `ai s productattributemovement t productattribute` AFTER INSERT ON `productattributemovement`
 FOR EACH ROW update productattribute 
set 
productattribute.productattributeCost = (
select 
ROUND(SUM(productattributemovement.productattributemovementQuantity*productattributemovement.productattributemovementPriceOC)/SUM(productattributemovement.productattributemovementQuantity),2)
from productattributemovement 
where productattributemovement.productattributeId = NEW.productattributeId
),
productattribute .productattributeQuantity = (
select 
SUM(productattributemovement.productattributemovementQuantity)-
(
select
IFNULL(SUM(productsalesmovement.productsalesmovementQuantity),0)
from productsalesmovement
where productsalesmovement.productattributeId = NEW.productattributeId
)
from productattributemovement 
where productattributemovement.productattributeId = NEW.productattributeId
)
where productattribute.productattributeId = NEW.productattributeId
//
DELIMITER ;
DROP TRIGGER IF EXISTS `au s productattributemovement t productattribute`;
DELIMITER //
CREATE TRIGGER `au s productattributemovement t productattribute` AFTER UPDATE ON `productattributemovement`
 FOR EACH ROW update productattribute 
set 
productattribute.productattributeCost = (
select 
ROUND(SUM(productattributemovement.productattributemovementQuantity*productattributemovement.productattributemovementPriceOC)/SUM(productattributemovement.productattributemovementQuantity),2)
from productattributemovement 
where productattributemovement.productattributeId = NEW.productattributeId
),
productattribute .productattributeQuantity = (
select 
SUM(productattributemovement.productattributemovementQuantity)-
(
select
IFNULL(SUM(productsalesmovement.productsalesmovementQuantity),0)
from productsalesmovement
where productsalesmovement.productattributeId = NEW.productattributeId
)
from productattributemovement 
where productattributemovement.productattributeId = NEW.productattributeId
)
where productattribute.productattributeId = NEW.productattributeId
//
DELIMITER ;
DROP TRIGGER IF EXISTS `ad s productattributemovement t productattribute`;
DELIMITER //
CREATE TRIGGER `ad s productattributemovement t productattribute` AFTER DELETE ON `productattributemovement`
 FOR EACH ROW update productattribute 
set 
productattribute.productattributeCost = (
select 
ROUND(SUM(productattributemovement.productattributemovementQuantity*productattributemovement.productattributemovementPriceOC)/SUM(productattributemovement.productattributemovementQuantity),2)
from productattributemovement 
where productattributemovement.productattributeId = OLD.productattributeId
),
productattribute .productattributeQuantity = (
select 
SUM(productattributemovement.productattributemovementQuantity)-
(
select
IFNULL(SUM(productsalesmovement.productsalesmovementQuantity),0)
from productsalesmovement
where productsalesmovement.productattributeId = OLD.productattributeId
)
from productattributemovement 
where productattributemovement.productattributeId = OLD.productattributeId
)
where productattribute.productattributeId = OLD.productattributeId
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `productattribute_attribute`
--

CREATE TABLE IF NOT EXISTS `productattribute_attribute` (
  `productattributeId` int(11) unsigned NOT NULL,
  `attributeId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`productattributeId`,`attributeId`),
  KEY `attributeId` (`attributeId`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `productattribute_attribute`
--

INSERT INTO `productattribute_attribute` (`productattributeId`, `attributeId`) VALUES
(5, 4),
(6, 4),
(7, 4),
(24, 4),
(25, 4),
(27, 4),
(2, 5),
(5, 5),
(24, 5),
(31, 5),
(38, 5),
(94, 5),
(538, 5),
(541, 5),
(553, 5),
(570, 5),
(585, 5),
(825, 5),
(841, 5),
(856, 5),
(969, 5),
(999, 5),
(3, 6),
(6, 6),
(25, 6),
(32, 6),
(46, 6),
(158, 6),
(539, 6),
(545, 6),
(569, 6),
(571, 6),
(601, 6),
(826, 6),
(842, 6),
(872, 6),
(971, 6),
(1031, 6),
(2, 7),
(3, 7),
(22, 7),
(31, 8),
(32, 8),
(34, 8),
(38, 9),
(46, 9),
(62, 9),
(553, 9),
(569, 9),
(999, 9),
(1031, 9),
(1032, 9),
(1034, 9),
(94, 10),
(158, 10),
(286, 10),
(541, 10),
(545, 10),
(969, 10),
(971, 10),
(975, 10),
(983, 10),
(538, 11),
(539, 11),
(856, 11),
(872, 11),
(904, 11),
(968, 11),
(7, 12),
(22, 12),
(27, 12),
(34, 12),
(62, 12),
(286, 12),
(573, 12),
(633, 12),
(828, 12),
(844, 12),
(904, 12),
(975, 12),
(1032, 12),
(577, 13),
(697, 13),
(832, 13),
(848, 13),
(968, 13),
(983, 13),
(1034, 13),
(570, 14),
(571, 14),
(573, 14),
(577, 14),
(585, 15),
(601, 15),
(633, 15),
(697, 15),
(825, 16),
(826, 16),
(828, 16),
(832, 16),
(841, 17),
(842, 17),
(844, 17),
(848, 17);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `productcomment`
--

CREATE TABLE IF NOT EXISTS `productcomment` (
  `productcommentId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `productId` int(11) unsigned NOT NULL,
  `userId` int(11) unsigned NOT NULL,
  `productcommentContent` varchar(255) DEFAULT NULL,
  `productcommentDatetime` datetime DEFAULT NULL,
  PRIMARY KEY (`productcommentId`),
  KEY `userId` (`userId`),
  KEY `productId` (`productId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Tablo döküm verisi `productcomment`
--

INSERT INTO `productcomment` (`productcommentId`, `productId`, `userId`, `productcommentContent`, `productcommentDatetime`) VALUES
(1, 6, 1, 'dededede', '2011-12-08 00:03:54'),
(2, 6, 2, 'wrfwerfwefre', '2011-12-15 00:03:50'),
(4, 2, 12, '3frv32vertve', '2011-12-15 00:04:21');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `productgroup`
--

CREATE TABLE IF NOT EXISTS `productgroup` (
  `productgroupId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `productgroupSorting` tinyint(4) unsigned DEFAULT NULL,
  PRIMARY KEY (`productgroupId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Tablo döküm verisi `productgroup`
--

INSERT INTO `productgroup` (`productgroupId`, `productgroupSorting`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `productgroup_i18n`
--

CREATE TABLE IF NOT EXISTS `productgroup_i18n` (
  `productgroupId` int(10) unsigned NOT NULL,
  `iso639Id` int(10) unsigned NOT NULL,
  `productgroupTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`productgroupId`,`iso639Id`),
  KEY `iso639Id` (`iso639Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `productgroup_i18n`
--

INSERT INTO `productgroup_i18n` (`productgroupId`, `iso639Id`, `productgroupTitle`) VALUES
(1, 1, 'İndirimli Ürünler'),
(1, 2, 'Discount Products'),
(2, 1, 'En Çok Satanlar'),
(2, 2, 'Best Sellers'),
(3, 1, 'Yeni Ürünler'),
(3, 2, 'Brandnew');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `productgroup_product`
--

CREATE TABLE IF NOT EXISTS `productgroup_product` (
  `productgroupId` int(11) unsigned NOT NULL,
  `productId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`productgroupId`,`productId`),
  KEY `productId` (`productId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `productgroup_product`
--

INSERT INTO `productgroup_product` (`productgroupId`, `productId`) VALUES
(2, 2),
(1, 3),
(2, 3),
(3, 3),
(1, 4),
(3, 4),
(1, 5),
(2, 5),
(1, 6),
(2, 6),
(3, 6),
(1, 7),
(3, 7),
(1, 8);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `productimpact`
--

CREATE TABLE IF NOT EXISTS `productimpact` (
  `productimpactId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `productId` int(11) unsigned NOT NULL,
  `roleId` int(11) unsigned DEFAULT NULL,
  `productPrice` decimal(17,2) unsigned DEFAULT NULL,
  `productimpactWeightRate` float unsigned DEFAULT NULL,
  `productimpactWeightPrice` decimal(17,2) unsigned DEFAULT NULL,
  `productimpactDiscountRate` float unsigned DEFAULT NULL,
  `productimpactDiscountPrice` decimal(17,2) unsigned DEFAULT NULL,
  PRIMARY KEY (`productimpactId`),
  UNIQUE KEY `productId` (`productId`,`roleId`) USING BTREE,
  KEY `roleId` (`roleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=127 ;

--
-- Tablo döküm verisi `productimpact`
--

INSERT INTO `productimpact` (`productimpactId`, `productId`, `roleId`, `productPrice`, `productimpactWeightRate`, `productimpactWeightPrice`, `productimpactDiscountRate`, `productimpactDiscountPrice`) VALUES
(95, 4, 3, 369.44, NULL, NULL, 0.2, NULL),
(96, 3, 3, 360.19, NULL, NULL, 0.4, NULL),
(100, 6, 3, 239.81, NULL, NULL, 0.1, NULL),
(119, 7, 3, 1.00, NULL, NULL, NULL, NULL),
(122, 2, 3, 100.00, NULL, NULL, NULL, NULL),
(124, 8, 3, 3.00, NULL, NULL, 0.1, 1.00),
(126, 5, 3, 3.00, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `productorder`
--

CREATE TABLE IF NOT EXISTS `productorder` (
  `productorderId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `productorderstatusId` int(11) unsigned DEFAULT NULL,
  `userId` int(11) unsigned NOT NULL,
  `XID` varchar(255) DEFAULT NULL,
  `productorderDatetime` datetime DEFAULT NULL,
  `paymentId` int(11) unsigned DEFAULT NULL,
  `transportationId` int(11) unsigned DEFAULT NULL,
  `deliveryaddressId` int(11) unsigned DEFAULT NULL,
  `invoiceaddressId` int(11) unsigned DEFAULT NULL,
  `voucherCode` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`productorderId`),
  UNIQUE KEY `XID` (`XID`) USING BTREE,
  KEY `transportationId` (`transportationId`),
  KEY `deliveryaddressId` (`deliveryaddressId`),
  KEY `invoiceaddressId` (`invoiceaddressId`),
  KEY `productorderstatusId` (`productorderstatusId`),
  KEY `paymentId` (`paymentId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Tablo döküm verisi `productorder`
--

INSERT INTO `productorder` (`productorderId`, `productorderstatusId`, `userId`, `XID`, `productorderDatetime`, `paymentId`, `transportationId`, `deliveryaddressId`, `invoiceaddressId`, `voucherCode`) VALUES
(17, 1, 2, 'MT_00000120122101452', '2012-01-22 10:14:52', 10, 18, 86, 80, NULL),
(18, 3, 2, 'PD_00000120122101544', '2012-01-22 10:15:44', 11, 18, 86, 80, NULL),
(19, 1, 11, 'MT_00000120321161054', '2012-03-21 16:10:54', 10, 18, 99, 100, '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `productorderstatus`
--

CREATE TABLE IF NOT EXISTS `productorderstatus` (
  `productorderstatusId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `productorderstatusCode` varchar(255) DEFAULT NULL,
  `productorderstatusColor` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`productorderstatusId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Tablo döküm verisi `productorderstatus`
--

INSERT INTO `productorderstatus` (`productorderstatusId`, `productorderstatusCode`, `productorderstatusColor`) VALUES
(1, 'Placed', '#ff0000'),
(2, 'Payment done', '#00ff00'),
(3, 'Processing', '#0000ff'),
(4, 'Dispatched', '#cccccc'),
(5, 'Delivered', NULL),
(6, 'Cancelled', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `productorderstatus_i18n`
--

CREATE TABLE IF NOT EXISTS `productorderstatus_i18n` (
  `productorderstatusId` int(11) unsigned NOT NULL,
  `iso639Id` int(11) unsigned NOT NULL,
  `productorderstatusTitle` varchar(255) DEFAULT NULL,
  `productorderstatusNote` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`productorderstatusId`,`iso639Id`),
  KEY `iso639Id` (`iso639Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `productorderstatus_i18n`
--

INSERT INTO `productorderstatus_i18n` (`productorderstatusId`, `iso639Id`, `productorderstatusTitle`, `productorderstatusNote`) VALUES
(1, 1, 'Ödeme bekleniyor', NULL),
(1, 2, 'Waiting for payment', 'Order Placed'),
(2, 1, 'Ödeme yapıldı', NULL),
(2, 2, 'Payment done', 'Payment done'),
(3, 1, 'Sipariş hazırlanıyor', NULL),
(3, 2, 'Checking for availability', 'Order Processing'),
(4, 1, 'Kargoda', NULL),
(4, 2, 'Waiting for carrier company', 'Order Dispatched'),
(5, 1, 'Teslim edildi', NULL),
(5, 2, 'Delivered to carrier company', 'Send Shipment notification'),
(6, 1, 'İptal edildi', NULL),
(6, 2, 'Cancelled', 'Cancelled');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `productsalesmovement`
--

CREATE TABLE IF NOT EXISTS `productsalesmovement` (
  `productsalesmovementId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `productorderId` int(11) unsigned DEFAULT NULL,
  `productattributeId` int(11) unsigned DEFAULT NULL,
  `productsalesmovementQuantity` int(11) unsigned DEFAULT NULL,
  `productsalesmovementQuantityCancelled` int(11) unsigned DEFAULT NULL,
  `productsalesmovementPrice` double(8,2) unsigned DEFAULT NULL,
  PRIMARY KEY (`productsalesmovementId`),
  KEY `productsales_ibfk_2` (`productattributeId`),
  KEY `productsales_ibfk_3` (`productorderId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Tablo döküm verisi `productsalesmovement`
--

INSERT INTO `productsalesmovement` (`productsalesmovementId`, `productorderId`, `productattributeId`, `productsalesmovementQuantity`, `productsalesmovementQuantityCancelled`, `productsalesmovementPrice`) VALUES
(25, 17, 844, 1, NULL, 1.70),
(26, 18, 570, 1, NULL, 1.00),
(27, 19, 844, 1, NULL, 0.00);

--
-- Tetikleyiciler `productsalesmovement`
--
DROP TRIGGER IF EXISTS `ai s productsalesmovement t productattribute`;
DELIMITER //
CREATE TRIGGER `ai s productsalesmovement t productattribute` AFTER INSERT ON `productsalesmovement`
 FOR EACH ROW update productattribute 
set 
productattribute.productattributeQuantity = (
select 
SUM(productattributemovement.productattributemovementQuantity)-
(
select
IFNULL(SUM(productsalesmovement.productsalesmovementQuantity),0)
from productsalesmovement
where productsalesmovement.productattributeId = NEW.productattributeId
)
from productattributemovement 
where productattributemovement.productattributeId = NEW.productattributeId
)
where productattribute.productattributeId = NEW.productattributeId
//
DELIMITER ;
DROP TRIGGER IF EXISTS `au s productsalesmovement t productattribute`;
DELIMITER //
CREATE TRIGGER `au s productsalesmovement t productattribute` AFTER UPDATE ON `productsalesmovement`
 FOR EACH ROW update productattribute 
set 
productattribute.productattributeQuantity = (
select 
SUM(productattributemovement.productattributemovementQuantity)-
(
select
IFNULL(SUM(productsalesmovement.productsalesmovementQuantity),0)
from productsalesmovement
where productsalesmovement.productattributeId = NEW.productattributeId
)
from productattributemovement 
where productattributemovement.productattributeId = NEW.productattributeId
)
where productattribute.productattributeId = NEW.productattributeId
//
DELIMITER ;
DROP TRIGGER IF EXISTS `ad s productsalesmovement t productattribute`;
DELIMITER //
CREATE TRIGGER `ad s productsalesmovement t productattribute` AFTER DELETE ON `productsalesmovement`
 FOR EACH ROW update productattribute 
set 
productattribute.productattributeQuantity = (
select 
SUM(productattributemovement.productattributemovementQuantity)-
(
select
IFNULL(SUM(productsalesmovement.productsalesmovementQuantity),0)
from productsalesmovement
where productsalesmovement.productattributeId = OLD.productattributeId
)
from productattributemovement 
where productattributemovement.productattributeId = OLD.productattributeId
)
where productattribute.productattributeId = OLD.productattributeId
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `product_category`
--

CREATE TABLE IF NOT EXISTS `product_category` (
  `productId` int(11) unsigned NOT NULL,
  `categoryId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`productId`,`categoryId`),
  KEY `categoryId` (`categoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `product_category`
--

INSERT INTO `product_category` (`productId`, `categoryId`) VALUES
(2, 25),
(4, 25),
(5, 25),
(6, 25),
(3, 26),
(7, 26),
(8, 26);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `product_picture`
--

CREATE TABLE IF NOT EXISTS `product_picture` (
  `productId` int(11) unsigned NOT NULL,
  `pictureId` int(11) unsigned NOT NULL,
  `isDefault` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`productId`,`pictureId`),
  UNIQUE KEY `productId` (`productId`,`isDefault`),
  KEY `pictureId` (`pictureId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `product_picture`
--

INSERT INTO `product_picture` (`productId`, `pictureId`, `isDefault`) VALUES
(2, 366, 1),
(3, 350, 1),
(4, 353, 1),
(5, 354, 1),
(6, 355, 1),
(7, 356, 1),
(8, 357, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `product_user`
--

CREATE TABLE IF NOT EXISTS `product_user` (
  `productId` int(11) unsigned NOT NULL,
  `userId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`productId`,`userId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `product_user`
--

INSERT INTO `product_user` (`productId`, `userId`) VALUES
(7, 1),
(7, 2),
(8, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `retailer`
--

CREATE TABLE IF NOT EXISTS `retailer` (
  `retailerId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `retailerCode` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`retailerId`),
  UNIQUE KEY `retailerCode` (`retailerCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `retailer_company`
--

CREATE TABLE IF NOT EXISTS `retailer_company` (
  `retailerId` int(11) unsigned NOT NULL,
  `companyId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`retailerId`,`companyId`),
  KEY `companyId` (`companyId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `retailer_user`
--

CREATE TABLE IF NOT EXISTS `retailer_user` (
  `retailerId` int(11) unsigned NOT NULL,
  `userId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`retailerId`,`userId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `roleId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `roleTitle` varchar(255) NOT NULL,
  `hasPriceDiscrimination` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`roleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Tablo döküm verisi `role`
--

INSERT INTO `role` (`roleId`, `roleTitle`, `hasPriceDiscrimination`) VALUES
(1, 'Yönetici - Seviye1', 0),
(2, 'Yönetici - Seviye2', 0),
(3, 'B2C Müşteri - Son Kullanıcı', 1),
(4, 'B2B Müşteri - A Tipi Bayi', 1),
(5, 'B2B Müşteri - B Tipi Bayi', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `role_permission`
--

CREATE TABLE IF NOT EXISTS `role_permission` (
  `roleId` int(11) unsigned NOT NULL,
  `permissionId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`roleId`,`permissionId`),
  KEY `permissionId` (`permissionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `role_permission`
--

INSERT INTO `role_permission` (`roleId`, `permissionId`) VALUES
(1, 1),
(2, 1),
(1, 2),
(2, 2),
(1, 3),
(2, 3),
(1, 4),
(2, 4),
(1, 5),
(1, 6),
(1, 7),
(2, 7),
(1, 8),
(2, 8),
(1, 9),
(2, 9),
(1, 10),
(2, 10),
(1, 11),
(2, 11),
(1, 12),
(2, 12),
(1, 13),
(2, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(2, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 26),
(1, 27),
(2, 27),
(1, 28),
(1, 30),
(4, 30),
(5, 30),
(1, 31),
(4, 31),
(5, 31),
(1, 32),
(3, 32),
(1, 33),
(3, 33),
(1, 34),
(3, 34),
(1, 35),
(3, 35),
(1, 36),
(3, 36),
(1, 37),
(3, 37),
(1, 38),
(1, 39),
(4, 39),
(5, 39),
(1, 40),
(4, 40),
(5, 40),
(1, 41),
(4, 41),
(5, 41),
(1, 42),
(1, 43),
(4, 43),
(5, 43),
(1, 51),
(4, 51),
(5, 51),
(1, 52),
(4, 52),
(5, 52),
(1, 61),
(1, 62),
(1, 63),
(2, 63),
(1, 66),
(2, 66),
(1, 67),
(2, 67),
(4, 68),
(5, 68),
(1, 69),
(4, 69),
(1, 70),
(4, 70),
(1, 71),
(3, 71),
(1, 72),
(4, 72),
(1, 73),
(4, 73),
(1, 74),
(2, 74),
(1, 75),
(2, 75),
(1, 76),
(2, 76),
(3, 76),
(1, 77),
(4, 77),
(5, 77),
(1, 78),
(4, 78),
(5, 78),
(1, 79),
(4, 79),
(5, 79),
(1, 80),
(4, 80),
(5, 80),
(1, 81),
(4, 81),
(5, 81),
(1, 82),
(4, 82),
(5, 82),
(1, 83),
(4, 83),
(5, 83),
(1, 84),
(4, 84),
(5, 84);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `salescampaign`
--

CREATE TABLE IF NOT EXISTS `salescampaign` (
  `salescampaignId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `salescampaignTitle` varchar(255) DEFAULT NULL,
  `salescampaignContent` text,
  `salescampaignStart` datetime DEFAULT NULL,
  `salescampaignEnd` datetime DEFAULT NULL,
  PRIMARY KEY (`salescampaignId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Tablo döküm verisi `salescampaign`
--

INSERT INTO `salescampaign` (`salescampaignId`, `salescampaignTitle`, `salescampaignContent`, `salescampaignStart`, `salescampaignEnd`) VALUES
(1, 'Kampanya 1', '<p>\r\n	Kampanya 1</p>\r\n<p>\r\n	abc &uuml;r&uuml;nlerinde %20 indirim</p>\r\n', '2011-11-25 00:26:00', '2012-11-30 11:00:00'),
(2, 'Kampanya 2', '<p>\r\n	al bakalım</p>\r\n', '2012-01-01 00:00:00', '2012-01-31 00:00:00'),
(3, 'Kampanya 3', NULL, NULL, NULL),
(4, 'Kampanya 4', NULL, NULL, NULL),
(5, 'Kampanya 5', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `salescampaign_picture`
--

CREATE TABLE IF NOT EXISTS `salescampaign_picture` (
  `salescampaignId` int(11) unsigned NOT NULL,
  `pictureId` int(11) unsigned NOT NULL,
  `isDefault` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`salescampaignId`,`pictureId`),
  UNIQUE KEY `salescampaignId` (`salescampaignId`,`isDefault`),
  KEY `pictureId` (`pictureId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `salescampaign_picture`
--

INSERT INTO `salescampaign_picture` (`salescampaignId`, `pictureId`, `isDefault`) VALUES
(1, 369, 1),
(2, 370, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `salescampaign_productattribute`
--

CREATE TABLE IF NOT EXISTS `salescampaign_productattribute` (
  `salescampaignId` int(11) unsigned NOT NULL,
  `productattributeId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`salescampaignId`,`productattributeId`),
  KEY `productattributeId` (`productattributeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `salescampaign_productattribute`
--

INSERT INTO `salescampaign_productattribute` (`salescampaignId`, `productattributeId`) VALUES
(1, 2),
(2, 2),
(2, 3),
(1, 5),
(1, 6),
(1, 7),
(1, 24),
(2, 31),
(2, 32),
(2, 34),
(2, 38),
(2, 46);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `settingId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `settingParameter` varchar(255) NOT NULL,
  `settingValue` text,
  PRIMARY KEY (`settingId`),
  UNIQUE KEY `settingKey` (`settingParameter`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=102 ;

--
-- Tablo döküm verisi `setting`
--

INSERT INTO `setting` (`settingId`, `settingParameter`, `settingValue`) VALUES
(12, '_SEO_VERIFY_GOOGLE', NULL),
(13, '_SEO_VERIFY_YAHOO', NULL),
(14, '_SEO_ANALYTICS_GOOGLE', NULL),
(15, '_SEO_META_TITLE', NULL),
(16, '_SEO_META_DESCRIPTION', NULL),
(17, '_SEO_META_KEYWORDS', NULL),
(47, '_COMPANY_NAME', 'E-Ticaret'),
(48, '_COMPANY_DOMAIN', 'domain.com'),
(49, '_COMPANY_ADDRESS', 'Adres Mh. Adres Sk. No:1'),
(50, '_COMPANY_PHONE', '+90 216 111 1111'),
(51, '_COMPANY_FAX', '+90 216 111 1111'),
(52, '_COMPANY_EMAIL', 'info@domain.com'),
(53, '_COMPANY_LATITUDE', '40.055295'),
(54, '_COMPANY_LONGITUDE', '29.010101'),
(55, '_THEME_B2C_NUMBEROFPRODUCTSDISPLAYED', '3'),
(56, '_THEME_B2C_NUMBEROFPRODUCTSDISPLAYEDONLEFTBAR', '2'),
(66, '_THEME_B2C_NIVOSLIDER', 'theme-default'),
(67, '_THEME_ADMIN_NAME', 'default'),
(68, '_THEME_B2B_NAME', 'kupa'),
(69, '_THEME_B2C_NAME', 'viol'),
(73, '_EMAIL_SERVER', 'smtp.gmail.com'),
(74, '_EMAIL_PORT', '465'),
(75, '_EMAIL_USERNAME', 'casict@casict.com'),
(76, '_EMAIL_PASSWORD', 'C1q2w3e4r'),
(77, '_EMAIL_FROMNAME', 'cas.ict'),
(78, '_EMAIL_FROM', 'casict@casict.com'),
(79, '_EMAIL_BCC', 'cem@casict.com'),
(80, '_THEME_B2C_LIMITPRODUCTS1', '3'),
(81, '_THEME_B2C_LIMITPRODUCTS2', '100'),
(83, '_THEME_B2C_LIMITPRODUCTSONLEFTBAR', '2'),
(84, '_THEME_B2B_NUMBEROFPRODUCTSDISPLAYED', '3'),
(86, '_THEME_B2B_LIMITPRODUCTS2', '100'),
(88, '_THEME_B2B_LIMITPRODUCTS1', '5'),
(89, '_USER_INITIALSTATUS_B2B', '0'),
(90, '_USER_INITIALSTATUS_B2C', '1'),
(91, '_SITE_TRACKING', '0'),
(92, '_SITE_CODEPACKING', '1'),
(93, '_USER_ROLE_B2B', '4'),
(94, '_USER_ROLE_B2C', '3'),
(95, '_USER_ROLE_ADMIN_LEVEL2', '2'),
(96, '_USER_ROLE_ADMIN_LEVEL1', '1'),
(97, '_PRODUCTORDER_INITIALSTATUS_MT', '1'),
(98, '_PRODUCTORDER_INITIALSTATUS_PD', '3'),
(99, '_PRODUCTORDER_INITIALSTATUS_CC', '2'),
(100, '_APPID_FACEBOOK', '294608807247890'),
(101, 'PREDEFINED_PICTURE_RESOLUTIONS', '[[50,50],[113,150],[190,190],[225,300]]');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `supplierId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `supplierCode` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`supplierId`),
  UNIQUE KEY `supplierCode` (`supplierCode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `supplier`
--

INSERT INTO `supplier` (`supplierId`, `supplierCode`) VALUES
(1, '01');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `supplier_company`
--

CREATE TABLE IF NOT EXISTS `supplier_company` (
  `supplierId` int(10) unsigned NOT NULL,
  `companyId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`supplierId`,`companyId`),
  KEY `companyId` (`companyId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `supplier_company`
--

INSERT INTO `supplier_company` (`supplierId`, `companyId`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `survey`
--

CREATE TABLE IF NOT EXISTS `survey` (
  `surveyId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `surveyTitle` varchar(255) DEFAULT NULL,
  `surveyStart` datetime DEFAULT NULL,
  `surveyEnd` datetime DEFAULT NULL,
  PRIMARY KEY (`surveyId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Tablo döküm verisi `survey`
--

INSERT INTO `survey` (`surveyId`, `surveyTitle`, `surveyStart`, `surveyEnd`) VALUES
(2, 'anket1', '2011-11-10 11:09:36', '2011-11-20 02:06:51');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `surveya`
--

CREATE TABLE IF NOT EXISTS `surveya` (
  `surveyaId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `surveyqId` int(11) unsigned DEFAULT NULL,
  `surveyaTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`surveyaId`),
  KEY `surveyqId` (`surveyqId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Tablo döküm verisi `surveya`
--

INSERT INTO `surveya` (`surveyaId`, `surveyqId`, `surveyaTitle`) VALUES
(17, 6, 'a1'),
(18, 6, 'a2'),
(22, 9, 'd1'),
(23, 9, 'd2'),
(24, 9, 'd3'),
(25, 6, 'a3'),
(26, 10, 'a1'),
(27, 10, 'a2'),
(28, 6, 'a4');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `surveyq`
--

CREATE TABLE IF NOT EXISTS `surveyq` (
  `surveyqId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `surveyId` int(11) unsigned DEFAULT NULL,
  `surveyqTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`surveyqId`),
  KEY `surveyId` (`surveyId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Tablo döküm verisi `surveyq`
--

INSERT INTO `surveyq` (`surveyqId`, `surveyId`, `surveyqTitle`) VALUES
(6, 2, 's1'),
(9, 2, 's2'),
(10, 2, 's3');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `surveyr`
--

CREATE TABLE IF NOT EXISTS `surveyr` (
  `surveyrId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL,
  `surveyId` int(11) unsigned DEFAULT NULL,
  `surveyqId` int(11) unsigned DEFAULT NULL,
  `surveyaId` int(11) unsigned DEFAULT NULL,
  `surveyrDatetime` datetime DEFAULT NULL,
  PRIMARY KEY (`surveyrId`),
  KEY `userId` (`userId`),
  KEY `surveyId` (`surveyId`),
  KEY `surveyqId` (`surveyqId`),
  KEY `surveyaId` (`surveyaId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Tablo döküm verisi `surveyr`
--

INSERT INTO `surveyr` (`surveyrId`, `userId`, `surveyId`, `surveyqId`, `surveyaId`, `surveyrDatetime`) VALUES
(1, NULL, 2, 6, 25, '2011-12-15 13:08:50'),
(2, NULL, 2, 9, 23, '2011-12-15 13:08:50'),
(3, NULL, 2, 10, 26, '2011-12-15 13:08:50'),
(4, 1, 2, 6, 25, '2011-12-15 13:10:10'),
(5, 1, 2, 9, 23, '2011-12-15 13:10:11'),
(6, 1, 2, 10, 26, '2011-12-15 13:10:11'),
(7, 1, 2, 6, 17, '2011-12-15 13:10:53'),
(8, 1, 2, 9, 23, '2011-12-15 13:10:53'),
(9, 1, 2, 10, 27, '2011-12-15 13:10:53'),
(10, 1, 2, 6, 28, '2011-12-15 13:13:54'),
(11, 1, 2, 9, 24, '2011-12-15 13:13:54'),
(12, 1, 2, 10, 26, '2011-12-15 13:13:54'),
(13, NULL, 2, 6, 28, '2011-12-18 09:44:42'),
(14, NULL, 2, 9, 22, '2011-12-18 09:44:42'),
(15, NULL, 2, 10, 26, '2011-12-18 09:44:42');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `taxonomy`
--

CREATE TABLE IF NOT EXISTS `taxonomy` (
  `taxonomyId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `taxonomyRate` double(6,2) unsigned NOT NULL,
  `taxonomySorting` tinyint(4) unsigned DEFAULT NULL,
  PRIMARY KEY (`taxonomyId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Tablo döküm verisi `taxonomy`
--

INSERT INTO `taxonomy` (`taxonomyId`, `taxonomyRate`, `taxonomySorting`) VALUES
(1, 0.08, 2),
(2, 0.18, 3),
(3, 0.27, 4),
(4, 0.00, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `taxonomy_i18n`
--

CREATE TABLE IF NOT EXISTS `taxonomy_i18n` (
  `taxonomyId` int(11) unsigned NOT NULL,
  `iso639Id` int(11) unsigned NOT NULL,
  `taxonomyTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`taxonomyId`,`iso639Id`),
  KEY `taxonomyi18n_ibfk_2` (`iso639Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `taxonomy_i18n`
--

INSERT INTO `taxonomy_i18n` (`taxonomyId`, `iso639Id`, `taxonomyTitle`) VALUES
(1, 1, 'KDV 8%'),
(1, 2, 'VAT 8%'),
(2, 1, 'KDV 18%'),
(2, 2, 'VAT 18%'),
(3, 1, 'ÖTV 27%'),
(3, 2, 'SCT 27%'),
(4, 1, 'Vergi yok'),
(4, 2, 'No Tax');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `transportation`
--

CREATE TABLE IF NOT EXISTS `transportation` (
  `transportationId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `transportationSorting` tinyint(4) unsigned DEFAULT NULL,
  `transportationPrice` decimal(17,2) unsigned DEFAULT NULL,
  PRIMARY KEY (`transportationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Tablo döküm verisi `transportation`
--

INSERT INTO `transportation` (`transportationId`, `transportationSorting`, `transportationPrice`) VALUES
(18, NULL, 1.00);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `transportationimpact`
--

CREATE TABLE IF NOT EXISTS `transportationimpact` (
  `transportationimpactId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `transportationId` int(11) unsigned NOT NULL,
  `transportationimpactWeight` float unsigned DEFAULT NULL,
  `transportationimpactPrice` decimal(17,2) unsigned DEFAULT NULL,
  PRIMARY KEY (`transportationimpactId`),
  KEY `transportationId` (`transportationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `transportation_i18n`
--

CREATE TABLE IF NOT EXISTS `transportation_i18n` (
  `transportationId` int(11) unsigned NOT NULL,
  `iso639Id` int(11) unsigned NOT NULL,
  `transportationTitle` varchar(255) DEFAULT NULL,
  `transportationContent` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`transportationId`,`iso639Id`),
  KEY `transportationi18n_ibfk_2` (`iso639Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `transportation_i18n`
--

INSERT INTO `transportation_i18n` (`transportationId`, `iso639Id`, `transportationTitle`, `transportationContent`) VALUES
(18, 1, 'Aras Kargo', ''),
(18, 2, '', '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `transportation_picture`
--

CREATE TABLE IF NOT EXISTS `transportation_picture` (
  `transportationId` int(11) unsigned NOT NULL,
  `pictureId` int(11) unsigned NOT NULL,
  `isDefault` tinyint(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`transportationId`,`pictureId`),
  UNIQUE KEY `transportationId` (`transportationId`,`isDefault`),
  KEY `pictureId` (`pictureId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `transportation_picture`
--

INSERT INTO `transportation_picture` (`transportationId`, `pictureId`, `isDefault`) VALUES
(18, 368, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userStatus` tinyint(1) unsigned DEFAULT NULL,
  `userName` varchar(255) NOT NULL,
  `userPass` varchar(255) NOT NULL,
  `userEmail` varchar(255) NOT NULL,
  `userFirstname` varchar(255) DEFAULT NULL,
  `userLastname` varchar(255) DEFAULT NULL,
  `userBirthdate` date DEFAULT NULL,
  `userGender` enum('F','M') DEFAULT NULL,
  `userPhone` varchar(255) DEFAULT NULL,
  `userTckn` varchar(11) DEFAULT NULL,
  `userCoordinate` point DEFAULT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `userName` (`userName`),
  UNIQUE KEY `userEmail` (`userEmail`),
  UNIQUE KEY `userTckn` (`userTckn`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Tablo döküm verisi `user`
--

INSERT INTO `user` (`userId`, `userStatus`, `userName`, `userPass`, `userEmail`, `userFirstname`, `userLastname`, `userBirthdate`, `userGender`, `userPhone`, `userTckn`, `userCoordinate`) VALUES
(1, 1, 'cem@casict.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'cem@casict.com', 'admin1', '59500321252', '1975-06-08', 'M', '5337421059', '59500321252', NULL),
(2, 1, 'cem@medyaproje.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'cem@medyaproje.com', 'b2c', '25751023498', '1975-06-08', 'M', '5337421059', '25751023498', 0x000000000101000000c883efbfbd2f6e7e444065efbfbd00233d40),
(3, 1, 'cemselman@yahoo.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'cemselman@yahoo.com', 'b2b', 'Kullanıcısı', '1975-06-08', 'M', '5337421059', NULL, NULL),
(4, 1, 'casict@casict.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'casict@casict.com', 'promo', 'shop', '1975-06-08', 'M', '5337421059', NULL, NULL),
(5, 1, 'dcselman@gmail1.com', '401c48471a8e4f1d4b34ccd4ed2f539367699346', 'dcselman@gmail1.com', 'private', 'shop', '1975-06-08', 'M', '5337421059', NULL, 0x000000000101000000efbfbd6fefbfbd576e7e44405fefbfbdefbfbd3301233d40),
(10, 1, 'ramazan@medyaproje.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'ramazan@medyaproje.com', 'Ramazan', 'Ayyıldız', '1983-02-04', 'M', '5333530908', NULL, NULL),
(11, 1, 'hazar@medyaproje.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'hazar@medyaproje.com', 'Hazar', 'Artuner', '2011-03-20', 'F', '5303877733', '50365219876', NULL),
(12, 1, 'kerem@medyaproje.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'kerem@medyaproje.com', 'Kerem', 'Özdemir', '1981-03-06', 'M', '5428497404', NULL, NULL),
(20, 1, 'ramazan.ayyildiz@gmail.com', 'eb61ae06de4ee4074cbefc0f703072422e18b909', 'ramazan.ayyildiz@gmail.com', 'Ramazan', 'Ayyıldız', '1983-02-04', 'M', '5333530908', '51559348280', NULL),
(21, 1, 'ramazanayyildiz@hotmail.com', 'edcd6699a687677a925d17a7ca1a1eecad79f6db', 'ramazanayyildiz@hotmail.com', 'Ramazan', 'Ayyıldız', '1983-02-04', 'M', '5333530908', NULL, NULL),
(22, 1, 'hazar.artuner@gmail.com', 'e7fa64edf1fccfbc1b83e3b068fd8ecd5408bb04', 'hazar.artuner@gmail.com', 'Hazar', 'Artuner', NULL, 'M', NULL, NULL, NULL),
(23, 1, 'keremoz34@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'keremoz34@gmail.com', 'kerem', 'özdemir', '1981-03-06', 'M', '5428497404', '14489496780', NULL),
(24, 1, 'b2c@deneme.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'b2c@deneme.com', 'b2b', 'deneme', NULL, NULL, NULL, NULL, NULL),
(25, 1, 'b2b@deneme.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'b2b@deneme.com', 'b2c', 'deneme', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `usergroup`
--

CREATE TABLE IF NOT EXISTS `usergroup` (
  `usergroupId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usergroupTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`usergroupId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Tablo döküm verisi `usergroup`
--

INSERT INTO `usergroup` (`usergroupId`, `usergroupTitle`) VALUES
(1, 'Grup1'),
(2, 'Grup2'),
(3, 'Grup3');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `usergroup_user`
--

CREATE TABLE IF NOT EXISTS `usergroup_user` (
  `usergroupId` int(10) unsigned NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`usergroupId`,`userId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `usergroup_user`
--

INSERT INTO `usergroup_user` (`usergroupId`, `userId`) VALUES
(2, 1),
(1, 2),
(3, 2),
(2, 3),
(1, 4),
(3, 5);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `userpoint`
--

CREATE TABLE IF NOT EXISTS `userpoint` (
  `userpointId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) unsigned NOT NULL,
  `userpointtypeId` int(10) unsigned NOT NULL,
  `userpointAmount` int(10) unsigned DEFAULT NULL,
  `userpointDatetime` datetime DEFAULT NULL,
  PRIMARY KEY (`userpointId`),
  KEY `userId` (`userId`),
  KEY `userpointtypeId` (`userpointtypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `userpointtype`
--

CREATE TABLE IF NOT EXISTS `userpointtype` (
  `userpointtypeId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userpointtypeTitle` varchar(255) DEFAULT NULL,
  `userpointtypeAmount` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`userpointtypeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Tablo döküm verisi `userpointtype`
--

INSERT INTO `userpointtype` (`userpointtypeId`, `userpointtypeTitle`, `userpointtypeAmount`) VALUES
(1, 'Üyelik', 10),
(2, 'Alışveriş', 12),
(3, 'Yorum', 8),
(4, 'Tavsiye', 20);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `userticket`
--

CREATE TABLE IF NOT EXISTS `userticket` (
  `userticketId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userticketName` varchar(255) DEFAULT NULL,
  `userticketEmail` varchar(255) DEFAULT NULL,
  `userticketPhone` varchar(255) DEFAULT NULL,
  `userticketSubject` varchar(255) DEFAULT NULL,
  `userticketMessage` text,
  PRIMARY KEY (`userticketId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- Tablo döküm verisi `userticket`
--

INSERT INTO `userticket` (`userticketId`, `userticketName`, `userticketEmail`, `userticketPhone`, `userticketSubject`, `userticketMessage`) VALUES
(41, 'cem', 'dcselman@gmail.com', '533-742-1059', 'deneme', 'dedede');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `usertrack`
--

CREATE TABLE IF NOT EXISTS `usertrack` (
  `usertrackId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned DEFAULT NULL,
  `usertrackDatetime` datetime DEFAULT NULL,
  `usertrackIpn` int(11) unsigned DEFAULT NULL,
  `usertracktypeId` int(11) unsigned DEFAULT NULL,
  `usertrackNote` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`usertrackId`),
  KEY `usertracktypeId` (`usertracktypeId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `usertracktype`
--

CREATE TABLE IF NOT EXISTS `usertracktype` (
  `usertracktypeId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `usertracktypeTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`usertracktypeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Tablo döküm verisi `usertracktype`
--

INSERT INTO `usertracktype` (`usertracktypeId`, `usertracktypeTitle`) VALUES
(1, 'user login'),
(2, 'user logout'),
(3, 'show product'),
(4, 'show page'),
(5, 'user register'),
(6, 'user reminder'),
(7, 'shopping'),
(8, 'comment'),
(9, 'recommendation');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_deliveryaddress`
--

CREATE TABLE IF NOT EXISTS `user_deliveryaddress` (
  `userId` int(11) unsigned NOT NULL,
  `postaladdressId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`userId`,`postaladdressId`),
  KEY `postaladdressId` (`postaladdressId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `user_deliveryaddress`
--

INSERT INTO `user_deliveryaddress` (`userId`, `postaladdressId`) VALUES
(2, 24),
(1, 29),
(3, 54),
(3, 73),
(2, 86),
(3, 96),
(2, 98),
(11, 99),
(11, 101);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_friends`
--

CREATE TABLE IF NOT EXISTS `user_friends` (
  `userId` int(10) unsigned NOT NULL,
  `friendId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`userId`,`friendId`),
  KEY `friendId` (`friendId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_invoiceaddress`
--

CREATE TABLE IF NOT EXISTS `user_invoiceaddress` (
  `userId` int(11) unsigned NOT NULL,
  `postaladdressId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`userId`,`postaladdressId`),
  KEY `postaladdressId` (`postaladdressId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `user_invoiceaddress`
--

INSERT INTO `user_invoiceaddress` (`userId`, `postaladdressId`) VALUES
(2, 28),
(1, 30),
(3, 48),
(3, 74),
(2, 80),
(11, 100);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `userId` int(11) unsigned NOT NULL,
  `roleId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`userId`,`roleId`),
  KEY `roleId` (`roleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `user_role`
--

INSERT INTO `user_role` (`userId`, `roleId`) VALUES
(1, 1),
(10, 1),
(11, 1),
(12, 2),
(2, 3),
(20, 3),
(21, 3),
(22, 3),
(23, 3),
(24, 3),
(3, 4),
(25, 4);

-- --------------------------------------------------------

--
-- Görünüm yapısı durumu `view_productattributeprice`
--
CREATE TABLE IF NOT EXISTS `view_productattributeprice` (
`productattributeId` int(11) unsigned
,`roleId` int(11) unsigned
,`productPrice` decimal(17,2) unsigned
,`productattributepriceM` decimal(17,2) unsigned
,`productattributepriceMD` double(19,2)
,`productattributepriceMV` decimal(17,2) unsigned
,`productattributepriceMDV` double(19,2)
);
-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `voucher`
--

CREATE TABLE IF NOT EXISTS `voucher` (
  `voucherId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `voucherTitle` varchar(255) DEFAULT NULL,
  `voucherStart` datetime DEFAULT NULL,
  `voucherEnd` datetime DEFAULT NULL,
  `voucherDiscountRate` float unsigned DEFAULT NULL,
  `voucherDiscountPrice` decimal(17,2) unsigned DEFAULT NULL,
  PRIMARY KEY (`voucherId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Tablo döküm verisi `voucher`
--

INSERT INTO `voucher` (`voucherId`, `voucherTitle`, `voucherStart`, `voucherEnd`, `voucherDiscountRate`, `voucherDiscountPrice`) VALUES
(1, 'voucher 1', '2012-02-01 18:02:26', '2012-03-10 18:02:30', 0.1, NULL),
(2, 'voucher 2', '2012-02-07 18:02:34', '2012-03-02 18:02:38', 0.2, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `vouchercode`
--

CREATE TABLE IF NOT EXISTS `vouchercode` (
  `voucherId` int(10) unsigned NOT NULL DEFAULT '0',
  `voucherCode` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`voucherId`,`voucherCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `vouchercode`
--

INSERT INTO `vouchercode` (`voucherId`, `voucherCode`) VALUES
(1, '10DXUY2MLI'),
(1, '14HNN0Z2LZ'),
(1, '17Q6SQ2RKR'),
(1, '18QDSKSNAO'),
(1, '19SJ8FOLDD'),
(1, '1DPF2VENXU'),
(1, '1OJMD6DSY8'),
(1, '2FDZN4U5WT'),
(1, '313TEYKGYU'),
(1, '3DJZGUQM7I'),
(1, '3YVOMCAPMF'),
(1, '40254WAEFV'),
(1, '4MR4UHALNZ'),
(1, '56QT03K2K1'),
(1, '5FKREFE0WS'),
(1, '5LE2IKH7QI'),
(1, '5STF547RQA'),
(1, '5VFL84F92X'),
(1, '62ZE2R0H9U'),
(1, '660OMQCYDK'),
(1, '6HLK0JT1N8'),
(1, '6UCB6CFXE3'),
(1, '6Y0X35YV1O'),
(1, '7YQ8XL8MHN'),
(1, '82Y21MYUB9'),
(1, '86BJKQ2UDZ'),
(1, '8GWFRWM2UY'),
(1, '8KGYMO5CZ5'),
(1, '8S5S0B95QA'),
(1, '98Z9OE5SGX'),
(1, '9DSF6J0LFC'),
(1, '9ECHJGBT2Y'),
(1, 'A1V7KKRNQU'),
(1, 'A4EGW0BZU1'),
(1, 'A5Y61P2MK0'),
(1, 'AE94L41ORA'),
(1, 'ALEYWFAUS6'),
(1, 'AX21H74PLW'),
(1, 'BEM59HH9FV'),
(1, 'BKI6C7J0QN'),
(1, 'BMYYII6ZI9'),
(1, 'BRYTI0HAIV'),
(1, 'BTTI990XIF'),
(1, 'CF8G71I0LD'),
(1, 'CHC5LC9EE5'),
(1, 'COVIR1LN6X'),
(1, 'CQNGZ6X7Z5'),
(1, 'EB3T0K5T4N'),
(1, 'EEEG757A4Z'),
(1, 'F1PKLCF6KZ'),
(1, 'F3MXEN0LED'),
(1, 'F4CYW4SQ6W'),
(1, 'F9GNFM29LG'),
(1, 'FAR8ZAS6W5'),
(1, 'FB0CRHEGKN'),
(1, 'FOZ57A64O2'),
(1, 'G9DLNPIHK6'),
(1, 'GAKY267NJD'),
(1, 'GBQAU05RUZ'),
(1, 'GLLDUTIV3S'),
(1, 'GM5JUAJ5PB'),
(1, 'GNBZXR9W9P'),
(1, 'GRSJ7RCYOJ'),
(1, 'GYDXL60WZL'),
(1, 'GZ9D4TLQEV'),
(1, 'H54WACUYY7'),
(1, 'H75JDZW23Q'),
(1, 'H8PB8B8QJC'),
(1, 'HSY0SQWPBV'),
(1, 'I18EFLMQV1'),
(1, 'I42XN0MAHP'),
(1, 'IEGZ9UV2LJ'),
(1, 'IK42INFZYN'),
(1, 'IT0QRIISMR'),
(1, 'JPYXZCJQF9'),
(1, 'KGCI3T9GVX'),
(1, 'L60XY07OUQ'),
(1, 'L691GF41XI'),
(1, 'LFPI4G6021'),
(1, 'LOR164EGJO'),
(1, 'LVIP68A6CL'),
(1, 'M6VQMG6822'),
(1, 'MKX7SF3YQB'),
(1, 'MM9GDVFHZI'),
(1, 'MMMWPXS9YD'),
(1, 'MN7FUQSK1Q'),
(1, 'MOZF3EIJWH'),
(1, 'N1NUUVQPVQ'),
(1, 'N5FSR2SVLX'),
(1, 'NC8PV0NDJB'),
(1, 'O2HXCKFOLS'),
(1, 'ON3SMKMPGY'),
(1, 'P82O822G11'),
(1, 'PCQELULYYW'),
(1, 'PKMROS0HC9'),
(1, 'QN1XMRGW0T'),
(1, 'QNZHN8XVRY'),
(1, 'QXOS0YK8BL'),
(1, 'RNK9QO4FBE'),
(1, 'RS04G70GLH'),
(1, 'RSBAQN69QY'),
(1, 'S0QIQUUPSQ'),
(1, 'S719LKK6GB'),
(1, 'SHUJULPU5J'),
(1, 'SIW3IOM2DQ'),
(1, 'SS1LAM0VQK'),
(1, 'SWMML8NU9E'),
(1, 'TET44NK6TC'),
(1, 'TG8UB2A2TL'),
(1, 'TJ4IIS17RK'),
(1, 'TNPAQSFW1B'),
(1, 'VPUAJX2HZS'),
(2, '21MZOIJOEP'),
(2, '703Y41TATN'),
(2, 'D6LX1KSDMG'),
(2, 'DDHOYB6VUO'),
(2, 'DXYI09JSUL'),
(2, 'IHMWZTV20T'),
(2, 'IKCND9FRE1'),
(2, 'Q4N9UP4UM3'),
(2, 'RIY6AZFHBO'),
(2, 'TOBTW376QI');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `warranty`
--

CREATE TABLE IF NOT EXISTS `warranty` (
  `warrantyId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `warrantyPeriod` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`warrantyId`),
  UNIQUE KEY `warrantyPeriod` (`warrantyPeriod`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `warranty`
--

INSERT INTO `warranty` (`warrantyId`, `warrantyPeriod`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Görünüm yapısı `view_productattributeprice`
--
DROP TABLE IF EXISTS `view_productattributeprice`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_productattributeprice` AS select `productattribute`.`productattributeId` AS `productattributeId`,`productimpact`.`roleId` AS `roleId`,`productimpact`.`productPrice` AS `productPrice`,`productimpact`.`productPrice` AS `productattributepriceM`,round(((`productimpact`.`productPrice` * (1 - ifnull(`productimpact`.`productimpactDiscountRate`,0))) - ifnull(`productimpact`.`productimpactDiscountPrice`,0)),2) AS `productattributepriceMD`,`productimpact`.`productPrice` AS `productattributepriceMV`,round(((`productimpact`.`productPrice` * (1 - ifnull(`productimpact`.`productimpactDiscountRate`,0))) - ifnull(`productimpact`.`productimpactDiscountPrice`,0)),2) AS `productattributepriceMDV` from (((`productattribute` left join `productimpact` on((`productimpact`.`productId` = `productattribute`.`productId`))) left join `product` on((`product`.`productId` = `productattribute`.`productId`))) left join `taxonomy` on((`taxonomy`.`taxonomyId` = `product`.`taxonomyId`)));

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `attribute`
--
ALTER TABLE `attribute`
  ADD CONSTRAINT `attribute_ibfk_1` FOREIGN KEY (`attributegroupId`) REFERENCES `attributegroup` (`attributegroupId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `attributegroup_i18n`
--
ALTER TABLE `attributegroup_i18n`
  ADD CONSTRAINT `attributegroup_i18n_ibfk_1` FOREIGN KEY (`attributegroupId`) REFERENCES `attributegroup` (`attributegroupId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attributegroup_i18n_ibfk_2` FOREIGN KEY (`iso639Id`) REFERENCES `iso639` (`iso639Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `attributeimpact`
--
ALTER TABLE `attributeimpact`
  ADD CONSTRAINT `attributeimpact_ibfk_2` FOREIGN KEY (`attributeId`) REFERENCES `attribute` (`attributeId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attributeimpact_ibfk_3` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `attribute_i18n`
--
ALTER TABLE `attribute_i18n`
  ADD CONSTRAINT `attribute_i18n_ibfk_1` FOREIGN KEY (`attributeId`) REFERENCES `attribute` (`attributeId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attribute_i18n_ibfk_2` FOREIGN KEY (`iso639Id`) REFERENCES `iso639` (`iso639Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `bankbin`
--
ALTER TABLE `bankbin`
  ADD CONSTRAINT `bankbin_ibfk_1` FOREIGN KEY (`bankCode`) REFERENCES `bank` (`bankCode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bankbin_ibfk_2` FOREIGN KEY (`bankCode2`) REFERENCES `bank` (`bankCode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `banner_picture`
--
ALTER TABLE `banner_picture`
  ADD CONSTRAINT `banner_picture_ibfk_1` FOREIGN KEY (`bannerId`) REFERENCES `banner` (`bannerId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `banner_picture_ibfk_2` FOREIGN KEY (`pictureId`) REFERENCES `picture` (`pictureId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `brand_picture`
--
ALTER TABLE `brand_picture`
  ADD CONSTRAINT `brand_picture_ibfk_1` FOREIGN KEY (`brandId`) REFERENCES `brand` (`brandId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `brand_picture_ibfk_2` FOREIGN KEY (`pictureId`) REFERENCES `picture` (`pictureId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`categoryParent`) REFERENCES `category` (`categoryId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `category_i18n`
--
ALTER TABLE `category_i18n`
  ADD CONSTRAINT `category_i18n_ibfk_2` FOREIGN KEY (`iso639Id`) REFERENCES `iso639` (`iso639Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category_i18n_ibfk_3` FOREIGN KEY (`categoryId`) REFERENCES `category` (`categoryId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `category_picture`
--
ALTER TABLE `category_picture`
  ADD CONSTRAINT `category_picture_ibfk_2` FOREIGN KEY (`pictureId`) REFERENCES `picture` (`pictureId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category_picture_ibfk_3` FOREIGN KEY (`categoryId`) REFERENCES `category` (`categoryId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `company_picture`
--
ALTER TABLE `company_picture`
  ADD CONSTRAINT `company_picture_ibfk_1` FOREIGN KEY (`companyId`) REFERENCES `company` (`companyId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `company_picture_ibfk_2` FOREIGN KEY (`pictureId`) REFERENCES `picture` (`pictureId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `iso639_picture`
--
ALTER TABLE `iso639_picture`
  ADD CONSTRAINT `iso639_picture_ibfk_1` FOREIGN KEY (`iso639Id`) REFERENCES `iso639` (`iso639Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `iso639_picture_ibfk_2` FOREIGN KEY (`pictureId`) REFERENCES `picture` (`pictureId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `page`
--
ALTER TABLE `page`
  ADD CONSTRAINT `page_ibfk_1` FOREIGN KEY (`pageParent`) REFERENCES `page` (`pageId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `page_i18n`
--
ALTER TABLE `page_i18n`
  ADD CONSTRAINT `page_i18n_ibfk_2` FOREIGN KEY (`iso639Id`) REFERENCES `iso639` (`iso639Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `page_i18n_ibfk_3` FOREIGN KEY (`pageId`) REFERENCES `page` (`pageId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `page_picture`
--
ALTER TABLE `page_picture`
  ADD CONSTRAINT `page_picture_ibfk_2` FOREIGN KEY (`pictureId`) REFERENCES `picture` (`pictureId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `page_picture_ibfk_3` FOREIGN KEY (`pageId`) REFERENCES `page` (`pageId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`paymentgroupId`) REFERENCES `paymentgroup` (`paymentgroupId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `paymentgroup`
--
ALTER TABLE `paymentgroup`
  ADD CONSTRAINT `paymentgroup_ibfk_1` FOREIGN KEY (`bankCode`) REFERENCES `bank` (`bankCode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `paymentgroup_i18n`
--
ALTER TABLE `paymentgroup_i18n`
  ADD CONSTRAINT `paymentgroup_i18n_ibfk_2` FOREIGN KEY (`iso639Id`) REFERENCES `iso639` (`iso639Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `paymentgroup_i18n_ibfk_3` FOREIGN KEY (`paymentgroupId`) REFERENCES `paymentgroup` (`paymentgroupId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `paymentgroup_picture`
--
ALTER TABLE `paymentgroup_picture`
  ADD CONSTRAINT `paymentgroup_picture_ibfk_1` FOREIGN KEY (`paymentgroupId`) REFERENCES `paymentgroup` (`paymentgroupId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `paymentgroup_picture_ibfk_2` FOREIGN KEY (`pictureId`) REFERENCES `picture` (`pictureId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `paymentgroup_transportation`
--
ALTER TABLE `paymentgroup_transportation`
  ADD CONSTRAINT `paymentgroup_transportation_ibfk_3` FOREIGN KEY (`paymentgroupId`) REFERENCES `paymentgroup` (`paymentgroupId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `paymentgroup_transportation_ibfk_4` FOREIGN KEY (`transportationId`) REFERENCES `transportation` (`transportationId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `paymentimpact`
--
ALTER TABLE `paymentimpact`
  ADD CONSTRAINT `paymentimpact_ibfk_1` FOREIGN KEY (`paymentId`) REFERENCES `payment` (`paymentId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `payment_i18n`
--
ALTER TABLE `payment_i18n`
  ADD CONSTRAINT `payment_i18n_ibfk_1` FOREIGN KEY (`paymentId`) REFERENCES `payment` (`paymentId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payment_i18n_ibfk_2` FOREIGN KEY (`iso639Id`) REFERENCES `iso639` (`iso639Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `permission`
--
ALTER TABLE `permission`
  ADD CONSTRAINT `permission_ibfk_1` FOREIGN KEY (`permissionParent`) REFERENCES `permission` (`permissionId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `permission_i18n`
--
ALTER TABLE `permission_i18n`
  ADD CONSTRAINT `permission_i18n_ibfk_2` FOREIGN KEY (`iso639Id`) REFERENCES `iso639` (`iso639Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_i18n_ibfk_3` FOREIGN KEY (`permissionId`) REFERENCES `permission` (`permissionId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `postaladdress`
--
ALTER TABLE `postaladdress`
  ADD CONSTRAINT `postaladdress_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_13` FOREIGN KEY (`brandId`) REFERENCES `brand` (`brandId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_14` FOREIGN KEY (`taxonomyId`) REFERENCES `taxonomy` (`taxonomyId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_15` FOREIGN KEY (`categoryId`) REFERENCES `category` (`categoryId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_16` FOREIGN KEY (`warrantyId`) REFERENCES `warranty` (`warrantyId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `productattribute`
--
ALTER TABLE `productattribute`
  ADD CONSTRAINT `productattribute_ibfk_3` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `productattributemovement`
--
ALTER TABLE `productattributemovement`
  ADD CONSTRAINT `productattributemovement_ibfk_4` FOREIGN KEY (`productattributeId`) REFERENCES `productattribute` (`productattributeId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productattributemovement_ibfk_5` FOREIGN KEY (`supplierId`) REFERENCES `supplier` (`supplierId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `productattribute_attribute`
--
ALTER TABLE `productattribute_attribute`
  ADD CONSTRAINT `productattribute_attribute_ibfk_2` FOREIGN KEY (`attributeId`) REFERENCES `attribute` (`attributeId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productattribute_attribute_ibfk_3` FOREIGN KEY (`productattributeId`) REFERENCES `productattribute` (`productattributeId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `productcomment`
--
ALTER TABLE `productcomment`
  ADD CONSTRAINT `productcomment_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productcomment_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `productgroup_i18n`
--
ALTER TABLE `productgroup_i18n`
  ADD CONSTRAINT `productgroup_i18n_ibfk_1` FOREIGN KEY (`productgroupId`) REFERENCES `productgroup` (`productgroupId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productgroup_i18n_ibfk_2` FOREIGN KEY (`iso639Id`) REFERENCES `iso639` (`iso639Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `productgroup_product`
--
ALTER TABLE `productgroup_product`
  ADD CONSTRAINT `productgroup_product_ibfk_1` FOREIGN KEY (`productgroupId`) REFERENCES `productgroup` (`productgroupId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productgroup_product_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `productimpact`
--
ALTER TABLE `productimpact`
  ADD CONSTRAINT `productimpact_ibfk_2` FOREIGN KEY (`roleId`) REFERENCES `role` (`roleId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productimpact_ibfk_3` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `productorder`
--
ALTER TABLE `productorder`
  ADD CONSTRAINT `productorder_ibfk_11` FOREIGN KEY (`paymentId`) REFERENCES `payment` (`paymentId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productorder_ibfk_12` FOREIGN KEY (`transportationId`) REFERENCES `transportation` (`transportationId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productorder_ibfk_13` FOREIGN KEY (`deliveryaddressId`) REFERENCES `postaladdress` (`postaladdressId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productorder_ibfk_14` FOREIGN KEY (`invoiceaddressId`) REFERENCES `postaladdress` (`postaladdressId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productorder_ibfk_15` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productorder_ibfk_17` FOREIGN KEY (`productorderstatusId`) REFERENCES `productorderstatus` (`productorderstatusId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `productorderstatus_i18n`
--
ALTER TABLE `productorderstatus_i18n`
  ADD CONSTRAINT `productorderstatus_i18n_ibfk_2` FOREIGN KEY (`iso639Id`) REFERENCES `iso639` (`iso639Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productorderstatus_i18n_ibfk_3` FOREIGN KEY (`productorderstatusId`) REFERENCES `productorderstatus` (`productorderstatusId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `productsalesmovement`
--
ALTER TABLE `productsalesmovement`
  ADD CONSTRAINT `productsalesmovement_ibfk_5` FOREIGN KEY (`productattributeId`) REFERENCES `productattribute` (`productattributeId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productsalesmovement_ibfk_6` FOREIGN KEY (`productorderId`) REFERENCES `productorder` (`productorderId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `product_category_ibfk_2` FOREIGN KEY (`categoryId`) REFERENCES `category` (`categoryId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_category_ibfk_3` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `product_picture`
--
ALTER TABLE `product_picture`
  ADD CONSTRAINT `product_picture_ibfk_2` FOREIGN KEY (`pictureId`) REFERENCES `picture` (`pictureId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_picture_ibfk_3` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `product_user`
--
ALTER TABLE `product_user`
  ADD CONSTRAINT `product_user_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_user_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `retailer_company`
--
ALTER TABLE `retailer_company`
  ADD CONSTRAINT `retailer_company_ibfk_1` FOREIGN KEY (`retailerId`) REFERENCES `retailer` (`retailerId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `retailer_company_ibfk_2` FOREIGN KEY (`companyId`) REFERENCES `company` (`companyId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `retailer_user`
--
ALTER TABLE `retailer_user`
  ADD CONSTRAINT `retailer_user_ibfk_1` FOREIGN KEY (`retailerId`) REFERENCES `retailer` (`retailerId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `retailer_user_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `role_permission`
--
ALTER TABLE `role_permission`
  ADD CONSTRAINT `role_permission_ibfk_1` FOREIGN KEY (`permissionId`) REFERENCES `permission` (`permissionId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_permission_ibfk_2` FOREIGN KEY (`roleId`) REFERENCES `role` (`roleId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `salescampaign_picture`
--
ALTER TABLE `salescampaign_picture`
  ADD CONSTRAINT `salescampaign_picture_ibfk_2` FOREIGN KEY (`pictureId`) REFERENCES `picture` (`pictureId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salescampaign_picture_ibfk_3` FOREIGN KEY (`salescampaignId`) REFERENCES `salescampaign` (`salescampaignId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `salescampaign_productattribute`
--
ALTER TABLE `salescampaign_productattribute`
  ADD CONSTRAINT `salescampaign_productattribute_ibfk_2` FOREIGN KEY (`productattributeId`) REFERENCES `productattribute` (`productattributeId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salescampaign_productattribute_ibfk_3` FOREIGN KEY (`salescampaignId`) REFERENCES `salescampaign` (`salescampaignId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `supplier_company`
--
ALTER TABLE `supplier_company`
  ADD CONSTRAINT `supplier_company_ibfk_1` FOREIGN KEY (`supplierId`) REFERENCES `supplier` (`supplierId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `supplier_company_ibfk_2` FOREIGN KEY (`companyId`) REFERENCES `company` (`companyId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `surveya`
--
ALTER TABLE `surveya`
  ADD CONSTRAINT `surveya_ibfk_1` FOREIGN KEY (`surveyqId`) REFERENCES `surveyq` (`surveyqId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `surveyq`
--
ALTER TABLE `surveyq`
  ADD CONSTRAINT `surveyq_ibfk_1` FOREIGN KEY (`surveyId`) REFERENCES `survey` (`surveyId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `surveyr`
--
ALTER TABLE `surveyr`
  ADD CONSTRAINT `surveyr_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `surveyr_ibfk_2` FOREIGN KEY (`surveyId`) REFERENCES `survey` (`surveyId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `surveyr_ibfk_3` FOREIGN KEY (`surveyqId`) REFERENCES `surveyq` (`surveyqId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `surveyr_ibfk_4` FOREIGN KEY (`surveyaId`) REFERENCES `surveya` (`surveyaId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `taxonomy_i18n`
--
ALTER TABLE `taxonomy_i18n`
  ADD CONSTRAINT `taxonomy_i18n_ibfk_2` FOREIGN KEY (`iso639Id`) REFERENCES `iso639` (`iso639Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `taxonomy_i18n_ibfk_3` FOREIGN KEY (`taxonomyId`) REFERENCES `taxonomy` (`taxonomyId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `transportationimpact`
--
ALTER TABLE `transportationimpact`
  ADD CONSTRAINT `transportationimpact_ibfk_1` FOREIGN KEY (`transportationId`) REFERENCES `transportation` (`transportationId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `transportation_i18n`
--
ALTER TABLE `transportation_i18n`
  ADD CONSTRAINT `transportation_i18n_ibfk_2` FOREIGN KEY (`iso639Id`) REFERENCES `iso639` (`iso639Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transportation_i18n_ibfk_3` FOREIGN KEY (`transportationId`) REFERENCES `transportation` (`transportationId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `transportation_picture`
--
ALTER TABLE `transportation_picture`
  ADD CONSTRAINT `transportation_picture_ibfk_1` FOREIGN KEY (`transportationId`) REFERENCES `transportation` (`transportationId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transportation_picture_ibfk_2` FOREIGN KEY (`pictureId`) REFERENCES `picture` (`pictureId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `usergroup_user`
--
ALTER TABLE `usergroup_user`
  ADD CONSTRAINT `usergroup_user_ibfk_1` FOREIGN KEY (`usergroupId`) REFERENCES `usergroup` (`usergroupId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usergroup_user_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `userpoint`
--
ALTER TABLE `userpoint`
  ADD CONSTRAINT `userpoint_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userpoint_ibfk_2` FOREIGN KEY (`userpointtypeId`) REFERENCES `userpointtype` (`userpointtypeId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `usertrack`
--
ALTER TABLE `usertrack`
  ADD CONSTRAINT `usertrack_ibfk_3` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usertrack_ibfk_4` FOREIGN KEY (`usertracktypeId`) REFERENCES `usertracktype` (`usertracktypeId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `user_deliveryaddress`
--
ALTER TABLE `user_deliveryaddress`
  ADD CONSTRAINT `user_deliveryaddress_ibfk_2` FOREIGN KEY (`postaladdressId`) REFERENCES `postaladdress` (`postaladdressId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_deliveryaddress_ibfk_3` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `user_friends`
--
ALTER TABLE `user_friends`
  ADD CONSTRAINT `user_friends_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_friends_ibfk_2` FOREIGN KEY (`friendId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `user_invoiceaddress`
--
ALTER TABLE `user_invoiceaddress`
  ADD CONSTRAINT `user_invoiceaddress_ibfk_1` FOREIGN KEY (`postaladdressId`) REFERENCES `postaladdress` (`postaladdressId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_invoiceaddress_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_role_ibfk_2` FOREIGN KEY (`roleId`) REFERENCES `role` (`roleId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `vouchercode`
--
ALTER TABLE `vouchercode`
  ADD CONSTRAINT `vouchercode_ibfk_1` FOREIGN KEY (`voucherId`) REFERENCES `voucher` (`voucherId`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
