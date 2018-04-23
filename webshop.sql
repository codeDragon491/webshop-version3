-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Vært: localhost
-- Genereringstid: 23. 04 2018 kl. 13:24:39
-- Serverversion: 10.1.13-MariaDB
-- PHP-version: 7.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webshop`
--

DELIMITER $$
--
-- Procedurer
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `CountOrderByStatus` (IN `orderStatus` VARCHAR(25), OUT `total` INT)  BEGIN
 SELECT count(orderNumber)
 INTO total
 FROM orders
 WHERE status = orderStatus;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `FindSubscriberById` (IN `id` INT(10))  READS SQL DATA
BEGIN
SELECT firstName, lastName, email FROM subscribers WHERE subscriberId=id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUsers` (IN `first_name` VARCHAR(100), OUT `totalUsers` INT)  BEGIN
    SELECT COUNT(userId) INTO totalUsers
    FROM users
    WHERE firstName = first_name;
    SELECT * FROM users
    WHERE firstName = first_name;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `setCounter` (INOUT `count` INT(4), IN `inc` INT(4))  BEGIN
 SET count = count + inc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `totalOrders` (OUT `totalOrders` INT)  NO SQL
BEGIN
SELECT COUNT(orderNumber) INTO totalOrders FROM orders;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `orderDetails`
--

CREATE TABLE `orderDetails` (
  `products_productCode` bigint(20) UNSIGNED NOT NULL,
  `orders_orderNumber` bigint(20) UNSIGNED NOT NULL,
  `quantityOrdered` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `orderDetails`
--

INSERT INTO `orderDetails` (`products_productCode`, `orders_orderNumber`, `quantityOrdered`) VALUES
(103106833104, 203106833104, '105'),
(103574586138, 203574586138, '3'),
(105099362693, 205099362693, '255'),
(105099362693, 205099362694, '1');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `orders`
--

CREATE TABLE `orders` (
  `orderNumber` bigint(20) UNSIGNED NOT NULL,
  `orderDate` date DEFAULT NULL,
  `shippedDate` date DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `users_userId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `orders`
--

INSERT INTO `orders` (`orderNumber`, `orderDate`, `shippedDate`, `status`, `users_userId`) VALUES
(203106833104, '2017-12-14', '2017-12-15', 'shipped', 112),
(203574586138, '2017-12-03', '2017-12-05', 'awaiting payment', 118),
(205099362693, '2017-12-18', '2017-12-20', 'completed', 119),
(205099362694, '2017-12-26', NULL, 'awaiting shipment', 114);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `payments`
--

CREATE TABLE `payments` (
  `checkNumber` bigint(20) UNSIGNED NOT NULL,
  `paymentDate` date DEFAULT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `users_userId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `payments`
--

INSERT INTO `payments` (`checkNumber`, `paymentDate`, `amount`, `users_userId`) VALUES
(303106833104, '2017-12-14', '999999.99', 112);

-- --------------------------------------------------------

--
-- Stand-in-struktur for visning `popularproducts`
--
CREATE TABLE `popularproducts` (
`productCode` bigint(20) unsigned
,`productName` varchar(45)
,`buyPrice` decimal(7,2) unsigned
,`image` varchar(45)
);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `products`
--

CREATE TABLE `products` (
  `productCode` bigint(20) UNSIGNED NOT NULL,
  `productName` varchar(45) DEFAULT NULL,
  `productDescription` text,
  `quantityInStock` smallint(5) UNSIGNED DEFAULT NULL,
  `buyPrice` decimal(7,2) UNSIGNED DEFAULT NULL,
  `image` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `products`
--

INSERT INTO `products` (`productCode`, `productName`, `productDescription`, `quantityInStock`, `buyPrice`, `image`) VALUES
(103106833104, 'E', NULL, 396, '500.00', 'images/productimage-59d743233c0cf.jpg'),
(103574586138, 'D', NULL, 499, '455.00', 'images/productimage-5a339cd554601.jpg'),
(103666641666, 'B', NULL, 167, '800.00', 'images/productimage-5a339c5243c5b.jpg'),
(104368702727, 'A', NULL, 100, '599.00', 'images/productimage-5a339c2f8837c.jpg'),
(105099362693, 'C', NULL, 255, '645.00', 'images/productimage-5a339c729caf9.jpg'),
(109848836780, 'F', NULL, 499, '500.00', 'images/productimage-5a339d2a3895c.jpg');

--
-- Triggers/udløsere `products`
--
DELIMITER $$
CREATE TRIGGER `products_AUPD` AFTER UPDATE ON `products` FOR EACH ROW BEGIN
INSERT INTO products_log VALUES (user(), CONCAT('Update Product Record',
         OLD.productName,' Previous Quantity In Stock :',OLD.quantityInStock,' Current Quantity In Stock ',
         NEW.quantityInStock));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `products_log`
--

CREATE TABLE `products_log` (
  `userId` varchar(45) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `products_log`
--

INSERT INTO `products_log` (`userId`, `description`) VALUES
('root@localhost', 'Update Product Record C Previous Quantity In Stock :222 Current Quantity In Stock 255'),
('root@localhost', 'Update Product Record D Previous Quantity In Stock :500 Current Quantity In Stock 499'),
('root@localhost', 'Update Product Record B Previous Quantity In Stock :168 Current Quantity In Stock 167'),
('root@localhost', 'Update Product RecordE Previous Quantity In Stock :396 Current Quantity In Stock 396'),
('root@localhost', 'Update Product RecordD Previous Quantity In Stock :499 Current Quantity In Stock 499'),
('root@localhost', 'Update Product RecordB Previous Quantity In Stock :167 Current Quantity In Stock 167'),
('root@localhost', 'Update Product RecordA Previous Quantity In Stock :100 Current Quantity In Stock 100'),
('root@localhost', 'Update Product RecordC Previous Quantity In Stock :255 Current Quantity In Stock 255'),
('root@localhost', 'Update Product RecordF Previous Quantity In Stock :499 Current Quantity In Stock 499'),
('root@localhost', 'Update Product RecordA Previous Quantity In Stock :100 Current Quantity In Stock 100'),
('root@localhost', 'Update Product RecordC Previous Quantity In Stock :255 Current Quantity In Stock 255'),
('root@localhost', 'Update Product RecordF Previous Quantity In Stock :499 Current Quantity In Stock 499'),
('root@localhost', 'Update Product RecordD Previous Quantity In Stock :499 Current Quantity In Stock 499'),
('root@localhost', 'Update Product RecordB Previous Quantity In Stock :167 Current Quantity In Stock 167'),
('root@localhost', 'Update Product RecordE Previous Quantity In Stock :396 Current Quantity In Stock 396');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `subscribers`
--

CREATE TABLE `subscribers` (
  `subscriberId` int(10) UNSIGNED NOT NULL,
  `email` varchar(90) DEFAULT NULL,
  `firstName` varchar(45) DEFAULT NULL,
  `lastName` varchar(45) DEFAULT NULL,
  `geoLocationLatitude` double DEFAULT NULL,
  `geoLocationLongtitude` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `subscribers`
--

INSERT INTO `subscribers` (`subscriberId`, `email`, `firstName`, `lastName`, `geoLocationLatitude`, `geoLocationLongtitude`) VALUES
(1, 'b@b.dk', 'B', 'B', 55.695728538301424, 12.545185089111328),
(2, 'f@f.dk', 'F', 'F', 55.69103606456661, 12.550077438354492);

--
-- Triggers/udløsere `subscribers`
--
DELIMITER $$
CREATE TRIGGER `subscribers_BIN` BEFORE INSERT ON `subscribers` FOR EACH ROW BEGIN
SET NEW.email = TRIM(NEW.email);
SET NEW.firstName = TRIM(NEW.firstName);
SET NEW.lastName = TRIM(NEW.lastName);
SET NEW.geoLocationLatitude = TRIM(NEW.geoLocationLatitude);
SET NEW.geoLocationLongtitude = TRIM(NEW.geoLocationLongtitude);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `userRoles`
--

CREATE TABLE `userRoles` (
  `roleId` tinyint(3) UNSIGNED NOT NULL,
  `userRole` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `userRoles`
--

INSERT INTO `userRoles` (`roleId`, `userRole`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `users`
--

CREATE TABLE `users` (
  `userId` int(10) UNSIGNED NOT NULL,
  `userName` varchar(45) DEFAULT NULL,
  `firstName` varchar(45) DEFAULT NULL,
  `lastName` varchar(45) DEFAULT NULL,
  `password` varchar(8) DEFAULT NULL,
  `image` varchar(45) DEFAULT NULL,
  `userRoles_roleId` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `users`
--

INSERT INTO `users` (`userId`, `userName`, `firstName`, `lastName`, `password`, `image`, `userRoles_roleId`) VALUES
(111, 'a@a.dk', 'A', 'A', '1', 'images/userimage-5a339b77ca69b.png', 1),
(112, 'b@b.dk', 'B', 'B', '1', 'images/userimage-5a3365476f633.png', 1),
(113, 'c@c.dk', 'C', 'C', '3', 'images/userimage-5a3365bf77e83.png', 2),
(114, 'd@d.dk', 'D', 'D', '4', 'images/userimage-5a33656e89605.png', 2),
(118, 'e@e.dk', 'E', 'E', '5', 'images/userimage-5a469c1b1ecd0.png', 2);

--
-- Triggers/udløsere `users`
--
DELIMITER $$
CREATE TRIGGER `users_BIN` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
SET NEW.userName = TRIM(NEW.userName);
SET NEW.firstName = TRIM(NEW.firstName);
SET NEW.lastName = TRIM(NEW.lastName);
SET NEW.password = TRIM(NEW.password);
SET NEW.image = TRIM(NEW.image);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur for visning `popularproducts`
--
DROP TABLE IF EXISTS `popularproducts`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `popularproducts`  AS  select `products`.`productCode` AS `productCode`,`products`.`productName` AS `productName`,`products`.`buyPrice` AS `buyPrice`,`products`.`image` AS `image` from (`products` join `orderdetails` on((`products`.`productCode` = `orderdetails`.`products_productCode`))) group by `products`.`productCode`,`products`.`productName`,`products`.`buyPrice`,`products`.`image` having (sum(`orderdetails`.`quantityOrdered`) >= 100) ;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `orderDetails`
--
ALTER TABLE `orderDetails`
  ADD PRIMARY KEY (`products_productCode`,`orders_orderNumber`),
  ADD KEY `fk_products_has_orders_orders1_idx` (`orders_orderNumber`),
  ADD KEY `fk_products_has_orders_products1_idx` (`products_productCode`);

--
-- Indeks for tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderNumber`),
  ADD KEY `fk_orders_users1_idx` (`users_userId`),
  ADD KEY `composite_idx_orderDate&shippedDate` (`orderDate`,`shippedDate`) USING BTREE;

--
-- Indeks for tabel `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`checkNumber`),
  ADD KEY `fk_payments_users1_idx` (`users_userId`),
  ADD KEY `idx_paymentDate` (`paymentDate`) USING BTREE;

--
-- Indeks for tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productCode`),
  ADD KEY `idx_productName` (`productName`) USING BTREE;

--
-- Indeks for tabel `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`subscriberId`),
  ADD KEY `composite-idx_lastName&firstName` (`lastName`,`firstName`) USING BTREE;

--
-- Indeks for tabel `userRoles`
--
ALTER TABLE `userRoles`
  ADD PRIMARY KEY (`roleId`);

--
-- Indeks for tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD KEY `fk_users_userRoles_idx` (`userRoles_roleId`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `subscriberId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Tilføj AUTO_INCREMENT i tabel `userRoles`
--
ALTER TABLE `userRoles`
  MODIFY `roleId` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Tilføj AUTO_INCREMENT i tabel `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;
--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_userRoles` FOREIGN KEY (`userRoles_roleId`) REFERENCES `userRoles` (`roleId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
