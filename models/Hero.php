<?php
require_once __DIR__ . "/Combattant.php";

class Hero extends Combattant{

    protected $equipement;
    protected $weapon;
    protected $armor;
    protected $shield;
    protected $inventory;
    protected $mana;
    protected $manaMax;
    protected $xp;

    
    public function __construct($hero_id){
        require("./core/Database.php");
        $heroData = [];
        LireDonneesPDO2($db, "SELECT * FROM Hero left join Stat using(hero_id) left join Quest using(hero_id) 
        left join Equipement using(hero_id) where hero_id = ".$hero_id, $heroData);

        $equipement = [];
        LireDonneesPDO2($db, "SELECT * FROM Equipement where hero_id = ".$hero_id, $equipement);

        $allItems = [];
        LireDonneesPDO2($db, "select * from Items", $allItems);

        $items = [];
        LireDonneesPDO2($db, "select * from Inventory where hero_id = ".$hero_id, $items);

        $inventory = [];
        foreach($items as $yourItem){
            foreach($allItems as $ite){ 
                if ($ite['ite_id'] == $yourItem['ite_id']){
                    array_push($inventory, ["name" => $ite['ite_name'], "description" => $ite['ite_description'], "type" => $ite['ite_type'], 
                    "effects" => $ite['ite_effects'], "item_cle" => $ite['ite_itemCle'], "equipable" => $ite['ite_equipable']]);
                }
            }
        }

        $this->name = $heroData[0]['hero_name'];
        $this->pv = $heroData[0]['ques_currentPV'];
        $this->mana = $heroData[0]['ques_currentMana'];
        $this->strength = $heroData[0]['sta_strength'];
        $this->initiative = $heroData[0]['sta_initiative'];
        $this->manaMax = $heroData[0]['sta_mana'];
        $this->pvMax = $heroData[0]['sta_pv'];
        $this->equipement = $equipement[0]['equ_id'];
        $this->armor = $equipement[0]['ite_armor'];
        $this->weapon = $equipement[0]['ite_primaryWeapon'];
        $this->shield = $equipement[0]['ite_shield'];
        $this->inventory = $inventory;

        $dgtWeapon = [];
        LireDonneesPDO2($db, "select * from Items where ite_id = ".strval($this->weapon), $dgtWeapon);
        $this->dgtPrimaryWeapon = intval(substr($dgtWeapon[0]['ite_effects'], 1));

        $defArmor = [];
        LireDonneesPDO2($db, "select * from Items where ite_id = ".strval($this->armor), $defArmor);
        $this->defArmor = intval(substr($defArmor[0]['ite_effects'], 1));
        
    }

    public function getName(){
        return $this->name;
    }

    public function getMana(){
        return $this->mana;
    }

    public function setMana($value){
        $this->mana = $value;
    }

    public function isMage(){
        return 0;
    }

    public function reduceMana($mana){
        $this->mana = $this->mana - $mana;
    }

    public function getStat(){
        return $this->name." PV : " . $this->pv. "/".$this->pvMax." Mana : " . $this->mana ."/".$this->manaMax;
    }
    
    public function getStats($currPV, $currMana){
        return $this->name." PV : " . $currPV. "/".$this->pvMax." Mana : " . $currMana ."/".$this->manaMax;
    }

    public function getSpells(){
        return null;
    }

    public function boirePotion($value){
        $this->pv = min($this->pv + $value, $this->pvMax);
    }

    public function getArmor(){
        return "Armor : " . $this->defArmor;
    }
}


