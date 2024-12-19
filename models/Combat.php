<?php

require_once __DIR__ . "/Hero.php";
require_once __DIR__ . "/Monster.php";

    class Combat{
        private $monster;
        private $hero;


        public function __construct ($monster, $hero){
            $this->monster =$monster;
            $this->hero =$hero;
        }
        public function quiCommence (){
            $val = $this->monster->getInitiative() - $this->hero->getInitiative();
            if ($val < 1) return $this->monster;
            return $this->hero;
        }
        public function heroJoue(){
            $this->monster->defend($this->hero->attaque());
        }
        public function monsterJoue(){
            $this->hero->defend($this->monster->attaque());
        }
        public function heal($value){
            $this->hero->boirePotion($value);
        }

        public function getHero(){
            return $this->hero;
        }
        public function getMonster(){   
            return $this->monster;
        }


    }