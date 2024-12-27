<?php
include_once "./core/pdo_agile.php";

class Admin extends User{
    public function __construct(){
        require("./core/Database.php");
        if(isset($_SESSION['admin'])){
            $admin = [];
            LireDonneesPDO2($db, "select * from User where user_id = ".$_SESSION['admin'], $admin);
            parent::__construct($admin[0]['user_id'], $admin[0]['user_mail'], $admin[0]['user_passwd']);
        }
    }

    public function deleteUser($user_id){
        require("./core/Database.php");
        $sql = "DELETE FROM User WHERE user_id = ".$user_id." and user_isAdmin = 0";
        majDonneesPDO($db,$sql);
    }

    public function getUserList(){
        require("./core/Database.php");
        $players = [];
        LireDonneesPDO2($db, "select * from User where user_isAdmin != 1", $players);
        return $players;
    }
}