CREATE TABLE taxmaster (
    id INT PRIMARY KEY,
    tax_name VARCHAR(255) NOT NULL,
    rate DECIMAL(5, 2) NOT NULL
);

INSERT INTO taxmaster (id, tax_name, rate) VALUES (1, 'IGST', 0.28);
INSERT INTO taxmaster (id, tax_name, rate) VALUES (2, 'CGST', 0.14);
INSERT INTO taxmaster (id, tax_name, rate) VALUES (3, 'SGST', 0.14);
INSERT INTO taxmaster (id, tax_name, rate) VALUES (4, 'Cess', 0.03);

