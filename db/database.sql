CREATE DATABASE bookmcc;
USE bookmcc;

CREATE TABLE Users (
    UserID INT NOT NULL AUTO_INCREMENT,
    Email VARCHAR(255) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Username VARCHAR(255) NOT NULL,
    RegistrationTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (UserID),
    UNIQUE (Email)
);

CREATE TABLE Books (
    BookID INT NOT NULL AUTO_INCREMENT,
    UserID INT NOT NULL,
    Title VARCHAR(255) NOT NULL,
    Author VARCHAR(255) NOT NULL,
    ISBN_13 VARCHAR(13),
    ISBN_10 VARCHAR(10),
    Image MEDIUMBLOB,
    CourseName VARCHAR(255),
    Note Text,
    PostTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (BookID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

CREATE TABLE Comments (
    CommentID INT NOT NULL AUTO_INCREMENT,
    BookID INT NOT NULL,
    UserID INT NOT NULL,
    CommentText Text NOT NULL,
    CommentTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (CommentID),
    FOREIGN KEY (BookID) REFERENCES Books(BookID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);