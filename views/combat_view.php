<?php 
    include_once "./controllers/HeroController.php";
    include_once "./controllers/CombatController.php";

    $combatC = new CombatController();
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
        $combatC->isHeroWinner();
        exit();
    } 
?>


<?php require_once 'views/header.php';?>
    <h1>Combat: <br></h1>
    <?php
        $combatC->show();
    ?>
    <form method="POST" action="combat">
        <button type="submit" name="action" value="hit">Hit</button>
        <button type="submit" name="action" value="drink">Drink</button>
    </form>
</body>
</html>