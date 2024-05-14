use hoop;
CREATE TABLE crew(
	crewID int NOT NULL AUTO_INCREMENT,
    name varchar(255),
    role enum("actor","director","writer"),
    PRIMARY KEY (crewID)
);

describe crew;