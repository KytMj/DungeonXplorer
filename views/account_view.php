<?php

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

try {
    $conn = OuvrirConnexionPDO($db, $db_username, $db_password);
} catch (Exception $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}


$sql = "select per_ville from alp_personne where per_num = ".$_SESSION['num_utilisateur'];
$res = LireDonneesPDO1($conn, $sql, $tab);
$ville = $tab[0]['PER_VILLE'];

$sql = "select per_telephone from alp_personne where per_num = ".$_SESSION['num_utilisateur'];
$res = LireDonneesPDO1($conn, $sql, $tab);
$telephone = $tab[0]['PER_TELEPHONE'];


$sql = "select per_courriel from alp_personne where per_num = ".$_SESSION['num_utilisateur'];
$res = LireDonneesPDO1($conn, $sql, $tab);
$mail = $tab[0]['PER_COURRIEL'];


$sql = "select per_mdp from alp_personne where per_num = ".$_SESSION['num_utilisateur'];
$res = LireDonneesPDO1($conn, $sql, $tab);
$code = $tab[0]['PER_MDP'];



?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Mon profil</title>

</head>

<body>
  <form id="profil" name="profil" action="maj_profil.php" method="post"
    enctype="application/x-www-form-urlencoded">
    <fieldset>
      <legend>Mon profil</legend>
      <br />
      <label for="nom">Nom : </label><input type="text" id="nom" name="nom" size="20" value="<?php echo($_SESSION['nom']);?>"  pattern="[A-Za-zàèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ]*" required>

      <br /><br />
      <label for="prenom">Prénom : </label><input type="text" id="prenom" name="prenom" size="20" value="<?php echo($_SESSION['prenom']);?>"  pattern="[A-Za-zàèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ]*" required>
      <br /><br />

      <label for="ville">Ville : </label><input type="text" id="ville" name="ville" size="20" value="<?php echo($ville);?>" pattern="[A-Za-zàèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ]*">

      <br /><br />
      <label for="telephone">Numéro de téléphone : </label><input type="text" id="telephone" name="telephone" size="20" value="<?php echo($telephone);?>" pattern="[0-9]{10}">

      <br /><br />
      <label for="mail ">Adresse mail :</label><input type="text" id="mail" name="mail" size="20" value="<?php echo($mail);?>" pattern="^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$" required>

      <br /><br />
      <label for="mdp">Mot de passe : </label><input type="password" id="code" name="code" size="20" AUTOCOMPLETE=OFF value="<?php echo($code);?>"pattern="^(?:(?:(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]))|(?:(?=.*[a-z])(?=.*[A-Z])(?=.*[*.!@$%^&(){}[]:;<>,.?/~_+-=|\]))|(?:(?=.*[0-9])(?=.*[A-Z])(?=.*[*.!@$%^&(){}[]:;<>,.?/~_+-=|\]))|(?:(?=.*[0-9])(?=.*[a-z])(?=.*[*.!@$%^&(){}[]:;<>,.?/~_+-=|\]))).{8,32}$" required>

      <br /><br />
    </fieldset>
    <input type="submit" name="BtnMaj" value="Mettre à jour"> &nbsp;&nbsp;&nbsp;
    <input type="button" name = "BtnSuppr" value="Supprimer mon compte" onclick="location.href='suppression.php';">
    <br />
    <br />
  </form>
</body>

</html>


<?php 

$conn = null;

?>