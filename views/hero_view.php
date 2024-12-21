<?php

    include_once "./../controllers/HeroController.php";

    $test = new HeroController(1);
    echo ("Hero: <br/>");
    echo(
    $test->show()
    );

