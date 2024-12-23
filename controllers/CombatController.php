<?php
    require_once "./models/Combat.php";
    require_once "./models/Monster.php";

    class CombatController{
        private $combat;
        private $curP;

        public function index(){
            require_once 'views/combat_view.php';
        }

        public function __construct($hero, $chap_id)
        {
            require("./core/Database.php");
            $tab = [];
            LireDonneesPDO2($db, "select * from Monster where mons_id = (select mons_id from Encounter where chap_id = ".$chap_id.")", $tab);
            $monster = new Monster($tab[0]['mons_name'], $tab[0]['mons_pv'], $tab[0]['mons_strength'], $tab[0]['mons_initiative'], 0);
            $this->combat = new Combat($monster, $hero);

        }

        public function init(){
            $_SESSION['curP'] = $this->combat->quiCommence();
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

        public function show(){
            echo ("Player PV: " . $this->combat->getHero()->getPV() . " Monster PV: " . $this->combat->getMonster()->getPV() . "<br>");
        }

        public function heroPlay(){
            $this->combat->heroJoue();
            $this->curP = 1;
        }

        public function monsterPlay(){
            $this->combat->monsterJoue();
            $this->curP = 0;
        }

        public function updatePV($v1, $v2){
            $this->combat->setHeroH($v1);
            $this->combat->setMonsterH($v2);
        }

        public function getHeroPV(){
            return $this->combat->getHero()->getPV();
        }

        public function getMonsterPV(){
            return $this->combat->getMonster()->getPV();
        }

        public function isEnded(){
            if ($this->combat->getHero()->isDead() || $this->combat->getMonster()->isDead()) return TRUE;
            return FALSE;
        }

        public function isHeroWinner($chap_id){
            require("./core/Database.php");
            if ($this->combat->getMonster()->isDead() && !($this->combat->getHero()->isDead())){
                /*$tab = [];
                LireDonneesPDO2($db, "REQUETE".$chap_id.")", $tab);*/
            }
            else{
                //
            }
        }

        public function usePotion($value){
            $this->combat->heal($value);
        }


    }