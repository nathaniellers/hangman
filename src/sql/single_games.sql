/**
 * Author:  jfreeman82 <jfreeman@skedaddling.com>
 * Created: Oct 16, 2017
 */

DROP TABLE IF EXISTS single_games;
CREATE TABLE single_games (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  wordid INT NOT NULL,
  gamehash TEXT,
  game_start DATETIME NOT NULL,
  game_end DATETIME,
  FOREIGN KEY (wordid) REFERENCES dict(id)
);