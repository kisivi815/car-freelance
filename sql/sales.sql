CREATE TABLE sales (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Mobile bigint,
    Saluation varchar(10),
    FirstName varchar(50),
    LastName varchar(50),
    FathersName varchar(50),
    Email  varchar(50),
    Aadhar varchar(50),
    PAN varchar(50),
    GST varchar(50),
    PermanentAddress varchar (500),
    TemporaryAddress varchar (500),
    ChasisNo VARCHAR(50),
    Bank varchar(100),
    InsuranceName varchar(100),
    DiscountType VARCHAR(50),
    Accessories VARCHAR(50),
    TypeofGST SMALLINT(4) NOT NULL DEFAULT 1,
    DateOfSales DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_at DATETIME,
    updated_at DATETIME
);

ALTER TABLE `sales` 
ADD COLUMN `InvoiceNo` VARCHAR(45) NULL AFTER `updated_at`,
ADD COLUMN `InvoiceDate` DATETIME NULL AFTER `InvoiceNo`;

ALTER TABLE `sales` 
CHANGE COLUMN `InvoiceNo` `InvoiceNo` VARCHAR(45) NULL DEFAULT NULL AFTER `ID`,
CHANGE COLUMN `InvoiceDate` `InvoiceDate` DATETIME NULL DEFAULT NULL AFTER `TypeofGST`;

ALTER TABLE `sales` 
ADD COLUMN `Note` VARCHAR(1000) NULL AFTER `InvoiceDate`;


ALTER TABLE `car`.`sales` 
ADD COLUMN `status` TINYINT(2) NULL DEFAULT 0 AFTER `Note`;





