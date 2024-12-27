<?php

class Magicien extends Hero{

    public function __construct($hero_id){
        parent::__construct($hero_id);
    }

    public function isMage(){
        return 1;
    }

    public function getSpells(){
        require("./core/Database.php");
        $spells = [];
        LireDonneesPDO2($db, "SELECT * FROM Spell where equ_id = ".$this->equipement, $spells);

        $grimoire = [];
        foreach($spells as $spell):
            array_push($grimoire, ["libelle" => $spell['spell_libelle'], "effets"=> strval($spell['spell_heal'])."-".strval($spell['spell_valueMana'])]);
        endforeach;
        return $grimoire;
    }
}

?>