<?php
session_start();
include_once "./../core/pdo_agile.php";
include_once "./../core/mysql-dx05.php";
class AccountCreationController {


    
    public function afficherObj($obj)
        {
            echo "<PRE>";
            print_r($obj);
            echo "</PRE>";
        }
    
    
    
    // connexion à la bdd
    $db_username = $mysql_user;		
    $db_password = $mysql_pass;	
    $db = $mysql_db;
    
    $conn = OuvrirConnexionPDO($db,$db_username,$db_password);
    
    $erreur=false;
    
    //afficherObj($_POST);
    
    // récupération des données du formulaire
    if(is_null(($_POST["nom"]))) {$erreur = true;}
    else $nom = $_POST["nom"];
    if(is_null($_POST["prenom"])) $erreur = true;
    else $prenom = $_POST["prenom"];
    if(is_null($_POST["mail"])) $erreur = true;
    else $mail = $_POST["mail"];
    if(is_null($_POST["code"])) $erreur = true;
    else $mdp = $_POST["code"];
    
    
    
    // insertion sql
    if ($erreur == false )
        {	
            $sql_verif_existence = "SELECT * FROM USER WHERE per_courriel = '".$mail."'";
            if(LireDonneesPDO1($conn,$sql_verif_existence, $tab) > 0){
                echo "Cet utilisateur existe déjà.<br/>";
            }
            else {
    
                $_SESSION['usr_num'] = $per_num;
                $_SESSION['usr_nom'] = $nom;
                $_SESSION['usr_prenom'] = $prenom;
                $sql = "INSERT INTO DGX_USER(usr_firstname, usr_lastname, usr_mail, usr_password) VALUES ('".$prenom."','".$nom."', '".$mail."', '$mdp',)";
            
            
                $res = majDonneesPDO($conn,$sql);
    
    
            $sql = "commit";
            $res = majDonneesPDO($conn, $sql);
    
    
            }    
        }
        else{
            afficherObj("Le formulaire n'est pas complet");
        }
    
        $conn = null;
    }

    public function index() {

        require_once 'views/account_creation_view.php';
    }
}