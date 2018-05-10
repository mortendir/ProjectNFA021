CREATE TABLE Languages (
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL UNIQUE,
    `code` VARCHAR (20) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO Languages(`name`, `code`) VALUES('English', 'en'), 
											('French', 'fr'), 
											('German', 'de'), 
											('Spanish', 'es'), 
											('Turkish', 'tr');