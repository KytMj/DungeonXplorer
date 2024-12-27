<?php
    require_once "./models/Combat.php";
    require_once "./models/Monster.php";
    include_once "./core/pdo_agile.php";
    include_once "./controllers/HeroController.php";

class CombatController{
        private $combat;
        private $curP;

        public function index(){
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
            require_once 'views/combat_view.php';
        }

        public function __construct()
        {
            require("./core/Database.php");
            $tab = [];
            LireDonneesPDO2($db, "select * from Monster where mons_id = (select mons_id from Encounter where chap_id = ".$_SESSION['chapter'].")", $tab);
            $monster = new Monster($tab[0]['mons_name'], $tab[0]['mons_pv'], $tab[0]['mons_strength'], $tab[0]['mons_initiative'], 0);

            $heroData = [];
            LireDonneesPDO2($db, "select * from Hero join Stat using(hero_id) where hero_id = ".$_SESSION['hero'], $heroData);
            $hero = new Hero($heroData[0]['hero_name'], $heroData[0]['sta_pv'], $heroData[0]['sta_mana'], $heroData[0]['sta_strength'], $heroData[0]['sta_initiative'], 0);
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

        public function isHeroWinner(){
            require("./core/Database.php");
            unset($_POST['submit']);
            $choices = [];
            LireDonneesPDO2($db, "select * from Links where chapter_id = ".$_SESSION['chapter'], $choices);
            foreach ($choices as $path):
                if(strpos(strval($path['description']), 'mort') !== false){
                    $next = $path['next_chapter_id'];
                }
                if(strpos(strval($path['description']), 'vaincu') !== false){
                    $death = $path['next_chapter_id'];
                }
            endforeach;
            if ($this->combat->getMonster()->isDead() && !($this->combat->getHero()->isDead())){
                $_SESSION['chapter'] = $next;
            }
            else{
                $_SESSION['chapter'] = $death;
            }
            require_once 'views/chapter_view.php';
            exit();
        }

        public function usePotion($value){
            $this->combat->heal($value);
        }
}
?>