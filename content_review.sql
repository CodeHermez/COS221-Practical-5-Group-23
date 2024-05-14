CREATE TABLE content_review (
    reviewID INT PRIMARY KEY AUTO_INCREMENT,
    comments TEXT,
    starRating INT,
    mediaID INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO content_review (reviewID, comments, starRating, mediaID) VALUES
(01,'Great movie, loved it!', 5, 1),
(02,'Good storyline but pacing was slow.', 3, 2),
(03,'Excellent performance by the actors.', 4, 1),
(04,'Disappointing. Expected more from this series.', 2, 3),
(05,'Highly recommended. Must watch!', 5, 2);
