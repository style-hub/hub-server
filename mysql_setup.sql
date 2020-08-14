CREATE TABLE hub.styles (
    id INT(9) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    stylename VARCHAR(50) NOT NULL,
    stylecreator VARCHAR(50) NOT NULL,
    styledescription VARCHAR(512) NOT NULL,
    stylexml VARCHAR(255) NOT NULL,
    stylepreview VARCHAR(255) NOT NULL,
    byuser VARCHAR(50),
    ismarker TINYINT(1),
    isline TINYINT(1),
    isfill TINYINT(1),
    isramp TINYINT(1),
    istext TINYINT(1),
    islabel TINYINT(1),
    ispatch TINYINT(1),
    popular INT(11)
);

CREATE TABLE hub.layouts (
    id INT(9) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    layoutname VARCHAR(50) NOT NULL,
    layoutcreator VARCHAR(50) NOT NULL,
    layoutdescription VARCHAR(512) NOT NULL,
    layoutqpt VARCHAR(255) NOT NULL,
    layoutpreview VARCHAR(255) NOT NULL,
    byuser VARCHAR(50),
    istiny TINYINT(1),
    issmall TINYINT(1),
    ismedium TINYINT(1),
    islarge TINYINT(1),
    isscreen TINYINT(1),
    iselement TINYINT(1),
    popular INT(11)
);

CREATE TABLE hub.users (
    id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    useremail VARCHAR(100) NOT NULL,
    userpwd VARCHAR(255) NOT NULL,
    moderator TINYINT(1)
);
