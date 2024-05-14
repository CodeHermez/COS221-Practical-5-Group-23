use hoop;
CREATE TABLE entertainment_content(
	media_ID int NOT NULL AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    release_Date date NOT NULL,
    description text NOT NULL,
    content_rating enum("PG","PG 9","PG 13","16","18") default "PG",
    PRIMARY KEY (media_ID)
);

CREATE TABLE movie(
	media_ID int NOT NULL,
    duration int NOT NULL,
    FOREIGN KEY(media_ID) REFERENCES entertainment_content(media_ID) ON DELETE CASCADE,
    CHECK (duration > 0)
);

CREATE TABLE tvShow(
	media_ID int NOT NULL,
    seasons int NOT NULL,
    FOREIGN KEY(media_ID) REFERENCES entertainment_content(media_ID) ON DELETE CASCADE,
    CHECK (seasons > 0)
);

CREATE TABLE BELONGS(
	genreID int NOT NULL,
    media_ID int NOT NULL,
    FOREIGN KEY(media_ID) REFERENCES entertainment_content(media_ID) ON DELETE CASCADE,
    FOREIGN KEY(genreID) REFERENCES genre(genreID)
);

CREATE TABLE INVOLVED_IN(
	crewID int NOT NULL,
    media_ID int NOT NULL,
    FOREIGN KEY(media_ID) REFERENCES entertainment_content(media_ID) ON DELETE CASCADE,
    FOREIGN KEY(crewID) REFERENCES crew(crewID) ON DELETE CASCADE
);

show tables;