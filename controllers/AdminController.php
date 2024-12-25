<?php

include_once "./core/pdo_agile.php";

class AdminController {
    public function index() {
        if(!isset($_SESSION['admin'])){ 
            require 'views/home_view.php';
            exit();
        }
        $admin = new Admin();
        require_once 'views/admin_view.php';
    }

    public function supprimerUser(){
        require("./core/Database.php");
        $user = [];
        LireDonneesPDO2($db, "select * from User where user_id = ".$_POST['supprimerUser'], $user); 
        $user = new User($user[0]['user_id'], $user[0]['user_mail'], $user[0]['user_passwd']);

        $tab = [];
        LireDonneesPDO2($db, "select count(*) as nb from Quest where user_id = ".$_POST['supprimerUser'], $tab); 

        if($tab[0]['nb'] >= 1){
            $heroes = [];
            LireDonneesPDO2($db, "select hero_id from Quest where user_id = ".$_POST['supprimerUser'], $heroes); 

            $sql = "DELETE FROM Hero WHERE hero_id = ".$heroes[0]['hero_id'];
            majDonneesPDO($db,$sql);
        }

        $user->delete();

        unset($_SESSION['btnSuppValue']);

        $this->index();
        exit();
    }
}