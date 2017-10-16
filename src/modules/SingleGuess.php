<?php

namespace hangman\modules;

use freest\db\DBC;

/**
 * Description of SingleGuess
 *
 * @author jfreeman82 <jfreeman@skedaddling.com>
 */
class SingleGuess {

    private $id;
    private $game_id;
    private $letter;
    private $guess_date;
    
    public function __construct($guess_id)
    {
        $dbc = new DBC();
        $sql = "SELECT game_id,letter,guess_date 
                FROM single_guesses
                WHERE id = '$guess_id';";
        $q = $dbc->query($sql) or die("ERROR @ SingleGuess - ".$dbc->error());
        $row = $q->fetch_assoc();
        $this->id           = $guess_id;
        $this->game_id      = $row['game_id'];
        $this->letter       = $row['letter'];
        $this->guess_date   = $row['guess_date'];
    }
    
    public function id(): int           { return $this->id;         }
    public function game_id(): int      { return $this->game_id;    }
    public function letter(): string    { return $this->letter;     }
    public function guessDate(): string { return $this->guess_date; }
    
}
