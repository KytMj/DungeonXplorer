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
        echo "<pre>";
        print_r($tab);  
        echo "</pre>";
        
        // $this->chapter[] = new Chapter(

        // );

        $this->chapters[] = new Chapter(
            1,
            "La Forêt Enchantée",
            "Vous vous trouvez dans une forêt sombre et enchantée. Deux chemins se présentent à vous.",
            "images/forêt.jpg", // Chemin vers l'image
            [
                ["text" => "Aller à gauche", "chapter" => 2],
                ["text" => "Aller à droite", "chapter" => 3]
            ]
        );

        $this->chapters[] = new Chapter(
            2,
            "Le Lac Mystérieux",
            "Vous arrivez à un lac aux eaux limpides. Une créature vous observe.",
            "images/lac.jpg", // Chemin vers l'image
            [
                ["text" => "Nager dans le lac", "chapter" => 4],
                ["text" => "Faire demi-tour", "chapter" => 1]
            ]
        );

        $this->chapters[] = new Chapter(
            3,
            "MORT",
            "un sanglier est devant vous !",
            "./../image/Wild boar.jpg",
            [
                ["text" => "recommencer", "chapter" => 1]
            ]
        );

        $this->chapters[] = new Chapter(
            4,
            "NOYADE",
            "bluoblubobuulmobulb",
            "image/noyade.jpg",
            [
                ["text" => "recommencer", "chapter" => 1]
            ]
        );
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
