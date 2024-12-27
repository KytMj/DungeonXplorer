<?php
    require_once "./models/Combat.php";
    require_once "./models/Monster.php";
    include_once "./core/pdo_agile.php";
    include_once "./controllers/HeroController.php";
    require_once "./controllers/InventoryController.php";

class CombatController{
        private $combat;
        private $curP;
        private $tour = 0;
        private $inventoryData;

        public function index() {
            if (!isset($_SESSION['curP'])) {
                $this->init();
            } else {
                $this->updateMana($_SESSION['hmana']);
                if (isset($_SESSION['hpv'])) {
                    $this->updatePV($_SESSION['hpv'], $_SESSION['mpv']);
                }
            }
        
            if ($_SESSION['curP'] == 0) {
                if (isset($_POST['action'])) {
                    if ($_POST['action'] == "hit") {
                        $this->heroPlay();
                    } elseif ($_POST['action'] == "drink") {
                        $this->usePotion(15);
                    } elseif ($_POST['action'] == "fuir") {
                        $reussite = rand(1, 6);
                        if ($reussite >= 3) {
                            $this->escape();
                        }
                    }
                }
                if (isset($_POST['sort'])) {
                    $sort = $_POST['sort'];
                    $values = explode("-", $sort);
                    $heal = intval($values[0]);
                    $damage = intval($values[1]);
        
                    if ($heal != 0 && ($this->getHeroMana() - $heal) > 0) {
                        $this->usePotion($heal);
                        $this->getCombat()->getHero()->reduceMana($heal);
                    }
                    if ($damage != 0 && ($this->getHeroMana() - $damage) > 0) {
                        $dgt = (rand(1, 6) + rand(1, 6)) + $damage;
                        $this->getCombat()->heroLanceSort($dgt);
                        $this->getCombat()->getHero()->reduceMana($damage);
                    }
                }
            } else {
                $this->monsterPlay();
                $_SESSION['curP'] = 0;
            }
            $_SESSION['hmana'] = $this->getHeroMana();
            $_SESSION['hpv'] = $this->getHeroPV();
            $_SESSION['mpv'] = $this->getMonsterPV();
            if ($this->isEnded()) {
                unset($_SESSION['curP'], $_SESSION['hmana'], $_SESSION['hpv'], $_SESSION['mpv'], $_POST['action']);
                $this->isHeroWinner();
                exit();
            }
        
            // inventory data
            if (!isset($this->inventoryData)) {
                $inventoryController = new InventoryController();
                $this->inventoryData = $inventoryController->getInventoryData();
            }
            $inventory = $this->inventoryData;
            require_once 'views/combat_view.php';
        }
        

        public function __construct()
        {
            require("./core/Database.php");
            $tab = [];
            LireDonneesPDO2($db, "select * from Monster where mons_id = (select mons_id from Encounter where chap_id = ".$_SESSION['chapter'].")", $tab);
            $monster = new Monster($tab[0]['mons_name'], $tab[0]['mons_pv'], $tab[0]['mons_strength'], $tab[0]['mons_initiative'], 0);

            $heroClass = [];
            LireDonneesPDO2($db, "select hero_class from Hero where hero_id = ".$_SESSION['hero'], $heroClass);
            if($heroClass[0]['hero_class'] == 3){
                $hero = new Magicien($_SESSION['hero']);
            }else{
                $hero = new Hero($_SESSION['hero']);
            }
            $this->combat = new Combat($monster, $hero);

            $inventoryController = new InventoryController();
            $this->inventoryData = $inventoryController->getInventoryData();
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
            echo ($this->combat->getHero()->getStats($this->getHeroPV(), $this->getHeroMana()) . " VS " . $this->combat->getMonster()->getStats($this->getMonsterPV()) . "<br>");
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

        public function updateMana($v1){
            $this->combat->setHeroMana($v1);
        }

        public function getHeroPV(){
            return $this->combat->getHero()->getPV();
        }

        public function getHeroMana(){
            return $this->combat->getHero()->getMana();
        }

        public function getMonsterPV(){
            return $this->combat->getMonster()->getPV();
        }

        public function getCombat(){
            return $this->combat;
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
                $this->getCombat()->getHero()->getReward($_SESSION['chapter']);
                $_SESSION['chapter'] = $next;
            }
            else{
                $_SESSION['chapter'] = $death;
            }
            require_once 'views/chapter_view.php';
            exit();
        }

        public function escape(){
            require("./core/Database.php");
            unset($_SESSION['curP']);
            unset($_SESSION['hpv']);
            unset($_SESSION['mpv']);
            unset($_POST['action']);
            unset($_POST['submit']);
            $choices = [];
            LireDonneesPDO2($db, "select * from Links where chapter_id = ".$_SESSION['chapter'], $choices);
            foreach ($choices as $path):
                if(strpos(strval($path['description']), 'mort') !== false){
                    $next = $path['next_chapter_id'];
                }
            endforeach;
            $_SESSION['chapter'] = $next;
            require_once 'views/chapter_view.php';
            exit();
        }

        public function usePotion($value){
            $this->combat->heal($value);
        }
}
?>