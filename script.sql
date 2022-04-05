-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 05, 2022 at 03:25 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `textil_export`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `sp_ClearShoppingCart`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ClearShoppingCart` (IN `UserIdIpt` VARCHAR(6))  BEGIN
	DELETE FROM shoppingcart WHERE UserId = UserIdIpt AND users_Id = UserIdIpt;
END$$

DROP PROCEDURE IF EXISTS `sp_GetLastSale`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetLastSale` (IN `UserIdIpt` VARCHAR(5))  BEGIN
    SELECT *
    FROM sales
    WHERE UserId = UserIdIpt AND users_Id = UserIdIpt
    ORDER BY CreatedDate DESC
    LIMIT 1;
END$$

DROP PROCEDURE IF EXISTS `sp_GetProduct`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetProduct` (IN `IdInput` VARCHAR(10))  BEGIN
    SELECT p.Id Id, P.Name Product, P.Description Descripcion, P.Image Image, P.Price Price, P.Stock Stock, C.Id CategoryId, C.Name Categoria
            FROM products P
            INNER JOIN category C ON C.Id = P.category_Id
            WHERE P.Id = IdInput;
END$$

DROP PROCEDURE IF EXISTS `sp_GetProducts`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetProducts` ()  BEGIN
    SELECT p.Id Id, P.Name Product, P.Description Descripcion, P.Image Image, P.Price Price, P.Stock Stock, c.Id CategoryId, c.Name Categoria
            FROM products p 
            INNER JOIN category c ON c.Id = P.category_Id;
END$$

DROP PROCEDURE IF EXISTS `sp_GetShoppingCart`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetShoppingCart` (IN `UserIdInput` VARCHAR(5))  BEGIN
    SELECT SC.Id, SC.Quantity, SC.UserId, P.Id ProductId, P.Name, P.Description, P.Image, P.Price, P.Stock
    FROM shoppingcart SC
    INNER JOIN products P ON SC.ProductId = P.Id
    WHERE SC.UserId = UserIdInput;
END$$

DROP PROCEDURE IF EXISTS `sp_GetUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetUser` (IN `IdIpt` VARCHAR(5))  BEGIN
  SELECT u.Id, u.Name Name, u.UserTypeId, U.Email, u.State, ut.Name TypeName
  FROM users u
  INNER JOIN usertypes ut ON u.usertypes_Id = ut.Id
  WHERE u.Id = IdIpt;
END$$

DROP PROCEDURE IF EXISTS `sp_GetUsers`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetUsers` ()  BEGIN
  SELECT u.Id, u.Name UserName, u.UserTypeId, U.Email, u.State, ut.Name TypeName
  FROM users u
  INNER JOIN usertypes ut ON u.usertypes_Id = ut.Id;
END$$

DROP PROCEDURE IF EXISTS `sp_login`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_login` (IN `EmailInput` VARCHAR(250), IN `PasswordInput` VARCHAR(256))  BEGIN
    SELECT * 
    FROM users
    WHERE State = 1 AND Email = EmailInput AND Password = PASSWORD(PasswordInput);
END$$

DROP PROCEDURE IF EXISTS `sp_SetSale`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_SetSale` (IN `TotalIpt` DOUBLE, IN `PDFIpt` VARCHAR(100), `UserIdIpt` VARCHAR(5))  BEGIN
    INSERT INTO sales(Total, PDF, UserId, users_Id)
    VALUES(TotalIpt, PDFIpt, UserIdIpt, UserIdIpt);
END$$

DROP PROCEDURE IF EXISTS `sp_SetShoppingCart`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_SetShoppingCart` (IN `UserIdInput` VARCHAR(5), IN `ProductIdInput` VARCHAR(10), IN `QuantityInput` INT)  BEGIN
    SELECT @exists := COUNT(*)
    FROM shoppingcart SC
    WHERE SC.ProductId = ProductIdInput AND SC.UserId = UserIdInput;
    IF @exists = 1 THEN
      UPDATE shoppingcart
      SET Quantity = QuantityInput
      WHERE UserId = UserIdInput AND ProductId = ProductIdInput;
    ELSE
      INSERT INTO shoppingcart(UserId, ProductId, Quantity, users_Id, products_Id)
      VALUES(UserIdInput, ProductIdInput, QuantityInput, UserIdInput, ProductIdInput);
    END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_SetUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_SetUser` (IN `NameIpt` VARCHAR(100), IN `PwdIpt` VARCHAR(255), IN `EmailIpt` VARCHAR(250), IN `TypeIdIpt` VARCHAR(5))  BEGIN
	SELECT @rows := COUNT(*) FROM users;
    
    IF @rows = 0 THEN
    	SET @LastNum := 1;
    ELSE
        SELECT @LastId := Id
        FROM users
        ORDER BY Id DESC
        LIMIT 1;
    	SELECT @LastNum := CAST(SUBSTRING(@LastId, 2) AS DECIMAL) + 1;
    END IF;
    
    SET @NewId := CONCAT('U', LPAD(@LastNum, 4, 0));
    
    INSERT INTO users(Id, Name, Password, UserTypeId, Email, State, usertypes_Id) 
    VALUES(@NewId, NameIpt, PASSWORD(PwdIpt), TypeIdIpt, EmailIpt, 1, TypeIdIpt);
END$$

DROP PROCEDURE IF EXISTS `sp_UpdateProductsStock`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_UpdateProductsStock` (IN `IdIpt` VARCHAR(10), IN `QtySale` INT)  BEGIN
	UPDATE products SET Stock = Stock - QtySale WHERE Id = IdIpt;
END$$

DROP PROCEDURE IF EXISTS `sp_UpdateShoppingCart`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_UpdateShoppingCart` (IN `UserIdInput` VARCHAR(5), IN `ProductIdInput` VARCHAR(10), IN `QuantityInput` INT)  BEGIN
    IF QuantityInput = 0 THEN 
      DELETE FROM shoppingcart
      WHERE UserId = UserIdInput AND ProductId = ProductIdInput;
    ELSE
      UPDATE shoppingcart
      SET Quantity = QuantityInput
      WHERE UserId = UserIdInput AND ProductId = ProductIdInput;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `Id` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `Name` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`Id`, `Name`) VALUES
('00001', 'Textil'),
('00002', 'Electronico');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `Id` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `Name` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Description` varchar(300) COLLATE utf8_spanish2_ci NOT NULL,
  `Image` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `CategoryId` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `Price` double NOT NULL,
  `Stock` int(11) NOT NULL,
  `category_Id` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_products_category1_idx` (`category_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`Id`, `Name`, `Description`, `Image`, `CategoryId`, `Price`, `Stock`, `category_Id`) VALUES
('PROD00001', 'OnePlus', 'Este es un smartphone', 'smartphone.jpg', '00002', 599.99, 98, '00002'),
('PROD00002', 'Camisa', 'Esta es una camisa', 'shirtBlue.jpg', '00001', 11.99, 500, '00001');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
CREATE TABLE IF NOT EXISTS `sales` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Total` double NOT NULL,
  `PDF` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UserId` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `users_Id` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_sales_users1_idx` (`users_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart`
--

DROP TABLE IF EXISTS `shoppingcart`;
CREATE TABLE IF NOT EXISTS `shoppingcart` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `ProductId` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `Quantity` int(11) NOT NULL,
  `users_Id` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `products_Id` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_shoppingcart_users1_idx` (`users_Id`),
  KEY `fk_shoppingcart_products1_idx` (`products_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `Id` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `Name` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Password` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `UserTypeId` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `Email` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `State` tinyint(1) NOT NULL DEFAULT '1',
  `usertypes_Id` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_users_usertypes_idx` (`usertypes_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `Name`, `Password`, `UserTypeId`, `Email`, `State`, `usertypes_Id`) VALUES
('U0001', 'sa', '*240107317205B9F031FD583F032790289AE6F185', 'T0001', 'sa@gmail.com', 1, 'T0001'),
('U0003', 'Naomi Nicole', '*73A2C72FDBCFF5C1F18ABFEF96AF74CE83A2134B', 'T0003', 'naomo123@gmail.com', 1, 'T0003'),
('U0005', 'Rafael Arturo', '*5823A0F87B2E947BCD09DEF83DBC3D49CA3EDF53', 'T0002', 'r2zamora11@gmail.com', 1, 'T0002'),
('U0006', 'Raul', '*7F0C90A004C46C64A0EB9DDDCE5DE0DC437A635C', 'T0003', 'raulzamogp@gmail.com', 1, 'T0003');

-- --------------------------------------------------------

--
-- Table structure for table `usertypes`
--

DROP TABLE IF EXISTS `usertypes`;
CREATE TABLE IF NOT EXISTS `usertypes` (
  `Id` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `Name` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `usertypes`
--

INSERT INTO `usertypes` (`Id`, `Name`) VALUES
('T0001', 'Administrador'),
('T0002', 'Empleado'),
('T0003', 'Cliente');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category1` FOREIGN KEY (`category_Id`) REFERENCES `category` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `fk_sales_users1` FOREIGN KEY (`users_Id`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD CONSTRAINT `fk_shoppingcart_products1` FOREIGN KEY (`products_Id`) REFERENCES `products` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_shoppingcart_users1` FOREIGN KEY (`users_Id`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_usertypes` FOREIGN KEY (`usertypes_Id`) REFERENCES `usertypes` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
