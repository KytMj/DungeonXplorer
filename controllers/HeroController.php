<?php
include_once "./core/pdo_agile.php";
require_once "./models/Hero.php";

class HeroController {
    private $hero;

    public function index(){
        if(!isset($_SESSION['hero'])){
            require 'views/home_view.php';
        }else{
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
                LireDonneesPDO2($db,"SELECT * FROM Hero join Stat using(hero_id) left join Equipement using(hero_id) WHERE hero_id = ".$hero_id, $tab);
                $this->hero = new Hero($tab[0]['hero_name'], $tab[0]['sta_pv'], $tab[0]['sta_mana'], $tab[0]['sta_strength'], $tab[0]['sta_initiative'], $tab[0]['ite_armor']);
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
