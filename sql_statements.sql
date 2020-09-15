CREATE DATABASE project1
--databse gemaakt

--tabel account aangemaakt
create table account(
id int not null AUTO_INCREMENT,
email varchar(250) UNIQUE,
password varchar(250),
primary key(id)
);

--Tabel persoon aangemaakt
create table persoon(
id int not null AUTO_INCREMENT,
username varchar(250),
primary key(id),
FOREIGN KEY (id) REFERENCES account(id)
);
