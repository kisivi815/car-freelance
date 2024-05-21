CREATE TABLE car_details (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    ProductLine VARCHAR(50) UNIQUE,
    MakersName VARCHAR(50),
    NoOfCylinders INT,
    SeatingCapacity INT,
    CatalyticConverter BOOLEAN,
    UnladenWeight INT,
    FrontAxleWeight INT,
    RearAxleWeight INT,
    AnyOtherAxleWeight INT,
    TandemAxleWeight INT,
    GrossWeight INT,
    TypeOfBody VARCHAR(50)
);

-- Inserting sample data
INSERT INTO car_details (ProductLine, MakersName, NoOfCylinders, SeatingCapacity, CatalyticConverter, UnladenWeight, FrontAxleWeight, RearAxleWeight, AnyOtherAxleWeight, TandemAxleWeight, GrossWeight, TypeOfBody)
VALUES
('Nexon', 'Tata Motors', 4, 5, TRUE, 1200, 600, 600, 0, 0, 1500, 'SUV'),
('Punch', 'Tata Motors', 3, 5, TRUE, 1100, 550, 550, 0, 0, 1400, 'Hatchback');