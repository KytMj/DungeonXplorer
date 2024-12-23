<?php

include_once "./../core/pdo_agile.php";
require_once "./../models/Hero.php";

class HeroController {
    private $hero;

    public function index(){
        if(!isset($_SESSION['hero'])){
            require 'views/home_view.php';
            exit();
        }
        require_once 'views/hero_view.php';
    }

    public function __construct($id) {
        require("./../core/Database.php");
        $tab = [];

        //potentiellement fausse car pas de tests possibles pour l'instant 
        $stmt = $db->prepare("SELECT * FROM Hero join Stat using(hero_id) join Equipement using(hero_id) WHERE hero_id = :id");
        
        $stmt->execute([':id' => $id]);
        $tab = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->hero = new Hero($tab['hero_name'], $tab['stat_pv'], $tab['stat_mana'], $tab['stat_strength'], $tab['stat_initiative'], $tab['ite_armor']);
    }

    public function show() {
        echo "<h3>".$this->hero->getName()."</h3>";
        echo "<p>".$this->hero->getStats()."</p>";
    }

    public function getHero(){
        return $this->hero;
    }
}
