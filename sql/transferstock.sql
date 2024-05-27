CREATE TABLE transferstock (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ChasisNo VARCHAR(50),
    SourceBranch VARCHAR(100),
    DestinationBranch VARCHAR(100),
    DriverName VARCHAR(100),
    Note VARCHAR(1000),
    SendBy VARCHAR(100),
    GatePassId VARCHAR(50),
    DateOfTransfer DATE
);
