CREATE TABLE quick_sales (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    SalesId Varchar(10),
    ChasisNo VARCHAR(50),
    SalesPersonName VARCHAR(100),
    Branch VARCHAR(50),
    CustomerMobileNo VARCHAR(50),
    CustomerName VARCHAR(100),
    DateOfBooking DATETIME,
    created_at DATETIME,
    updated_at DATETIME
);
