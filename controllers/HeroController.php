<?php
include_once "./core/pdo_agile.php";
require_once "./models/Hero.php";

class HeroController {
    private $hero;

    public function index(){
        if(!isset($_SESSION['hero'])){
            require 'views/home_view.php';
        }else{
            $hero = new HeroController();
            require_once 'views/hero_view.php';
        }
    }

    public function __construct() {
        require("./core/Database.php");
        if(isset($_SESSION['login'])){
            $tab = [];
            LireDonneesPDO2($db, "select hero_id from Quest where user_id = ( select user_id from User where user_mail = '".$_SESSION['login']."')", $tab); // Pour récupérer le hero_id
            $hero_id = $tab[0]['hero_id'];
            if($hero_id != null){
                unset($tab);
                $this->hero = new Hero($hero_id);
            }else{
                $erreur = "Vous n'avez pas d'aventure en cours.";
                $_SESSION['erreur'] = $erreur;
                require_once 'views/404.php';
                exit();
            }
        }
    }

    public function show() {
        echo "<div class='description'>";
        echo "<h2>".$this->hero->getName()."</h3>";
        echo "<p>".$this->hero->getStat()."</p>";
        echo "</div>";
    }

    public function getHero(){
        return $this->hero;
    }
}
