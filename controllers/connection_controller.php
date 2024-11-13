<?php

$connect = false;
session_start();

include_once "./../core/pdo_agile.php";
include_once "./../core/mysql-dx05.php";

// connexion à la bdd
$db_username = $mysql_user;		
$db_password = $mysql_pass;	
$db = $mysql_db;

$conn = OuvrirConnexionPDO($db,$db_username,$db_password);

//  variables
$mail = $_POST["mail"];
$mdp = $_POST["code"];

// connexion sql

$sql = "select * from account where mail ='". $mail."'";
$res = LireDonneesPDO1($conn,$sql, $tab);



if($res == 0) {$connect = false;}
else if($tab[0]['USR_MDP'] == $mdp){
    
    
    $_SESSION['num_utilisateur'] = $tab[0]['USR_NUM'];
    $_SESSION['nom'] = $tab[0]['USR_NOM'];
    $_SESSION['prenom'] = $tab[0]['USR_PRENOM'];


    $connect = true;
    echo "Bonjour ".$tab[0]['USR_PRENOM']." ".$tab[0]['USR_NOM'];
}
else {
    echo "Mot de passe incorrect";
    $connect = false;
}

if ($connect){
    $_SESSION['just_connected'] = true;
    header("Location: ./../index.php");
} else{
    header("Location: ./erreur_formulaire_connexion.html");
}

?>

