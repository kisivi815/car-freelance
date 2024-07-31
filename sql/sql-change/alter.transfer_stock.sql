ALTER TABLE `car`.`transferstock` 
ADD COLUMN `Mileage` INT NULL DEFAULT NULL AFTER `ChasisNo`;

ALTER TABLE `car`.`transferstock` 
CHANGE COLUMN `Mileage` `MileageSend` INT NULL DEFAULT NULL ,
ADD COLUMN `MileageReceive` INT NULL DEFAULT NULL AFTER `MileageSend`;
