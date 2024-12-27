<?php

// models/Chapter.php

class Chapter
{
    private $id;
    private $title;
    private $description;
    private $image; 
    private $isCombat;
    private $choices;

    public function __construct($id, $title, $description, $image, $isCombat, $choices)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->image = $image; 
        $this->isCombat = $isCombat;
        $this->choices = $choices;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getImage()
    {
        return $this->image; 
    }

    public function getIsCombat()
    {
        return $this->isCombat; 
    }

    public function getChoices()
    {
        return $this->choices;
    }
}
