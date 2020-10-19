-- Yusa Celiker
CREATE DATABASE project1
--databse gemaakt

--tabel account aangemaakt
create table account(
    id INT NOT NULL AUTO_INCREMENT,
    email varchar(250) UNIQUE,
    password varchar(250),
    PRIMARY KEY(id)
);

--Tabel persoon aangemaakt
create table persoon(
    id INT NOT NULL AUTO_INCREMENT,
    account_id INT NOT NULL,
    username varchar(250) NOT NULL,
    firstname varchar(250) NOT NULL,
    middlename varchar(250),
    lastname varchar(250) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (account_id) REFERENCES account(id)
);

-- insert entry into table account
INSERT INTO account VALUES (NULL, 'Kees', 'k.geldstraat@rocva.nl', 'admin')

-- create a variable and store id of matchin email (email=unique)
SET @V1 := (SELECT id FROM account WHERE email='k.geldstraat@rocva.nl');

-- insert enrty into persoon, use account_id from table account (@v1)
INSERT INTO persoon VALUES (null, @v1, 'kees', '', 'geldstraat');

-- insert enrty into persoon, use account_id from table account (@v1)
INSERT INTO persoon VALUES (null, @v1, 'kees', '', 'geldstraat');

ALTER TABLE account ADD username (VARCHAR(250) NOT NULL);
