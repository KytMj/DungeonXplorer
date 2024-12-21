<?php

class AventureController {
    public function index() {
        require("./core/Database.php");
        require_once "./models/User.php";
        include_once "./core/pdo_agile.php";
    
        $quest = false;
        if(isset($_SESSION['login'])){
            $tab = [];
            LireDonneesPDO2($db, "select count(*) as nb from Quest where user_id = 
                ( select user_id from User where user_mail = '".$_SESSION['login']."')", $tab);
            if(tab[0] >= 1){
                $quest = true;
            }else{
                $quest = false;
            }  
        }
        require_once 'views/aventure_view.php';
        
    }
}