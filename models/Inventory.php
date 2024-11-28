<?php

class Inventory{
    private $content;

    public function __construct()
    {
        $this->content = [];
    }

    public function add($item){
        array_push($this->content, $item);
    }
    public function remove($item){
        $this->content.array_diff($item, [$item]);
    }
    public function getInventory(){
        return $this->content;
    }
}

?>