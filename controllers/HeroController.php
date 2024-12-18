<?php

include_once "./../core/pdo_agile.php";
require_once "./../models/Hero.php";

class HeroController {
    private $hero;

    public function __construct($id) {
        require("./../core/Database.php");
        $tab = [];
        $stmt = $db->prepare("SELECT * FROM hero WHERE her_id = :id");
        $stmt->execute([':id' => $id]);
        $tab = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->hero = new Hero($tab['her_name'], $tab['her_pv'], $tab['her_mana'], $tab['her_strength'], $tab['her_initiative']);
    }

    public function show() {
        echo $this->hero->getName() . "<br>";
        echo $this->hero->getStats();
    }
}
