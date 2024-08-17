ALTER TABLE `car`.`quick_sales` 
ADD COLUMN `TMInvoiceNo` VARCHAR(45) NULL COMMENT 'same as commercial no at car master' AFTER `DateOfBooking`;
