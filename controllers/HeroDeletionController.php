<?php
require_once "./models/User.php";
include_once "./core/pdo_agile.php";
class HeroDeletionController {
    
    public function deletion(){
        require("./core/Database.php");
        
        if(isset($_SESSION['login'])){
            $tab = [];
            LireDonneesPDO2($db, "select count(*) as nb from Quest where user_id = 
                ( select user_id from User where user_mail = '".$_SESSION['login']."')", $tab);
            //Si le héro existe alors on peut supprimer
            if($tab[0]['nb'] == 1){
                unset($tab);
                LireDonneesPDO2($db, "select hero_id from Quest where user_id = ( select user_id from User where user_mail = '".$_SESSION['login']."')", $tab); // Pour récupérer le hero_id
                // Suppression du personnage quand il existe déjà
                $hero_id = $tab[0]['hero_id'];
                procPDO($db, "delete from Quest where hero_id = ".$hero_id);
                procPDO($db," delete from Stat where hero_id = ".$hero_id );
                procPDO($db," delete from Hero where hero_id = ".$hero_id );
                require_once 'views/hero_creation_view.php';
            }else{
                $erreur = "Vous n'avez pas d'aventure en cours.";
                $_SESSION['erreur'] = $erreur;
                require_once 'views/404.php';
                exit();
            }
        }else{
            $erreur = "Vous n'êtes pas connecté.";
            $_SESSION['erreur'] = $erreur;
            require_once 'views/404.php';
            exit();
        }
    }

}