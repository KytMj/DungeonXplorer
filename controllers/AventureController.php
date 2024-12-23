<?php

class AventureController {
    public function __construct(){}

    public function index() {
        require("./core/Database.php");
        require_once "./models/User.php";
        include_once "./core/pdo_agile.php";
    
        $hero = false;
        $quest = false;
        if(isset($_SESSION['login'])){
            $tab = [];
            LireDonneesPDO2($db, "select count(*) as nb from Quest where user_id = 
                ( select user_id from User where user_mail = '".$_SESSION['login']."')", $tab);
            if($tab[0]['nb'] >= 1){
                $quest = true;
            }else{
                $quest = false;
            }

            if(isset($_SESSION['hero'])){
                $hero = true;
            }else{
                $hero = false;
            }

            require_once 'views/aventure_view.php';  
        }else{
            $erreur = "Connectez-vous ou créez un compte avant de partir à l'aventure !";
            $_SESSION['erreur'] = $erreur;
            require_once 'views/404.php';
        }
    }

    public function supprimerHero(){
        require("./core/Database.php");
        LireDonneesPDO2($db, "select hero_id from Quest where user_id = '".$_SESSION['hero']."'", $tab); // Pour récupérer le hero_id
        // Suppression du personnage quand il existe déjà
        $hero_id = $tab[0]['hero_id'];
        procPDO($db, "delete from Quest where hero_id = ".$hero_id);
        procPDO($db, "delete from Hero where hero_id = ".$hero_id );
        procPDO($db, "delete from Stat where hero_id = ".$hero_id );

        $aventure = new AventureController();
        $aventure->index();
    }
}