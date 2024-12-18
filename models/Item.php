<?php

class Item{
    private $name;
    private $description;
    private $damages;


    public function __construct($name, $description, $damages){
        $this->name = $name;
        $this->description = $description;
        $this->damages = $damages;
    }

    public function getName(){
        return $this->name;
    }
    public function getDescription(){
        return $this->description;
    }
    public function getDamages(){
        return $this->damages;
    }

}

?>