<?php

// controllers/ChapterController.php

require_once "./../models/Chapter.php";
include "./../core/pdo_agile.php";


class ChapterController
{
    // private $conn = OuvrirConnexionPDO($_SESSION['dbHost'], $_SESSION['dbName'], $_SESSION['dbUser'], $_SESSION['dbPassword']);
    private $chapters = [];
    
    public function __construct()
    {
        require("./../core/Database.php");
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
                if ($l['chapter_id'] == $chapter['id']){
                    array_push($choices, ["text" => $l['description'], "chapter" => $l['next_chapter_id']]);
                }
            }
                      
            $this->chapters[] = new Chapter(
            $chapter['id'],
            $chapter['Titre'],
            $chapter['content'],
            $chapter['image'],
            $choices
            );
            
        }
    }

    public function show($id)
    {
        $chapter = $this->getChapter($id);

        if ($chapter) {
            include '/view/chapter.php'; // Charge la vue pour le chapitre
        } else {
            // Si le chapitre n'existe pas, redirige vers un chapitre par défaut ou affiche une erreur
            header('HTTP/1.0 404 Not Found');
            echo "Chapitre non trouvé!";
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
