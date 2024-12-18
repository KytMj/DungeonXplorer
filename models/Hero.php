<?php
require_once __DIR__ . "/Combattant.php";

class Hero extends Combattant{

    private $inventory;
    
    public function __construct($name, $pv, $mana, $strength, $initiative){
        $this->name = $name;
        $this->pv = $pv;
        $this->mana = $mana;
        $this->strength = $strength;
        $this->initiative = $initiative;
    }
    public function getName(){
        return $this->name;
    }
    public function getStats(){
        return "PV: " . $this->pv . " Mana: " . $this->mana . " Strength: " . $this->strength;
    }
    

}


