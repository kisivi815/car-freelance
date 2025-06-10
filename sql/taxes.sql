CREATE TABLE `car`.`taxes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `car_model` VARCHAR(45) NOT NULL,
  `type_of_fuel` VARCHAR(45) NOT NULL,
  `sgst` FLOAT NOT NULL,
  `cgst` FLOAT NOT NULL,
  `cess` FLOAT NOT NULL,
  PRIMARY KEY (`id`));
