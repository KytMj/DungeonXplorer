<?php

// controllers/ChapterController.php

require_once "./models/Chapter.php";
include_once "./models/Inventory.php";
include_once "./models/Item.php";
include_once "./core/pdo_agile.php";


class ChapterController
{
    private $chapters = [];

    public function index() {
        require_once 'views/chapter_view.php';
    }
    
    public function __construct()
    {
        require("./core/Database.php");
        // Exemple de chapitres avec des images
        $tab = [];
        LireDonneesPDO2($db, 
        "select * from Chapter", $tab);
        $links = [];
        LireDonneesPDO2($db, 
        "select * from Links", $links);

        foreach($tab as $chapter){
            $choices = [];
            foreach($links as $l){ 
                if ($l['chapter_id'] == $chapter['chap_id']){
                    array_push($choices, ["text" => $l['description'], "chapter" => $l['next_chapter_id']]);
                }
            }
                      
            $this->chapters[] = new Chapter(
            $chapter['chap_id'],
            $chapter['chap_title'],
            $chapter['chap_content'],
            $chapter['chap_image'],
            $chapter['chap_isCombat'],
            $choices
            );
            
        }
    }

    public function getChapter($id)
    {
        foreach ($this->chapters as $chapter) {
            if ($chapter->getId() == $id) {
                return $chapter;
            }
        }
        return null; // Chapitre non trouvé
    }

    public function reinitialize(){
        require("./core/Database.php");
        $sql = "DELETE FROM Inventory WHERE hero_id = ".$_SESSION['hero'];
        majDonneesPDO($db,$sql);
        unset($sql);

        $sql = "DELETE FROM Stat WHERE hero_id = ".$_SESSION['hero'];
        majDonneesPDO($db,$sql);
        unset($sql);

        $sql = "UPDATE Quest SET chap_id = 1 WHERE hero_id = ".$_SESSION['hero'];
        majDonneesPDO($db,$sql);
        unset($sql);

        $sql = "UPDATE Hero SET hero_level = 1, hero_xp = 0 WHERE hero_id = ".$_SESSION['hero'];
        majDonneesPDO($db,$sql);
        unset($sql);

        $sql ="INSERT into Stat values (".$_SESSION['hero'].", (select lup_id from LevelUp where level_id = (select hero_level from Hero where hero_id = ".$_SESSION['hero'].") and class_id = (select hero_class from Hero where hero_id = ".$_SESSION['hero'].")),
                        (select (class_basePV + levup_pvBonus) as sta_pv from LevelUp join Class using (class_id) where level_id = (select hero_level from Hero where hero_id = ".$_SESSION['hero'].") and class_id = (select hero_class from Hero where hero_id = ".$_SESSION['hero'].")),
                        (select (class_baseMana + levup_manaBonus) as sta_mana from LevelUp join Class using (class_id) where level_id = (select hero_level from Hero where hero_id = ".$_SESSION['hero'].") and class_id = (select hero_class from Hero where hero_id = ".$_SESSION['hero'].")),
                        (select (class_baseStrength + levup_strengthBonus) as sta_strength from LevelUp join Class using (class_id) where level_id = (select hero_level from Hero where hero_id = ".$_SESSION['hero'].") and class_id = (select hero_class from Hero where hero_id = ".$_SESSION['hero'].")),
                        (select (class_baseInitiative + levup_initiativeBonus) as sta_initiative from LevelUp join Class using (class_id) where level_id = (select hero_level from Hero where hero_id = ".$_SESSION['hero'].") and class_id = (select hero_class from Hero where hero_id = ".$_SESSION['hero'].")) )"; 
        majDonneesPDO($db,$sql);
        unset($sql);
        $this->index();
        exit();
    }
}
