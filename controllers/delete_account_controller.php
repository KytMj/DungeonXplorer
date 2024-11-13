<?php 
header("Location: ./../index.php");
session_start();

print_r($_SESSION);

$prenom = $_SESSION['prenom'];
$per_num = $_SESSION['num_utilisateur'];

session_destroy();

include_once "./../core/pdo_agile.php";
include_once "./../core/mysql-dx05.php";

// connexion à la bdd
$db_username = $mysql_user;		
$db_password = $mysql_pass;	
$db = $mysql_db;


$conn = OuvrirConnexionPDO($db,$db_username,$db_password);

// Suppression 
$sql = "delete from user where usr_num = " . $per_num;
$res = majDonneesPDO($conn, $sql);

majDonneesPDO($conn, "commit");



if($res){
    echo "Votre compte a bien été supprimé. Bonne continuation ". $prenom;
}
else{ echo "ERREUR : veuillez réessayer";} 

$conn = null;
?>