use hoop;
CREATE TABLE genre(
	genreID int NOT NULL AUTO_INCREMENT,
    genreName varchar(255) NOT NULL ,
    PRIMARY KEY (genreID),
    UNIQUE (genreName)
);

INSERT INTO genre (genreName) VALUES ("Action");
INSERT INTO genre (genreName) VALUES ("Adventure");
INSERT INTO genre (genreName) VALUES ("Comedy");
INSERT INTO genre (genreName) VALUES ("Romance");
INSERT INTO genre (genreName) VALUES ("Documentry");
SELECT * FROM genre;