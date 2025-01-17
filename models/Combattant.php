<?php
    abstract class Combattant{
        protected $name;
        protected $initiative;
        protected $strength;
        protected $defArmor;
        protected $pv;
        protected $pvMax;
        protected $dgtPrimaryWeapon;


        public function getName(){
            return $this->name;
        }

        public function getInitiative(){
            return rand(1,6) + $this->initiative;
        }

        public function attaque(){
            return rand(1,6) + $this->strength + $this->dgtPrimaryWeapon;
        }
        
        public function defend($damages){
            $defence = rand(1,6) + (int)($this->strength/2) + $this->defArmor;
            $degats = max(0, $damages - $defence);
            $this->pv -= $degats;
        }
        public function isDead(){
            return !($this->pv > 0);
        }
        
        public function getPV(){
            return $this->pv;
        }

        public function setPV($value){
            $this->pv = $value;
        }

    }