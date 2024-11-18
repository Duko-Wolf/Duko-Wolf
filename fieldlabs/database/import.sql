DROP DATABASE IF EXISTS `fieldlabs`;

CREATE DATABASE fieldlabs;

USE fieldlabs;

CREATE TABLE opdrachtgevers (
    primaryKey INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    opdrachtgeverNaam VARCHAR(50),
    email VARCHAR(255) NOT NULL,
    code VARCHAR(6) NOT NULL,
    token VARCHAR(255),
    expirationdate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE opdrachten (
    -- primaryKey INT NOT NULL,
    opdrachtSleutel INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    opdrachtNaam VARCHAR(150) NOT NULL,
    opdrachtBeschrijving VARCHAR(255) NOT NULL,
    naam VARCHAR(255) NOT NULL,
    telefoon VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL -- FOREIGN KEY (primaryKey) REFERENCES opdrachtgevers(primaryKey)
);

CREATE TABLE inschrijvingen (
    opdrachtNaam VARCHAR(255) NOT NULL,
    groepNaam VARCHAR(255) NOT NULL,
    eigenNaam VARCHAR(255) NOT NULL,
    emailLeider VARCHAR(255) NOT NULL,
    leden VARCHAR(255) NOT NULL,
    motivatie VARCHAR(255) NOT NULL
);

INSERT INTO
    opdrachtgevers (opdrachtgeverNaam, email, code)
VALUES
    ('Hendrik', 'hendrik@gmail.com', '123456'),
    ('Jan', 'jan@gmail.com', '654321');