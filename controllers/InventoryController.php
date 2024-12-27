<?php


require_once('./models/Inventory.php');

class InventoryController {
    private $inventoryData;

    public function index(){
        require_once 'views/inventory.php';
    }

    public function __construct() {
        require("./core/Database.php");
        $hero_id = $this->getHeroId($db);
        if ($hero_id !== null) {
            $inventoryModel = new Inventory($db, $hero_id);
            $this->inventoryData = $inventoryModel->getInventory();
        } else {
            $this->inventoryData = [];
        }
    }

    private function getHeroId($db) {
        $data = [];
        LireDonneesPDO2($db, "
            select hero_id 
            from Quest 
            where user_id = (select user_id from User where user_mail = '".$_SESSION['login']."')",
            $data
        );
        return $data[0]['hero_id'] ?? null;
    }

    public function show(){
        $inventory = $this->inventoryData;
        require('./views/inventory_view.php');
    }

    public function getInventoryData() {
        return $this->inventoryData;
    }

    public function addItem($itemId, $quantity) {
        require("./core/Database.php");
        $inventoryModel = new Inventory($db, $this->getHeroId($db));
        $inventoryModel->add($itemId, $quantity);
    }

    public function removeItem($itemId, $quantity) {
        require("./core/Database.php");
        $inventoryModel = new Inventory($db, $this->getHeroId($db));
        $inventoryModel->remove($itemId, $quantity);
    }
} 
?>
