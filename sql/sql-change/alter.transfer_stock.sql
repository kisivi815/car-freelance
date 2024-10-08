ALTER TABLE `car`.`transferstock` 
ADD COLUMN `Mileage` INT NULL DEFAULT NULL AFTER `ChasisNo`;

ALTER TABLE `car`.`transferstock` 
CHANGE COLUMN `Mileage` `MileageSend` INT NULL DEFAULT NULL ,
ADD COLUMN `MileageReceive` INT NULL DEFAULT NULL AFTER `MileageSend`;

ALTER TABLE `car`.`transferstock` 
ADD COLUMN `VehicleAmt` FLOAT NULL AFTER `ChasisNo`,
ADD COLUMN `VehicleNo` VARCHAR(45) NULL AFTER `VehicleAmt`;

