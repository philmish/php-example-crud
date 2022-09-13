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

CREATE TABLE IF NOT EXISTS Projects
(
    id SERIAL,
    name varchar(75) NOT NULL UNIQUE,
    created date NOT NULL DEFAULT CURRENT_TIMESTAMP,
    author_id BIGINT UNSIGNED NOT NULL,
    FOREIGN KEY (author_id) REFERENCES Users (id),
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS Topics
(
    id SERIAL,
    name varchar(75) NOT NULL UNIQUE,
    project_id BIGINT UNSIGNED NOT NULL,
    FOREIGN KEY (project_id) REFERENCES Projects (id),
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS Notes
(
    id SERIAL,
    created DATE DEFAULT CURRENT_TIMESTAMP NOT NULL,
    content varchar(350) NOT NULL,
    topic_id BIGINT UNSIGNED NOT NULL,
    FOREIGN KEY (topic_id) REFERENCES Topics (id),
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS Links
(
    id SERIAL,
    label varchar(50) NOT NULL,
    url varchar(256) NOT NULL,
    topic_id BIGINT UNSIGNED NOT NULL,
    FOREIGN KEY (topic_id) REFERENCES Topics (id),
    PRIMARY KEY(id)
);

INSERT INTO Users (email, password, name)
VALUES ("test@mail.com", "$1$jwGbpR.A$zYCjQtuXUwR.aauJuU8He0", "test");

INSERT INTO Projects (name, author_id)
VALUES ("Test Project", 1);

INSERT INTO Topics (name, project_id)
VALUES ("Test Topic", 1);

INSERT INTO Notes (content, topic_id)
VALUES ("This is a test note", 1), ("This is a second test note", 1);

INSERT INTO Links (label, url, topic_id)
VALUES ("Google", "https://google.com", 1);
