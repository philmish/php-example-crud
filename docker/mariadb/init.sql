CREATE DATABASE IF NOT EXISTS test_db;
USE test_db;

CREATE TABLE IF NOT EXISTS Users
(
    id SERIAL,
    email varchar(75) NOT NULL UNIQUE,
    password varchar(256) NOT NULL,
    name varchar(40) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Notes
(
    id SERIAL,
    created DATE DEFAULT CURRENT_TIMESTAMP NOT NULL,
    content varchar(350) NOT NULL,
    author_id BIGINT UNSIGNED NOT NULL,
    FOREIGN KEY (author_id) REFERENCES Users (id),
    PRIMARY KEY(id)
);

INSERT INTO Users (email, password, name)
VALUES ("test@mail.com", "$1$jwGbpR.A$zYCjQtuXUwR.aauJuU8He0", "test");

INSERT INTO Notes (content, author_id)
VALUES ("This is a test note", 1), ("This is a second test note", 1);
