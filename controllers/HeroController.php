<?php
include_once "./core/pdo_agile.php";
require_once "./models/Hero.php";

class HeroController {
    private $hero;

    public function index(){
        if(!isset($_SESSION['hero'])){
            require 'views/home_view.php';
            exit();
        }
        require_once 'views/hero_view.php';
    }

    public function __construct() {
        require("./core/Database.php");
        if(isset($_SESSION['login'])){
            $tab = [];
            LireDonneesPDO2($db, "select hero_id from Quest where user_id = ( select user_id from User where user_mail = '".$_SESSION['login']."')", $tab); // Pour récupérer le hero_id
            $hero_id = $tab[0]['hero_id'];
            unset($tab);
            if($hero_id != null){
                //potentiellement fausse car pas de tests possibles pour l'instant 
                $stmt = $db->prepare("SELECT * FROM Hero join Stat using(hero_id) join Equipement using(hero_id) WHERE hero_id = (select hero_id from :hero_id)");
            
                $stmt->execute([':id' => $id]);
                $tab = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->hero = new Hero($tab['hero_name'], $tab['stat_pv'], $tab['stat_mana'], $tab['stat_strength'], $tab['stat_initiative'], $tab['ite_armor']);
            }else{
                $erreur = "Vous n'avez pas d'aventure en cours.";
                $_SESSION['erreur'] = $erreur;
                require_once 'views/404.php';
                exit();
            }
        }
    }

    public function show() {
        echo "<h3>".$this->hero->getName()."</h3>";
        echo "<p>".$this->hero->getStats()."</p>";
    }

    public function getHero(){
        return $this->hero;
    }
}
