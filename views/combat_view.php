<?php 
    include_once "./controllers/HeroController.php";
    include_once "./controllers/CombatController.php";

    $heroController = new HeroController($_SESSION['hero']);
    if(isset($_POST['submit'])){
        $chap_id = $_POST['submit'];
        $combatC = new CombatController($heroController->getHero(), $chap_id);
    }
    else{
        $_SESSION['erreur'] = "Erreur 404 : Erreur dans le combat";
        require_once 'views/404.php';
        exit();
    }
    if (!isset($_SESSION['curP'])){
        $combatC->init();
    }
    else{
        if (isset($_SESSION['hpv'])){
            $combatC->updatePV($_SESSION['hpv'], $_SESSION['mpv']);
        }
    }
    if ($_SESSION['curP'] == 0){
        if (isset($_POST['action'])){
            if ($_POST['action'] == "hit"){
                $combatC->heroPlay();
            }
            if ($_POST['action'] == "drink"){
                $combatC->usePotion(15);
            }
            $combatC->monsterPlay();
        }
    }else{
        $combatC->monsterPlay();
        $_SESSION['curP'] = 0;

    }
    $_SESSION['hpv'] = $combatC->getHeroPV();
    $_SESSION['mpv'] = $combatC->getMonsterPV();
    if ($combatC->isEnded()){
        unset($_SESSION['curP']);
        unset($_SESSION['hpv']);
        unset($_SESSION['mpv']);
        unset($_POST['action']);
        $combatC->isHeroWinner($chap_id);
        exit();
    } 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combat</title>
</head>
<body>
    <h1>Combat: <br></h1>
    <?php
        $combatC->show();
    ?>
    <form method="POST" action="combat_view.php">
        <button type="submit" name="action" value="hit">Hit</button>
        <button type="submit" name="action" value="drink">Drink</button>
    </form>
</body>
</html>