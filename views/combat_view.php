<?php 
    session_start();
    include_once "./../controllers/HeroController.php";

    include_once "./../controllers/CombatController.php";

    $test = new HeroController(1);
    $combatC = new CombatController(new Monster("GRR", 50, 10, 10, 0) ,$test->getHero());
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
        echo ("aaaaa");
        header("Location: chapter_view.php");
        unset($_SESSION['curP']);
        unset($_SESSION['hpv']);
        unset($_SESSION['mpv']);
        unset($_POST['action']);
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