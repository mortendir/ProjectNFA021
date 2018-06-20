CREATE DATABASE IF NOT EXISTS Translation_Project;
USE Translation_Project;


DROP FUNCTION IF EXISTS match_phrase;
DROP TABLE IF EXISTS Translations;
DROP TABLE IF EXISTS SamplePhrases;
DROP TABLE IF EXISTS Phrases;
DROP TABLE IF EXISTS Languages;
DROP TABLE IF EXISTS Users;

CREATE TABLE Languages (
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL UNIQUE,
    `code` VARCHAR(20) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO Languages(`name`, `code`) VALUES('English', 'en'), 
											('French', 'fr'), 
											('German', 'de'), 
											('Spanish', 'es'), 
											('Turkish', 'tr');

CREATE TABLE Phrases (
	`id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`language_id` INTEGER NOT NULL,
    `phrase` VARCHAR(255) NOT NULL,
    CONSTRAINT FK_LangId FOREIGN KEY (`language_id`) REFERENCES Languages(`id`),
    CONSTRAINT UN_Lang_Phrase UNIQUE (`language_id`, `phrase`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO Phrases(`language_id`, `phrase`) SELECT `id`, 'Gesicht' FROM Languages WHERE `code` = 'de';
INSERT INTO Phrases(`language_id`, `phrase`) SELECT `id`, 'gut' FROM Languages WHERE `code` = 'de';
INSERT INTO Phrases(`language_id`, `phrase`) SELECT `id`, 'face' FROM Languages WHERE `code` = 'en';
INSERT INTO Phrases(`language_id`, `phrase`) SELECT `id`, 'bien' FROM Languages WHERE `code` = 'es';
INSERT INTO Phrases(`language_id`, `phrase`) SELECT `id`, 'cara' FROM Languages WHERE `code` = 'es';
INSERT INTO Phrases(`language_id`, `phrase`) SELECT `id`, 'bien' FROM Languages WHERE `code` = 'fr';
INSERT INTO Phrases(`language_id`, `phrase`) SELECT `id`, 'visage' FROM Languages WHERE `code` = 'fr';
INSERT INTO Phrases(`language_id`, `phrase`) SELECT `id`, 'iyi' FROM Languages WHERE `code` = 'tr';
INSERT INTO Phrases(`language_id`, `phrase`) SELECT `id`, 'yüz' FROM Languages WHERE `code` = 'tr';

DELIMITER @
CREATE FUNCTION match_phrase (phrase VARCHAR(255), language_code VARCHAR(20)) RETURNS INTEGER 
BEGIN
	DECLARE result INTEGER DEFAULT -1;

	SELECT phrase.id INTO result
	FROM  Phrases phrase
	INNER JOIN Languages language ON language.id = phrase.language_id
	WHERE phrase.phrase = phrase
	AND language.code = language_code
	LIMIT 1;

	RETURN result;
END@
DELIMITER ;


CREATE TABLE SamplePhrases (
	`id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`content` VARCHAR(500) NOT NULL,
	`phrase_id` INTEGER NOT NULL,
	CONSTRAINT FK_PhraseId FOREIGN KEY (`phrase_id`) REFERENCES Phrases(`id`),
	CONSTRAINT UN_SamplePhrase UNIQUE (`content`, `phrase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO SamplePhrases(`content`, `phrase_id`) SELECT 'Der Ball traf ihn im Gesicht.', match_phrase('Gesicht', 'de');
INSERT INTO SamplePhrases(`content`, `phrase_id`) SELECT 'Mir geht\'s sehr gut.', match_phrase('gut', 'de');
INSERT INTO SamplePhrases(`content`, `phrase_id`) SELECT 'He should say it to my face.', match_phrase('face', 'en');
INSERT INTO SamplePhrases(`content`, `phrase_id`) SELECT 'El trabajo se ha realizado bien.', match_phrase('bien', 'es');
INSERT INTO SamplePhrases(`content`, `phrase_id`) SELECT 'Los ojos están en la cara.', match_phrase('cara', 'es');
INSERT INTO SamplePhrases(`content`, `phrase_id`) SELECT 'Ce travail est très bien.', match_phrase('bien', 'fr');
INSERT INTO SamplePhrases(`content`, `phrase_id`) SELECT 'Chacun de nous a un visage différent.', match_phrase('visage', 'fr');
INSERT INTO SamplePhrases(`content`, `phrase_id`) SELECT 'Onu iyi tanırım.', match_phrase('iyi','tr');
INSERT INTO SamplePhrases(`content`, `phrase_id`) SELECT 'Paketin arka yüzünde adres var.', match_phrase('yüz','tr');
INSERT INTO SamplePhrases(`content`, `phrase_id`) SELECT 'Top yüzüne çarptı.', match_phrase('yüz','tr');


CREATE TABLE Translations (
	`id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`source_phrase_id` INTEGER NOT NULL,
	`target_phrase_id` INTEGER NOT NULL,
	CONSTRAINT FK_SourceId FOREIGN KEY (`source_phrase_id`) REFERENCES Phrases(`id`),
	CONSTRAINT FK_TargetId FOREIGN KEY (`target_phrase_id`) REFERENCES Phrases(`id`),
	CONSTRAINT UN_Translation UNIQUE (`source_phrase_id`, `target_phrase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO Translations(`source_phrase_id`, `target_phrase_id`) SELECT match_phrase('Gesicht', 'de'), match_phrase('visage','fr');
INSERT INTO Translations(`source_phrase_id`, `target_phrase_id`) SELECT match_phrase('Gesicht', 'de'), match_phrase('face','en');
INSERT INTO Translations(`source_phrase_id`, `target_phrase_id`) SELECT match_phrase('Gesicht', 'de'), match_phrase('yüz','tr');
INSERT INTO Translations(`source_phrase_id`, `target_phrase_id`) SELECT match_phrase('Gesicht', 'de'), match_phrase('cara','es');
INSERT INTO Translations(`source_phrase_id`, `target_phrase_id`) SELECT match_phrase('gut', 'de'), match_phrase('bien','es');
INSERT INTO Translations(`source_phrase_id`, `target_phrase_id`) SELECT match_phrase('gut', 'de'), match_phrase('bien','fr');
INSERT INTO Translations(`source_phrase_id`, `target_phrase_id`) SELECT match_phrase('gut', 'de'), match_phrase('iyi','tr');
INSERT INTO Translations(`source_phrase_id`, `target_phrase_id`) SELECT match_phrase('face', 'en'), match_phrase('yüz','tr');
INSERT INTO Translations(`source_phrase_id`, `target_phrase_id`) SELECT match_phrase('face', 'en'), match_phrase('visage','fr');
INSERT INTO Translations(`source_phrase_id`, `target_phrase_id`) SELECT match_phrase('face', 'en'), match_phrase('cara','es');
INSERT INTO Translations(`source_phrase_id`, `target_phrase_id`) SELECT match_phrase('bien', 'es'), match_phrase('bien','fr');
INSERT INTO Translations(`source_phrase_id`, `target_phrase_id`) SELECT match_phrase('bien', 'es'), match_phrase('iyi','tr');
INSERT INTO Translations(`source_phrase_id`, `target_phrase_id`) SELECT match_phrase('cara', 'es'), match_phrase('visage','fr');
INSERT INTO Translations(`source_phrase_id`, `target_phrase_id`) SELECT match_phrase('cara', 'es'), match_phrase('yüz','tr');
INSERT INTO Translations(`source_phrase_id`, `target_phrase_id`) SELECT match_phrase('bien', 'fr'), match_phrase('iyi','tr');
INSERT INTO Translations(`source_phrase_id`, `target_phrase_id`) SELECT match_phrase('visage', 'fr'), match_phrase('yüz','tr');


CREATE TABLE Users (
	`id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`username` VARCHAR(100) NOT NULL UNIQUE,
	`password` VARCHAR(100) NOT NULL,
	CONSTRAINT UN_User_Pass UNIQUE (`username`, `password`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO Users(`username`, `password`) VALUES ('admin', 'admin');