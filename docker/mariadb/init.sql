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

INSERT INTO Users (email, password, name)
VALUES ("test@mail.com", "$1$jwGbpR.A$zYCjQtuXUwR.aauJuU8He0", "test");
