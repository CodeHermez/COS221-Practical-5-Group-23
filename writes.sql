CREATE TABLE writes (
    reviewID INT,
    username VARCHAR(50),
    PRIMARY KEY (reviewID, username),
    FOREIGN KEY (reviewID) REFERENCES content_review(reviewID),
    FOREIGN KEY (username) REFERENCES users(username)
);

INSERT INTO writes (reviewID, username) VALUES
(01, 'john_doe'),
(02, 'jane_smith'),
(03, 'alex_wong'),
(04, 'emily_jones'),
(05, 'michael_brown');
