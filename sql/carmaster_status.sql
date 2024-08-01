CREATE TABLE carmaster_status (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ChasisNo VARCHAR(50),
    status varchar(50),
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
