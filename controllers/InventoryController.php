<?php

class InventoryController {
    private $inventory;

    public function index(){
        require_once 'views/inventory.php';
    }

    public function __construct($inventory) {
        $this->inventory = $inventory;
    }

    public function displayInventory() {
        $items = $this->inventory->getInventory();
        $this->index();
    }

    public function addItem($itemId, $quantity) {
        $this->inventory->add($itemId, $quantity);
    }

    public function removeItem($itemId, $quantity) {
        $this->inventory->remove($itemId, $quantity);
    }
}
?>
