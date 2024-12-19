<?php
    require_once "./../models/Combat.php";

    class CombatController{
        private $combat;
        private $curP;

        public function __construct($monster, $hero)
        {
            $this->combat = new Combat($monster, $hero);

        }

        public function run(){
            $this->curP = $this->combat->quiCommence();
            for($i = 0; $i < 50; $i++){
                if ($this->combat->getHero()->isDead() || $this->combat->getMonster()->isDead()) return;

                if ($this->curP == $this->combat->getMonster()){
                    $this->combat->monsterJoue();
                    $this->curP = $this->combat->getHero();
                }else{
                    $this->combat->heroJoue();
                    $this->curP = $this->combat->getMonster();
                }
                echo ("Player PV: " . $this->combat->getHero()->getPV() . " Monster PV: " . $this->combat->getMonster()->getPV() . "<br>");
            }

            
        }



    }