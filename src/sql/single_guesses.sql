/**
 * Author:  jfreeman82 <jfreeman@skedaddling.com>
 * Created: Oct 16, 2017
 */
DROP TABLE IF EXISTS single_guesses;
CREATE TABLE single_guesses (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  game_id INT NOT NULL,
  letter VARCHAR(1) NOT NULL,
  guess_date DATETIME NOT NULL,
  FOREIGN KEY (game_id) REFERENCES single_games(id)
);
