<?php

namespace hangman\modules;

use freest\db\DBC;
/**
 * Description of Word
 *
 * @author jfreeman82 <jfreeman@skedaddling.com>
 */
class Word {
    
    private $id;
    private $word;
    
    public function __construct($word_id) 
    {
        $dbc = new DBC();
        $sql = "SELECT word FROM dict WHERE id = '$word_id';";
        $q = $dbc->query($sql) or die("ERROR @ Word - ".$dbc->error());
        $this->id = $word_id;
        $this->word = $q->fetch_assoc()['word'];
    }
    
    public function id()    { return $this->id;     }
    public function word()  { return $this->word;   }
    
}
