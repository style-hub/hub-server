CREATE TABLE hub.styles (
    id INT NOT NULL AUTO_INCREMENT,
    stylename VARCHAR(50) NOT NULL,
    stylecreator VARCHAR(50) NOT NULL,
    styledescription VARCHAR(255) NOT NULL,
    stylexml VARCHAR(255) NOT NULL,
    stylepreview VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
);
