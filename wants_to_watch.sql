CREATE TABLE wants_to_watch (
    username VARCHAR(50),
    mediaID INT,
    PRIMARY KEY (username, mediaID),
    FOREIGN KEY (username) REFERENCES users(username),
    FOREIGN KEY (mediaID) REFERENCES media(mediaID)
);

INSERT INTO wants_to_watch (username, mediaID) VALUES
('john_doe', 1),
('john_doe', 2),
('jane_smith', 3),
('alex_wong', 2),
('emily_jones', 4),
('michael_brown', 1);
