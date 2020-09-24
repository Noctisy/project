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
