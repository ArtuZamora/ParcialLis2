-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema textil_export
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema textil_export
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `textil_export` DEFAULT CHARACTER SET latin1 ;
USE `textil_export` ;

-- -----------------------------------------------------
-- Table `textil_export`.`category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `textil_export`.`category` (
  `Id` VARCHAR(5) NOT NULL,
  `Name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`Id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `textil_export`.`products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `textil_export`.`products` (
  `Id` VARCHAR(10) NOT NULL,
  `Name` VARCHAR(100) NOT NULL,
  `Description` VARCHAR(300) NOT NULL,
  `Image` VARCHAR(100) NOT NULL,
  `CategoryId` VARCHAR(5) NOT NULL,
  `Price` DOUBLE NOT NULL,
  `Stock` INT(11) NOT NULL,
  `category_Id` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`Id`),
  INDEX `fk_products_category1_idx` (`category_Id` ASC),
  CONSTRAINT `fk_products_category1`
    FOREIGN KEY (`category_Id`)
    REFERENCES `textil_export`.`category` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `textil_export`.`usertypes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `textil_export`.`usertypes` (
  `Id` VARCHAR(5) NOT NULL,
  `Name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`Id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `textil_export`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `textil_export`.`users` (
  `Id` VARCHAR(5) NOT NULL,
  `Name` VARCHAR(100) NOT NULL,
  `Password` VARCHAR(255) CHARACTER SET 'utf8mb4' NOT NULL,
  `UserTypeId` VARCHAR(5) NOT NULL,
  `Email` VARCHAR(250) NOT NULL,
  `State` TINYINT(1) NOT NULL DEFAULT '1',
  `usertypes_Id` VARCHAR(5) NOT NULL,
  PRIMARY KEY (`Id`),
  INDEX `fk_users_usertypes_idx` (`usertypes_Id` ASC),
  CONSTRAINT `fk_users_usertypes`
    FOREIGN KEY (`usertypes_Id`)
    REFERENCES `textil_export`.`usertypes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `textil_export`.`sales`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `textil_export`.`sales` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `Total` DOUBLE NOT NULL,
  `PDF` VARCHAR(100) NOT NULL,
  `CreatedDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UserId` VARCHAR(5) NOT NULL,
  `users_Id` VARCHAR(5) NOT NULL,
  PRIMARY KEY (`Id`),
  INDEX `fk_sales_users1_idx` (`users_Id` ASC),
  CONSTRAINT `fk_sales_users1`
    FOREIGN KEY (`users_Id`)
    REFERENCES `textil_export`.`users` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `textil_export`.`shoppingcart`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `textil_export`.`shoppingcart` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `UserId` VARCHAR(5) NOT NULL,
  `ProductId` VARCHAR(10) NOT NULL,
  `Quantity` INT(11) NOT NULL,
  `users_Id` VARCHAR(5) NOT NULL,
  `products_Id` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`Id`),
  INDEX `fk_shoppingcart_users1_idx` (`users_Id` ASC),
  INDEX `fk_shoppingcart_products1_idx` (`products_Id` ASC),
  CONSTRAINT `fk_shoppingcart_products1`
    FOREIGN KEY (`products_Id`)
    REFERENCES `textil_export`.`products` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_shoppingcart_users1`
    FOREIGN KEY (`users_Id`)
    REFERENCES `textil_export`.`users` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 23
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;

USE `textil_export` ;

-- -----------------------------------------------------
-- procedure sp_ClearShoppingCart
-- -----------------------------------------------------

DELIMITER $$
USE `textil_export`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ClearShoppingCart`(IN UserIdIpt VARCHAR(6))
BEGIN

	DELETE FROM shoppingcart WHERE UserId = UserIdIpt AND users_Id = UserIdIpt;

END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure sp_GetLastSale
-- -----------------------------------------------------

DELIMITER $$
USE `textil_export`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetLastSale`(IN UserIdIpt VARCHAR(5))
BEGIN

    SELECT *

    FROM sales

    WHERE UserId = UserIdIpt AND users_Id = UserIdIpt

    ORDER BY CreatedDate DESC

    LIMIT 1;

END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure sp_GetProduct
-- -----------------------------------------------------

DELIMITER $$
USE `textil_export`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetProduct`(IN `IdInput` VARCHAR(10))
BEGIN

    SELECT p.Id Id, P.Name Product, P.Description Descripcion, P.Image Image, P.Price Price, P.Stock Stock, C.Id CategoryId, C.Name Categoria

            FROM products P

            INNER JOIN category C ON C.Id = P.category_Id

            WHERE P.Id = IdInput;

END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure sp_GetProducts
-- -----------------------------------------------------

DELIMITER $$
USE `textil_export`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetProducts`()
BEGIN

    SELECT p.Id Id, P.Name Product, P.Description Descripcion, P.Image Image, P.Price Price, P.Stock Stock, c.Id CategoryId, c.Name Categoria

            FROM products p 

            INNER JOIN category c ON c.Id = P.category_Id;

END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure sp_GetShoppingCart
-- -----------------------------------------------------

DELIMITER $$
USE `textil_export`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetShoppingCart`(IN `UserIdInput` VARCHAR(5))
BEGIN

    SELECT SC.Id, SC.Quantity, SC.UserId, P.Id ProductId, P.Name, P.Description, P.Image, P.Price, P.Stock

    FROM shoppingcart SC

    INNER JOIN products P ON SC.ProductId = P.Id

    WHERE SC.UserId = UserIdInput;

END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure sp_GetUser
-- -----------------------------------------------------

DELIMITER $$
USE `textil_export`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetUser`(IN `IdIpt` VARCHAR(5))
BEGIN

  SELECT u.Id, u.Name Name, u.UserTypeId, U.Email, u.State, ut.Name TypeName

  FROM users u

  INNER JOIN usertypes ut ON u.usertypes_Id = ut.Id

  WHERE u.Id = IdIpt;

END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure sp_GetUsers
-- -----------------------------------------------------

DELIMITER $$
USE `textil_export`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetUsers`()
BEGIN

  SELECT u.Id, u.Name UserName, u.UserTypeId, U.Email, u.State, ut.Name TypeName

  FROM users u

  INNER JOIN usertypes ut ON u.usertypes_Id = ut.Id;

END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure sp_SetSale
-- -----------------------------------------------------

DELIMITER $$
USE `textil_export`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_SetSale`(IN TotalIpt DOUBLE, IN PDFIpt VARCHAR(100), UserIdIpt VARCHAR(5))
BEGIN

    INSERT INTO sales(Total, PDF, UserId, users_Id)

    VALUES(TotalIpt, PDFIpt, UserIdIpt, UserIdIpt);

END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure sp_SetShoppingCart
-- -----------------------------------------------------

DELIMITER $$
USE `textil_export`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_SetShoppingCart`(IN `UserIdInput` VARCHAR(5), IN `ProductIdInput` VARCHAR(10), IN `QuantityInput` INT)
BEGIN

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

DELIMITER ;

-- -----------------------------------------------------
-- procedure sp_SetUser
-- -----------------------------------------------------

DELIMITER $$
USE `textil_export`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_SetUser`(IN NameIpt VARCHAR(100), IN PwdIpt VARCHAR(255), IN EmailIpt VARCHAR(250), IN TypeIdIpt VARCHAR(5))
BEGIN

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

DELIMITER ;

-- -----------------------------------------------------
-- procedure sp_UpdateProductsStock
-- -----------------------------------------------------

DELIMITER $$
USE `textil_export`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_UpdateProductsStock`(IN `IdIpt` VARCHAR(10), IN `QtySale` INT)
BEGIN

	UPDATE products SET Stock = Stock - QtySale WHERE Id = IdIpt;

END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure sp_UpdateShoppingCart
-- -----------------------------------------------------

DELIMITER $$
USE `textil_export`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_UpdateShoppingCart`(IN `UserIdInput` VARCHAR(5), IN `ProductIdInput` VARCHAR(10), IN `QuantityInput` INT)
BEGIN

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

-- -----------------------------------------------------
-- procedure sp_login
-- -----------------------------------------------------

DELIMITER $$
USE `textil_export`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_login`(IN EmailInput VARCHAR(250), IN PasswordInput VARCHAR(256))
BEGIN

    SELECT * 

    FROM users

    WHERE State = 1 AND Email = EmailInput AND Password = PASSWORD(PasswordInput);

END$$

DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
