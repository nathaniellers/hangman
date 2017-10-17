<?php

namespace hangman\mvc\model;

use freest\db\DBC;
use hangman\modules\Game;
/**
 * Description of SingleGameModel
 *
 * @author jfreeman82 <jfreeman@skedaddling.com>
 */
class GameModel 
{
    public static function checkGuess(Game $game): array
    {
        if (filter_input(INPUT_POST,'guess_form') == "go") {
            $guess_letter = strtolower(filter_input(INPUT_POST, 'guess_form_letter'));
            if (empty($guess_letter)) {
                return array('status' => 'warning','warning' => 'empty input');
            }
            // check if letter is a single letter
            if (strlen($guess_letter) != 1) {
                return array('status' => 'warning', 'warning' => 'Please enter a single letter');
            }
            // check if char is alphabetic
            if (!ctype_alpha($guess_letter)) {
                return array('status' => 'warning', 'warning' => 'Non-alphabetic character detected.');
            }
            $dbc = new DBC();            
            // check if letter exists
            $sql_check = "SELECT id FROM guesses 
                            WHERE letter = '$guess_letter' 
                            AND game_id = '".$game->id()."';";
            $q_check = $dbc->query($sql_check) or die("ERROR @ GameModel / checkGuess 1 - ".$dbc->error());
            if ($q_check->num_rows > 0) {
                return array('status' => 'warning','warning' => 'letter already exists');
            }
            // inserting guess
            $sql = "INSERT INTO guesses (game_id,letter,guess_date) 
                    VALUES ('".$game->id()."','$guess_letter',NOW());";
            $dbc->query($sql) or die("ERROR @ GameModel / checkGuess 2 - ".$dbc->error());
            return array('status' => '1');
        }
        else {
            return array('status' => '0');
        }
    }
    
    public static function gameIdFromHash($hash): int
    {
        $dbc = new DBC();
        $sql = "SELECT id FROM games WHERE gamehash = '$hash';";
        $q = $dbc->query($sql) or die("ERROR @ GameModel - ".$dbc->error());
        return $q->fetch_assoc()['id'];
    }
    public static function generateHash(): string
    {
        $hash = self::randomHash();
        while (self::isValidHash($hash)) {
            $hash = self::randomHash();
        }
        return $hash;
    }
    public static function isValidHash($hash): bool
    {
        $dbc = new DBC();
        $sql = "SELECT id FROM games WHERE gamehash = '$hash';";
        $q = $dbc->query($sql) or die("ERROR @ GameModel - ".$dbc->error());
        return $q->num_rows > 0;
    }
    public static function newGame(): string
    {        
        $hash = self::generateHash();
        $dbc = new DBC();
        // get random dict id
        $sql_dict = "SELECT id FROM dict;";
        $q_dict = $dbc->query($sql_dict) or die("ERROR @ GameModel / newGame - ".$dbc->error());
        $max = $q_dict->num_rows;
        $wordid = rand(1,$max);
        // create new game in db
        $sql = "INSERT INTO games (wordid,gamehash,game_start) VALUES ('$wordid','$hash',NOW());";
        $dbc->query($sql) or die("ERROR @ GameModel / newGame 2 - ".$dbc->error());
        return $hash;
    }
    
    private static function randomHash(): string
    {
        return hash('sha256', random_bytes(20));
    }
    
    // letters arranges the guesses and blanks
    public static function letters(Game $game): array
    {
        $word = $game->word();
        $wordline = array();
        $wrong = array();
        // fill wordline with underscores
        for ($i=0; $i<strlen($word); $i++) {
            $wordline[] = '_';
        }
        
        foreach($game->guesses() as $guess) {
            $letter = $guess->letter();
            //echo 'guess: '.$letter."<br/>";
            if (is_numeric(strpos($word,$letter))) {                    
                //echo 'letter '.$guess->letter().' found at positions ';
                $tmpword = $word;
                $total_pos = 0;
                while(is_numeric(strpos($tmpword,$letter))) {
                    //echo $tmpword;
                    $pos = strpos($tmpword,$letter);
                    $total_pos += $pos;  
                    //echo $total_pos.' ';                  
                    $wordline[$total_pos] = $letter;
                    $total_pos += 1;
                    $tmpword = substr($tmpword,$pos + 1);
                }
                //echo ' of word '.$tmpword."<br/>";
            }
            else {
                $wrong[] = $letter;
                //echo 'letter '.$letter.' not found in '.$word.', added to wrongs<br/>';
            }
        }
        
        $out = array();
        $out['wordline'] = $wordline;
        $out['wrong'] = $wrong;
        if (in_array('_', $wordline)) {
            $out['status'] = '0';
        }
        else {
            $out['status'] = '1';
        }
        return $out;
    }
    public static function endGame(Game $game)
    {
        // enter the game_end date
        $dbc = new DBC();
        $sql = "UPDATE games 
                    SET game_end = NOW() 
                    WHERE id = '".$game->id()."'";
        $dbc->query($sql) or die("ERROR @ GameModel / endGame - ".$dbc->error());
    }
}
