<?php

    include_once "./../controllers/HeroController.php";

    include_once "./../controllers/CombatController.php";


    $test = new HeroController(1);
    echo ("Hero: <br/>");
    echo(
    $test->show()
    );

    $combatC = new CombatController(new Monster("GRR", 50, 22, 0, 2) ,$test->getHero());
    $combatC->run();
