<?php

// controllers/ChapterController.php

require_once "./models/Chapter.php";
include_once "./core/pdo_agile.php";


class ChapterController
{
    private $chapters = [];

    public function index() {
        $_SESSION['chapter'] = intval(substr($_SERVER['REQUEST_URI'], -1));
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
            $choices
            );
            
        }
    }

    public function show($id)
    {
        $chapter = $this->getChapter($id);

        if ($chapter) {
            include './view/chapter_view.php'; // Charge la vue pour le chapitre
        } else {
            // Si le chapitre n'existe pas, redirige vers un chapitre par défaut ou affiche une erreur
            $_SESSION['erreur'] = "Chapitre non trouvé !";
            include_once 'views/404.php';
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
