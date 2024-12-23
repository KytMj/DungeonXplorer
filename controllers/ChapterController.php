<?php

// controllers/ChapterController.php

require_once "./models/Chapter.php";
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
}
