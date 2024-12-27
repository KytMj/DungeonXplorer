<?php
require_once "./models/Admin.php";
include_once "./core/pdo_agile.php";
class EditMonsterController {

    public function index() {
        if(!isset($_SESSION['admin'])){ 
            require 'views/home_view.php';
            exit();
        }
        $admin = new Admin();
        require_once 'views/edit_monster_view.php';
    }
    
    public function creation(){
        require("./core/Database.php");
        if(isset($_SESSION['admin'])){
            $data = $_POST;
            if(isset($data['submit'])){
                if(  ((isset($data['nom'])) && !empty($data['nom'])) && (isset($data['bio']) && !empty($data['bio'])) 
                && (isset($data['xp']) && !empty($data['xp'])) && (isset($data['attack']) && !empty($data['attack']))
                && (isset($data['pv']) && !empty($data['pv'])) && (isset($data['initiative']) && !empty($data['initiative']))
                && (isset($data['strength']) && !empty($data['strength'])) && (isset($data['mana']) && !empty($data['mana']))  ){
                    $tab = [];
                    LireDonneesPDO2($db, "select count(*) as nb from Monster where mons_name = '".$data['nom']."'", $tab);
                    if($tab[0]['nb'] == 0){
            
                        $data['nom'] = htmlspecialchars($data['nom']);
                        $data['bio'] = htmlspecialchars($data['bio']);
                        $data['xp'] = htmlspecialchars($data['xp']);
                        $data['attack'] = htmlspecialchars($data['attack']);
                        $data['pv'] = htmlspecialchars($data['pv']);
                        $data['initiative'] = htmlspecialchars($data['initiative']);
                        $data['strength'] = htmlspecialchars($data['strength']);
                        $data['mana'] = htmlspecialchars($data['mana']);
                        
                        $sql = "INSERT into Monster (mons_name, mons_biography, mons_xp, mons_attack, mons_pv, mons_mana, mons_initiative, mons_strength) values 
                            ('".$data['nom']." ' , ' ".$data['bio']." ' , ".$data['xp']." , ' ".$data['attack']."', ".$data['pv']." , ".$data['mana']." , ".$data['initiative']." ,".$data['strength']." )";
                        majDonneesPDO($db,$sql);

                        $this->index();
                    }else{
                        $erreur = "Le monstre existe déjà";
                        $_SESSION['erreur'] = $erreur;
                        require_once 'views/404.php';
                        exit();
                    }
                }
            }
        }else{
            $erreur = "Vous n'avez pas le droit d'accéder à cette page";
            $_SESSION['erreur'] = $erreur;
            require_once 'views/404.php';
            exit();
        }
    }

    public function deletion(){
        require("./core/Database.php");
        if(isset($_SESSION['admin'])){
            $tab = [];
            LireDonneesPDO2($db, "select count(*) as nb from Monster where mons_id = ".$_POST['deleteMonster'], $tab); 

            if($tab[0]['nb'] != 0){
                $sql = "DELETE FROM Monster WHERE mons_id = ".$_POST['deleteMonster'];
                majDonneesPDO($db,$sql);
            }else{
                $erreur = "Le monstre n'existe pas.";
                $_SESSION['erreur'] = $erreur;
                require_once 'views/404.php';
                exit();
            }
            $this->index();
            exit();
        }else{
            $erreur = "Vous n'avez pas le droit d'accéder à cette page";
            $_SESSION['erreur'] = $erreur;
            require_once 'views/404.php';
            exit();
        }
    }


    public function update(){
        require("./core/Database.php"); 
        if(isset($_SESSION['admin'])) { 
            $data = $_POST; 
            if(isset($data['submit']) && isset($data['mons_id'])) { 
                if( ((isset($data['nom'])) && !empty($data['nom'])) 
                    && (isset($data['bio']) && !empty($data['bio'])) 
                    && (isset($data['xp']) && !empty($data['xp']))
                    && (isset($data['attack']) && !empty($data['attack'])) 
                    && (isset($data['pv']) && !empty($data['pv'])) 
                    && (isset($data['initiative']) && !empty($data['initiative'])) 
                    && (isset($data['strength']) && !empty($data['strength'])) 
                    && (isset($data['mana']) && !empty($data['mana'])) ){ 
                    
                    $tab = []; LireDonneesPDO2($db, "select count(*) as nb from Monster where mons_id = ".$data['mons_id'], $tab); 
                    
                    if($tab[0]['nb'] != 0){ 
                        
                        $data['nom'] = htmlspecialchars($data['nom']); 
                        $data['bio'] = htmlspecialchars($data['bio']); 
                        $data['xp'] = htmlspecialchars($data['xp']); 
                        $data['attack'] = htmlspecialchars($data['attack']); 
                        $data['pv'] = htmlspecialchars($data['pv']); 
                        $data['initiative'] = htmlspecialchars($data['initiative']); 
                        $data['strength'] = htmlspecialchars($data['strength']); 
                        $data['mana'] = htmlspecialchars($data['mana']); 
                        
                        $sql = "UPDATE Monster SET mons_name = '".$data['nom']."',
                            mons_biography = '".$data['bio']."', 
                            mons_xp = ".$data['xp'].", 
                            mons_attack = '".$data['attack']."', 
                            mons_pv = ".$data['pv'].", 
                            mons_mana = ".$data['mana'].", 
                            mons_initiative = ".$data['initiative'].", 
                            mons_strength = ".$data['strength']." 
                            WHERE mons_id = ".$data['mons_id']; 
                            
                            majDonneesPDO($db, $sql); 
                            $this->index(); 
                    } else { 
                        $erreur = "Le monstre n'existe pas."; 
                        $_SESSION['erreur'] = $erreur;
                        require_once 'views/404.php'; 
                        exit(); 
                    } 
                } 
            } 
        } else {
            $erreur = "Vous n'avez pas le droit d'accéder à cette page"; 
            $_SESSION['erreur'] = $erreur;
            require_once 'views/404.php'; 
            exit(); 
           
        }
    }

    public function getMonsterData($id) {
        $admin =new Admin();
        if($id > 0){
            $admin->getMonsterData($id); 
        } else { 
            echo json_encode(["error" => "ID de monstre non spécifié ou requête incorrecte"]); 
        }
    }


}