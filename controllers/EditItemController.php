<?php
require_once "./models/Admin.php";
include_once "./core/pdo_agile.php";
class EditItemController {

    public function index() {
        if(!isset($_SESSION['admin'])){ 
            require 'views/home_view.php';
            exit();
        }
        $admin = new Admin();
        require_once 'views/edit_item_view.php';
    }
    
    public function creation(){
        require("./core/Database.php");
        if(isset($_SESSION['admin'])){
            $data = $_POST;
            if(isset($data['submit'])){
                $nom = isset($data['nom']) ? trim($data['nom']) : '';
                $itetype = isset($data['itetype']) ? trim($data['itetype']) : '';
                $description = isset($data['description']) ? trim($data['description']) : '';
                $itecle = isset($data['itecle']) ? trim($data['itecle']) : '';
                $effect = isset($data['effect']) ? trim($data['effect']) : '';
                $equipable = isset($data['iteequipable']) ? trim($data['iteequipable']) : '';

                // Vérifie si tous les champs sont remplis après nettoyage
                if (!empty($nom) && !empty($itetype) && !empty($description) && !empty($itecle) && !empty($effect) && !empty($equipable)) {
                    $tab = [];
                    LireDonneesPDO2($db, "select count(*) as nb from Items where ite_name = '".$data['nom']."'", $tab);
                    if($tab[0]['nb'] == 0){
            
                        $data['nom'] = htmlspecialchars($data['nom']);
                        $data['itetype'] = htmlspecialchars($data['itetype']);
                        $data['description'] = htmlspecialchars($data['description']).trim();
                        $data['itecle'] = htmlspecialchars($data['itecle']);
                        $data['effect'] = htmlspecialchars($data['effect']);
                        $data['iteequipable'] = htmlspecialchars($data['iteequipable']);
                        
                        $sql = "INSERT into Items (ite_name, ite_type, ite_description, ite_itemCle, ite_effects, ite_equipable) values 
                            ('".$data['nom']." ' , ' ".$data['itetype']." ' , ' ".$data['description']." ' , ".$data['itecle']." , ' ".$data['effect']." ' , ".$data['iteequipable']."  )";
                        majDonneesPDO($db,$sql);

                        $this->index();
                        exit();
                    }else{
                        $erreur = "L'Objet existe déjà";
                        $_SESSION['erreur'] = $erreur;
                        require_once 'views/404.php';
                        exit();
                    }
                }else{
                    $erreur = "Tout n'est pas rempli";
                    $_SESSION['erreur'] = $erreur;
                    require_once 'views/404.php';
                    exit();
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
            LireDonneesPDO2($db, "select count(*) as nb from Items where ite_id = ".$_POST['deleteItem'], $tab); 

            if($tab[0]['nb'] != 0){
                $sql3 = "DELETE FROM Equipement WHERE ite_primaryWeapon = ".$_POST['deleteItem'];
                majDonneesPDO($db,$sql3);

                $sql4 = "DELETE FROM Equipement WHERE ite_secondaryWeapon = ".$_POST['deleteItem'];
                majDonneesPDO($db,$sql4);

                $sql5 = "DELETE FROM Equipement WHERE ite_armor = ".$_POST['deleteItem'];
                majDonneesPDO($db,$sql5);

                $sql6 = "DELETE FROM Equipement WHERE ite_shield = ".$_POST['deleteItem'];
                majDonneesPDO($db,$sql6);

                $sql1 = "DELETE FROM Inventory WHERE ite_id = ".$_POST['deleteItem'];
                majDonneesPDO($db,$sql1);

                $sql2 = "DELETE FROM Reward WHERE ite_id = ".$_POST['deleteItem'];
                majDonneesPDO($db,$sql2);

                

                $sql = "DELETE FROM Items WHERE ite_id = ".$_POST['deleteItem'];
                majDonneesPDO($db,$sql);

                
            }else{
                $erreur = "L'Objet' n'existe pas.";
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
        if(isset($_SESSION['admin'])){
            $data = $_POST;
            if(isset($data['submit'])){
                $nom = isset($data['nom']) ? trim($data['nom']) : '';
                $itetype = isset($data['itetype']) ? trim($data['itetype']) : '';
                $description = isset($data['description']) ? trim($data['description']) : '';
                $itecle = isset($data['itecle']) ? trim($data['itecle']) : '';
                $effect = isset($data['effect']) ? trim($data['effect']) : '';
                $equipable = isset($data['iteequipable']) ? trim($data['iteequipable']) : '';
                
                if (!empty($nom) && !empty($itetype) && !empty($description) && !empty($itecle) && !empty($effect) && !empty($equipable)) {
                    $tab = [];
                    LireDonneesPDO2($db, "select count(*) as nb from Items where ite_name = '".$data['nom']."'", $tab);
                    if($tab[0]['nb'] == 0){   

                        $data['nom'] = htmlspecialchars($data['nom']).trim();
                        $data['itetype'] = htmlspecialchars($data['itetype']).trim();
                        $data['description'] = htmlspecialchars($data['description']).trim();
                        $data['itecle'] = htmlspecialchars($data['itecle']);
                        $data['effect'] = htmlspecialchars($data['effect']).trim();
                        $data['iteequipable'] = htmlspecialchars($data['iteequipable']);
                        
                        $sql = "UPDATE Items SET ite_name = '".$data['nom']."',
                            ite_type = '". $data['itetype']."', 
                            ite_description = ". $data['description'].", 
                            ite_itemCle = '".$data['itecle']."', 
                            ite_effects = ".$data['effect'].", 
                            ite_equipable = ".$data['iteequipable']."
                            WHERE ite_id = ".$data['ite_id']; 

                        majDonneesPDO($db, $sql);
                        $this->index(); 
                    } else { 
                        $erreur = "L'Objet' n'existe pas."; 
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

    public function getItemData($id) {
        $admin =new Admin();
        if($id > 0){
            $admin->getItemData($id); 
        } else { 
            echo json_encode(["error" => "ID d'objet non spécifié ou requête incorrecte"]); 
        }
    }


}