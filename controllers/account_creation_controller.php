<?php
header("Location: ./../Profil/profil.php");
session_start();
function afficherObj($obj)
	{
		echo "<PRE>";
		print_r($obj);
		echo "</PRE>";
	}

include_once "./../core/pdo_agile.php";
include_once "./../core/mysql-dx05.php";

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

// calcul per_num
$sql = "SELECT MAX(USR_NUM) as MX from USER";
LireDonneesPDO1($conn, $sql, $tab);

$per_num = $tab[0]['MX'] + 1;


// insertion sql
if ($erreur == false )
	{	
        $sql_verif_existence = "SELECT * FROM USER WHERE per_courriel = '".$mail."'";
        if(LireDonneesPDO1($conn,$sql_verif_existence, $tab) > 0){
            echo "Cet utilisateur existe déjà.<br/>";
        }
        else {

            $_SESSION['num_utilisateur'] = $per_num;
            $_SESSION['nom'] = $nom;
            $_SESSION['prenom'] = $prenom;
            $sql = "INSERT INTO USER(USR_NUM, USR_MDP, USR_NOM, USR_PRENOM, USR_MAIL) VALUES ($per_num,'$mdp','".$nom."','".$prenom."','".$mail."')";
		
        
            $res = majDonneesPDO($conn,$sql);


		$sql = "commit";
		$res = majDonneesPDO($conn, $sql);


    	}    
	}
	else{
		afficherObj("Le formulaire n'est pas complet");
	}

	$conn = null;

?>