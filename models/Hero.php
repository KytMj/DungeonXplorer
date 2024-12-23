<?php
require_once __DIR__ . "/Combattant.php";

class Hero extends Combattant{

    private $inventory;
    private $mana;
    private $manaMax;

    
    public function __construct($name, $pv, $mana, $strength, $initiative, $armor){
        $this->name = $name;
        $this->pv = $pv;
        $this->mana = $mana;
        $this->strength = $strength;
        $this->initiative = $initiative;
        $this->manaMax = $mana;
        $this->pvMax = $pv;
        $this->armor = $armor;
    }
    public function getName(){
        return $this->name;
    }
    public function getStats(){
        return "PV : " . $this->pv . "</br> Mana : " . $this->mana . "</br> Strength : " . $this->strength;
    }

    public function boirePotion($value){
        $this->pv = min($this->pv + $value, $this->pvMax);
    }

    public function getArmor(){
        return "Armor : " . $this->armor;
    }
    

}


