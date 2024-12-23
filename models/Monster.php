<?php

require_once __DIR__ . "/Combattant.php";

class Monster extends Combattant
{
    public function __construct($name, $pv, $strength, $initiative, $armor){
        $this->name = $name;
        $this->pv = $pv;
        $this->strength = $strength;
        $this->initiative = $initiative;
        $this->pvMax = $pv;
        $this->armor = $armor;
    }

    public function getName(){
        return $this->name;
    }
    public function getStats(){
        return "PV: " . $this->pv . " Strength: " . $this->strength;
    }
}
