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

    public function getReward($chapter_id){
        require("./core/Database.php");
        $encounter = [];
        LireDonneesPDO2($db, "SELECT * FROM `Chapter` left join Encounter using (chap_id) where chap_id = ".$chapter_id, $encounter);

        $rewards = [];
        LireDonneesPDO2($db, "SELECT * FROM `Chapter` left join Reward using(chap_id) where chap_id = ".$chapter_id, $rewards);

        $nbRewards = [];
        LireDonneesPDO2($db, "SELECT count(*) as nb FROM `Chapter` join Reward using(chap_id) where chap_id = ".$chapter_id, $nbRewards);

        $xpHero = [];
        LireDonneesPDO2($db, "SELECT hero_xp, hero_level, level_requiredXP FROM `Hero` her left join `Level` lvl on her.hero_level = lvl.level_num WHERE hero_id = ".$_SESSION['hero'], $xpHero);

        if($xpHero[0]['hero_xp'] + $rewards[0]['chap_XpGained'] < $xpHero[0]['level_requiredXP']){
            $sql = "UPDATE Hero SET hero_xp = hero_xp + ".$rewards[0]['chap_XpGained']." WHERE hero_id = ".$_SESSION['hero'];
            majDonneesPDO($db,$sql);
        }
        else{
            $sql = "UPDATE Hero SET hero_xp = (hero_xp + ".$rewards[0]['chap_XpGained'].") - ".$xpHero[0]['level_requiredXP'].", hero_level = hero_level +1 WHERE hero_id = ".$_SESSION['hero'];
            majDonneesPDO($db,$sql);
            unset($sql);

            $sql = "UPDATE `Stat` SET sta_pv = sta_pv + (SELECT levup_pvBonus FROM LevelUp where level_id = (select hero_level from Hero where hero_id = ".$_SESSION['hero'].") and class_id = (select hero_class from Hero where hero_id = ".$_SESSION['hero'].")), 
            sta_mana = sta_mana + (SELECT levup_manaBonus FROM LevelUp where level_id = (select hero_level from Hero where hero_id = ".$_SESSION['hero'].") and class_id = (select hero_class from Hero where hero_id = ".$_SESSION['hero'].")), 
            sta_strength = sta_strength + (SELECT levup_strengthBonus FROM LevelUp where level_id = (select hero_level from Hero where hero_id = ".$_SESSION['hero'].") and class_id = (select hero_class from Hero where hero_id = ".$_SESSION['hero'].")), 
            sta_initiative = sta_initiative + (SELECT levup_initiativeBonus FROM LevelUp where level_id = (select hero_level from Hero where hero_id = ".$_SESSION['hero'].") and class_id = (select hero_class from Hero where hero_id = ".$_SESSION['hero'].")),
            lup_id = (SELECT lup_id FROM LevelUp where level_id = (select hero_level from Hero where hero_id = ".$_SESSION['hero'].") and class_id = (select hero_class from Hero where hero_id = ".$_SESSION['hero']."))  WHERE hero_id = ".$_SESSION['hero']."";
            majDonneesPDO($db,$sql);
            unset($sql);
        }

        if($nbRewards[0]['nb'] != 0){
            $items = [];
            LireDonneesPDO2($db, "SELECT count(*) as nb FROM `Inventory` where hero_id = ".$_SESSION['hero']." and ite_id = ". $rewards[0]['ite_id'], $items);
            if($items[0]['nb'] > 0){
                $sql = "UPDATE Inventory SET inven_quantity = inven_quantity + ". $rewards[0]['rew_quantity'] ." WHERE hero_id = ".$_SESSION['hero'];
                majDonneesPDO($db,$sql);
                unset($sql);
            }
            else{
                $sql = "INSERT INTO Inventory VALUES (".$_SESSION['hero'].", ".$rewards[0]['ite_id'].", ".$rewards[0]['rew_quantity'].")";
                majDonneesPDO($db,$sql);
                unset($sql);
            }
            unset($items);
        }

        $items = [];
        LireDonneesPDO2($db, "SELECT count(*) as nb FROM `Inventory` where hero_id = ".$_SESSION['hero']." and ite_id = ". $encounter[0]['ite_id'], $items);
        if($items[0]['nb'] > 0){
            $sql = "UPDATE Inventory SET inven_quantity = inven_quantity + ". $encounter[0]['enc_quantity'] ." WHERE hero_id = ".$_SESSION['hero'];
            majDonneesPDO($db,$sql);
            unset($sql);
        }
        else{
            $sql = "INSERT INTO Inventory VALUES (".$_SESSION['hero'].", ".$encounter[0]['ite_id'].", ".$encounter[0]['enc_quantity'].")";
            majDonneesPDO($db,$sql);
            unset($sql);
        }
    }
}


