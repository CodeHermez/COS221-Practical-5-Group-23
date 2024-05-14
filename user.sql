CREATE TABLE user (
    username VARCHAR(50) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    age INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO user (username, name, email, password, age) VALUES
('john_doe', 'John Doe', 'john@example.com', 'hashed_password_1', 30),
('jane_smith', 'Jane Smith', 'jane@example.com', 'hashed_password_2', 25),
('alex_wong', 'Alex Wong', 'alex@example.com', 'hashed_password_3', 35),
('emily_jones', 'Emily Jones', 'emily@example.com', 'hashed_password_4', 28),
('michael_brown', 'Michael Brown', 'michael@example.com', 'hashed_password_5', 40);
