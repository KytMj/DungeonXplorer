<?php
require_once "./models/User.php";
include_once "./core/pdo_agile.php";

class AccountController {
    public function index() {
        if(!isset($_SESSION['login'])){
            require 'views/home_view.php';
            exit();
        }
        require_once 'views/account_view.php';
    }

    public function modifMail(){

    }

    public function modifMDP(){
        
    }

    public function supprimerCompte(){
        require("./core/Database.php");
        $user = [];
        LireDonneesPDO2($db, "select * from User where user_mail = '".$_SESSION['login']."'", $user); 
        $user = new User($user[0]['user_id'], $user[0]['user_mail'], $user[0]['user_passwd']);

        if(isset($_SESSION['hero'])){
            $heroes = [];
            LireDonneesPDO2($db, "select hero_id from Quest where user_id = ".$user->getId(), $heroes); 

            $sql = "DELETE FROM Hero WHERE hero_id = ".$heroes[0]['hero_id'];
            majDonneesPDO($db,$sql);
            unset($_SESSION['hero']);
        }
        $user->delete();

        $deco = new ConnectionController();
        $deco->deconnexion();
        exit();
    }
}