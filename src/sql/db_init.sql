/**
 * Author:  jfreeman82 <jfreeman@skedaddling.com>
 * Created: Sep 08, 2017
 */

DROP DATABASE IF EXISTS hangman;
CREATE DATABASE hangman;

USE hangman;

DROP USER IF EXISTS 'hangmanuser'@'localhost';

CREATE USER 'hangmanuser'@'localhost' IDENTIFIED BY 'hangmanuser12345';

GRANT ALL ON hangman.* TO 'hangmanuser'@'localhost';
