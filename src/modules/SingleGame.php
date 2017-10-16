<?php

namespace hangman\modules;

use freest\db\DBC;
use hangman\modules\SingleGuess;
use hangman\modules\Word;
/**
 * Description of SingleGame
 *
 * @author jfreeman82 <jfreeman@skedaddling.com>
 */
class SingleGame {
    
    private $id;
    private $wordid;
    private $gamehash;
    private $gameStart;
    private $gameEnded;
    
    public function __construct($id) 
    {
        $dbc = new DBC();
        $sql = "SELECT wordid,gamehash,game_start,game_end 
                FROM single_games 
                WHERE id = '$id';";
        $q = $dbc->query($sql) or die("ERROR @ SingleGame - ".$dbc->error());
        $row = $q->fetch_assoc();
        $this->id           = $id;
        $this->wordid       = $row['wordid'];
        $this->gamehash     = $row['gamehash'];
        $this->gameStart    = $row['game_start'];
        $this->gameEnd      = $row['game_end'];
    }
    
    public function id()            { return $this->id;             }
    public function wordid()        { return $this->wordid;         }
    public function gamehash()      { return $this->gamehash;       }
    public function gameStart()     { return $this->gameStart;      }
    public function gameEnd()       { return $this->gameEnd;        }
    
    public function word(): string
    {
        $word = new Word($this->wordid);
        return $word->word();
    }
    
    public function guesses(): array
    {
        $sql = "SELECT id FROM single_guesses WHERE game_id = '".$this->id."';";
        $dbc = new DBC();
        $q = $dbc->query($sql) or die("ERROR @ SingleGame / guesses - ".$dbc->error());
        $guesses = array();
        while ($row = $q->fetch_assoc()) {
            $guess_id = $row['id'];
            $guesses[] = new SingleGuess($guess_id);
        }
        return $guesses;
    }
    public function wrongGuesses(): array
    {
        $sql = "SELECT id FROM single_guesses WHERE game_id = '".$this->id."';";
        $dbc = new DBC();
        $q = $dbc->query($sql) or die("ERROR @ SingleGame / guesses - ".$dbc->error());
        $wrongGuesses = array();
        while ($row = $q->fetch_assoc()) {
            $guess_id = $row['id'];
            $guess = new SingleGuess($guess_id);
            if (!is_numeric(strpos($this->word(),$guess->letter()))) {
                $wrongGuesses[] = $guess;
            }
        }
        return $wrongGuesses;
    }
    public function guessCount(): int
    {
        return count($this->guesses());
    }
    public function wrongGuessCount(): int
    {
        return count($this->wrongGuesses());
    }
    
    public function guessesLeft(): int
    {
        return MAX_GUESSES - $this->guessCount();
    }
    public function wrongGuessesLeft(): int
    {
        return MAX_GUESSES - $this->wrongGuessCount();
    }
}
