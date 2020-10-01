create table users(
    id INT NOT NULL AUTO_INCREMENT,
    username varchar(255) UNIQUE,
    created_at DATETIME,
    updated_at DATETIME,
    PRIMARY KEY(id)
);

create table favourites(
    id INT NOT NULL AUTO_INCREMENT,
    users_id INT NOT NULL,
    books_id INT NOT NULL,
    created_at DATETIME,
    updated_at DATETIME,
    PRIMARY KEY (id),
    FOREIGN KEY (users_id) REFERENCES users(id),
    FOREIGN KEY (books_id) REFERENCES books(id)
);

create table books(
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    authors_id INT NOT NULL,
    publishing_year VARCHAR(255) NOT NULL,
    genre VARCHAR(255) NOT NULL,
    created_at DATETIME,
    updated_at DATETIME,
    PRIMARY KEY(id),
    FOREIGN KEY(author_id) REFERENCES authors(id)
);

CREATE TABLE authors(
    id INT NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    created_at DATETIME,
    updated_at DATETIME,
    PRIMARY KEY(id)
);
