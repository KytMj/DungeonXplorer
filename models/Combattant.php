<?php
    abstract class Combattant{
        protected $name;
        protected $initiative;
        private $strength;
        private $armor;
        private $mana;
        private $pv;


        public function getName(){
            return $this->name;
        }

        public function getInitiative(){
            return rand(1,6) + $this->initiative;
        }

        public function attaque(){
            return rand(1,6) + $this->strength;
        }
        public function defend($damages){
            $defence = rand(1,6) + (int)($this->strength/2) + $this->armor;
            $degats = max(0, $damages - $defence);
            $this->pv -= $degats;
        }

    }