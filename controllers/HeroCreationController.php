<?php
require_once "./models/User.php";
include_once "./core/pdo_agile.php";
class HeroCreationController {

    public function index() {
        require_once 'views/hero_creation_view.php';
    }
    
    public function creation(){
        require("./core/Database.php");
        
        if(isset($_SESSION['login'])){
            $data = $_POST;
            if(isset($data['submit'])){
                if((isset($data['classePerso']) && !empty($data['classePerso'])) 
                && (isset($data['hero_name']) && !empty($data['hero_name'])) 
                && (isset($data['hero_age']) && !empty($data['hero_age'])) 
                && (isset($data['bio']) && !empty($data['bio']))){
                    $tab = [];
                    LireDonneesPDO2($db, "select count(*) as nb from Quest where user_id = 
                        ( select user_id from User where user_mail = '".$_SESSION['login']."')", $tab);
                    //Si le héro n'existe pas
                    if($tab[0]['nb'] == 0){
                        $data['classePerso'] = htmlspecialchars($data['classePerso']);
                        $data['hero_name'] = htmlspecialchars($data['hero_name']);
                        $data['hero_age'] = htmlspecialchars($data['hero_age']);
                        $data['bio'] = htmlspecialchars($data['bio']);
                        
                        unset($tab);
                        LireDonneesPDO2($db, "select max(hero_id) as nb from Hero", $tab); // Pour récupérer le hero_id
                        $hero_id = intval($tab[0]['nb'])+1;
                        
                        $sql = "INSERT into Hero values (".$hero_id.", '".$data['hero_name']."','".$data['bio']."', 0, 'pas encore', (select class_id from Class where class_name='".$data['classePerso']."'), 1)";
                        majDonneesPDO($db,$sql);
                        unset($sql);
                        
                        $sql = "INSERT into `Quest` values (".$hero_id.", (select user_id from User where user_mail = '".$_SESSION['login']."'), 1, 
                        (select class_basePV from Class where class_name = '".$data['classePerso']."'), 
                        (select class_baseMana from Class where class_name = '".$data['classePerso']."') )";
                        majDonneesPDO($db,$sql);
                        unset($sql);

                        $sql ="INSERT into Stat values (".$hero_id.", (select lup_id from LevelUp where level_id = (select hero_level from Hero where hero_id = ".$hero_id.") and class_id = (select hero_class from Hero where hero_id = ".$hero_id.")),
                        (select (class_basePV + levup_pvBonus) as sta_pv from LevelUp join Class using (class_id) where level_id = (select hero_level from Hero where hero_id = ".$hero_id.") and class_id = (select hero_class from Hero where hero_id = ".$hero_id.")),
                        (select (class_baseMana + levup_manaBonus) as sta_mana from LevelUp join Class using (class_id) where level_id = (select hero_level from Hero where hero_id = ".$hero_id.") and class_id = (select hero_class from Hero where hero_id = ".$hero_id.")),
                        (select (class_baseStrength + levup_strengthBonus) as sta_strength from LevelUp join Class using (class_id) where level_id = (select hero_level from Hero where hero_id = ".$hero_id.") and class_id = (select hero_class from Hero where hero_id = ".$hero_id.")),
                        (select (class_baseInitiative + levup_initiativeBonus) as sta_initiative from LevelUp join Class using (class_id) where level_id = (select hero_level from Hero where hero_id = ".$hero_id.") and class_id = (select hero_class from Hero where hero_id = ".$hero_id.")) )"; 
                        majDonneesPDO($db,$sql);
                        unset($sql);

                        $sql = "INSERT into Inventory(hero_id, ite_id, inven_quantity) values (".$hero_id.", 11, 1)";
                        majDonneesPDO($db,$sql);
                        unset($sql);

                        //SI LES ITEMS SONT CHANGES, UNE ERREUR PEUT ÊTRE CREE ICI
                        $sql = "INSERT into Equipement(hero_id, ite_primaryWeapon, ite_armor) values (".$hero_id.", 3, 12)";
                        majDonneesPDO($db,$sql);
                        unset($sql);

                        $classID;
                        LireDonneesPDO2($db, "select class_id from Class where class_name = '".$data['classePerso']."'", $classID); // Pour récupérer le hero_id

                        if($classID[0]['class_id'] == 3){
                            $equipement;
                            LireDonneesPDO2($db, "select equ_id from Equipement where hero_id = ".$hero_id, $equipement);
                            
                            $sql = "INSERT into Spell(equ_id, spell_libelle, spell_heal, spell_valueMana) values (".$equipement[0]['equ_id'].", 'Sort de glace', 0, 2)";
                            majDonneesPDO($db,$sql);
                            unset($sql);

                            $sql = "INSERT into Spell(equ_id, spell_libelle, spell_heal, spell_valueMana) values (".$equipement[0]['equ_id'].", 'Sort de feu', 0, 2)";
                            majDonneesPDO($db,$sql);
                            unset($sql);

                            $sql = "INSERT into Spell(equ_id, spell_libelle, spell_heal, spell_valueMana) values (".$equipement[0]['equ_id'].", 'Sort de soin', 15, 0)";
                            majDonneesPDO($db,$sql);
                            unset($sql);
                        }

                        $_SESSION['hero'] = $hero_id;
                        $_SESSION['chapter'] = 1;

                        require_once 'views/chapter_view.php';
                        exit();
                    }
                }
            }
        }else{
            $erreur = "Vous n'êtes pas connecté.";
            $_SESSION['erreur'] = $erreur;
            require_once 'views/404.php';
            exit();
        }
    }
}