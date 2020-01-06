DROP DATABASE IF EXISTS p4blog;
CREATE DATABASE p4blog CHARACTER SET 'utf8';

USE p4blog;

-- ***** Tables for the Blog part *****

CREATE TABLE Posts
(
    id            SMALLINT(5)   UNSIGNED  PRIMARY KEY AUTO_INCREMENT,
    title         VARCHAR(50)   NOT NULL  UNIQUE,
    content       LONGTEXT      NOT NULL,
    created_date  DATETIME      NOT NULL  DEFAULT       CURRENT_TIMESTAMP
)
    ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE Admin
(
    id            SMALLINT(5)      	                UNSIGNED  PRIMARY KEY AUTO_INCREMENT,
    first_name    VARCHAR(50)                       NOT NULL,
    last_name     VARCHAR(50)                       NOT NULL,
    nickname	  VARCHAR(50)   	                NOT NULL,
    email         VARCHAR(100)  	                NOT NULL  UNIQUE,
    pass          VARCHAR(100)  	                NOT NULL,
    status        SET('admin','member','visitor')   NOT NULL DEFAULT 'visitor'
)
    ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE Comments
(
    id            SMALLINT(5)     UNSIGNED      PRIMARY KEY   AUTO_INCREMENT,
    author        varchar(50)     NOT NULL,
    content       TEXT            NOT NULL,
    created_date  DATETIME        NOT NULL      DEFAULT       CURRENT_TIMESTAMP,
    post_id       SMALLINT(5)     UNSIGNED      NOT NULL,
    user_id       SMALLINT(5)     UNSIGNED      NOT NULL,
    reported      tinyint(1)      NOT NULL,
    CONSTRAINT    fk_post_id      FOREIGN KEY   (post_id)     REFERENCES      Posts(id),
    CONSTRAINT    fk_user_id      FOREIGN KEY   (user_id)     REFERENCES      Admin(id)
)
    ENGINE=INNODB DEFAULT CHARSET=utf8;
