-- eerst kijken of de databse al bestaat is dat zo dan verwijdert ie hem
DROP DATABASE IF EXISTS `buur`;

-- maak database buur
CREATE DATABASE buur;

-- decladeren om buur te gebruiken
USE buur;

-- maak tabel gebruikers met daarin allemaal elementen
CREATE TABLE gebruikers (
    gebruikersNummer INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    gebruikersNaam VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    gebruikersWachtwoord VARCHAR(200) NOT NULL
);

-- maak tabel producten met elementen
CREATE TABLE producten (
    productCode INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    productNaam VARCHAR(99) NOT NULL,
    productValue VARCHAR(99) NOT NULL,
    productQuantity INT NOT NULL,
    productCategory VARCHAR(255) NOT NULL,
    productDescription VARCHAR(255) NOT NULL,
    productImg VARCHAR(255) NOT NULL
);

-- maak tabel bestellingen
CREATE TABLE kruiwagen (
    productCode INT NOT NULL,
    productNaam VARCHAR(255) NOT NULL,
    productAantal INT NOT NULL,
    productPrijs VARCHAR(99) NOT NULL,
    email VARCHAR(50) NOT NULL,
    FOREIGN KEY (productCode) REFERENCES producten(productCode),
    orderNumber INT NOT NULL AUTO_INCREMENT PRIMARY KEY
);

-- -- maak tabel bestellingendetails
-- CREATE TABLE bestellingendetails (
--     orderNumber INT NOT NULL,
--     productCode INT NOT NULL,
--     FOREIGN KEY (orderNumber) REFERENCES bestellingen(orderNumber),
--     FOREIGN KEY (productCode) REFERENCES producten(productCode)
-- );


-- producten toevoegen aan de database
INSERT INTO
    producten (
        productNaam,
        productValue,
        productQuantity,
        productCategory,
        productDescription
    )
VALUES
('Strijkbout', 89.99, 50, 'Gereedschap', 'Een handige strijkbout voor het gladstrijken van kleding.'),
('Buurman & Buurman Hamer', 16.49, 100, 'Gereedschap', 'Een stevige hamer van Buurman & Buurman voor al je klussen.'),
('Bordspel "Hamertje Tik"', 35.99, 30, 'Spelletjes', 'Een leuk bordspel waarbij je met een hamertje figuurtjes op een bord slaat.'),
('Buurman & Buurman kluskoffer', 29.99, 20, 'Gereedschap', 'Een handige kluskoffer met gereedschap van Buurman & Buurman.'),
('Buurman en Buurman DVD Compleet', 24.99, 15, 'Media', 'Met deze DVD kan je de avonturen van Buurman en Buurman bekijken.'),
('Buurman en Buurman DVD Bundel', 24.99, 15, 'Media', 'Met deze DVD kan je de avonturen van Buurman en Buurman bekijken.'),
('Buurman en Buurman DVD "Bakken en Grillen"', 19.99, 15, 'Media', 'Met deze DVD kan je de avonturen van Buurman en Buurman bekijken.'),
('Duimstok', 1.49, 230, 'Gereedschap', 'Een duimstok om alles op maat te meten, metrisch en imperiaal systeem.'),
('Hoedje buurman rood', 33.99, 45, 'Kleding', 'Het bekende hoedje van de rode Buurman'),
('Hoedje buurman geel', 33.99, 45, 'Kleding', 'Het bekende hoedje van de gele Buurman'),
('T-Shirt buurman rood', 49.99, 22, 'Kleding', 'Het bekende shirt van de rode Buurman'),
('T-Shirt buurman geel', 49.99, 22, 'Kleding', 'Het bekende shirt van de gele Buurman'),
('Buurman en Buurman trui rood', 49.99, 50, 'Kleding', 'Met dit kledingstuk kan je jezelf omtoveren tot de rode buurman.'),
('Buurman en Buurman trui geel', 49.99, 50, 'Kleding', 'Met dit kledingstuk kan je jezelf omtoveren tot de gele buurman.'),
('Buurman en Buurman pet rood', 29.99, 50, 'Kleding', 'Met dit kledingstuk kan je jezelf omtoveren tot de rode buurman.'),
('Buurman en Buurman pet geel', 29.99, 50, 'Kleding', 'Met dit kledingstuk kan je jezelf omtoveren tot de gele buurman.'),
('Buurman & Buurman Speelhuis bouwpakket', 34.99, 10, 'Speelgoed', 'Een leuk speelhuis bouwpakket van Buurman & Buurman'),
('Buurman & Buurman Beitel', 24.99, 35, 'Gereedschap', 'Een handige beitel om te gebruiken tijdens het klussen'),
('Buurman & Buurman Boormachine', 99.99, 100, 'Gereedschap', 'Een sterke boormachine, erg goed in gaatjes boren');



-- Importeert de plaatjes van de producten
UPDATE producten
SET productImg = 'Strijkbout.jpg'
WHERE productCode = 1;

UPDATE producten
SET productImg = 'Buurman-hamer.jpg'
WHERE productCode = 2;

UPDATE producten
SET productImg = 'buurman-bordspel.jpg'
WHERE productCode = 3;

UPDATE producten
SET productImg = 'buurman-en-buurman-houten-kluskoffer.jpg'
WHERE productCode = 4;

UPDATE producten
SET productImg = 'B&B-DVD-Rood.jpg'
WHERE productCode = 5;

UPDATE producten
SET productImg = 'B&B-DVD-Bundel.jpg'
WHERE productCode = 6;

UPDATE producten
SET productImg = 'B&B-DVD-Bak-Gril.jpg'
WHERE productCode = 7;

UPDATE producten
SET productImg = 'buurman-duimstok.jpg'
WHERE productCode = 8;

UPDATE producten
SET productImg = 'buurman-muts-rood.jpg'
WHERE productCode = 9;

UPDATE producten
SET productImg = 'buurman-muts-geel.jpg'
WHERE productCode = 10;

UPDATE producten
SET productImg = 'buurman-shirt-rood.jpg'
WHERE productCode = 11;

UPDATE producten
SET productImg = 'buurman-shirt-geel.jpg'
WHERE productCode = 12;

UPDATE producten
SET productImg = 'buurman-trui-rood.jpg'
WHERE productCode = 13;

UPDATE producten
SET productImg = 'buurman-trui-geel.jpg'
WHERE productCode = 14;

UPDATE producten
SET productImg = 'buurman-pet-rood.jpg'
WHERE productCode = 15;

UPDATE producten
SET productImg = 'buurman-pet-geel.jpg'
WHERE productCode = 16;

UPDATE producten
SET productImg = 'buurman-speelhuis.png'
WHERE productCode = 17;

UPDATE producten
SET productImg = 'buurman-beitel.png'
WHERE productCode = 18;

UPDATE producten
SET productImg = 'buurman-boormachine.jpg'
WHERE productCode = 19;