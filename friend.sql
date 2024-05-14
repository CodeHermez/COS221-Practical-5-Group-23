CREATE TABLE friend (
    username VARCHAR(50),
    friendID INT,
    PRIMARY KEY (username, friendID),
    FOREIGN KEY (username) REFERENCES users(username)
);

INSERT INTO friend (username, friendID) VALUES
('john_doe', 01),
('jane_smith', 03),
('alex_wong', 05)
