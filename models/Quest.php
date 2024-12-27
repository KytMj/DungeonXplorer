<?php
include_once "./core/pdo_agile.php";

class Quest{
    private $hero_id;
    private $user_id;
    private $chap_id;
    private $ques_currentPV;
    private $ques_currentMana;

    public function __construct($hero_id, $user_id, $chap_id, $ques_currentPV, $ques_currentMana)
    {
        $this->hero_id = $hero_id;
        $this->user_id = $user_id;
        $this->chap_id = $chap_id;
        $this->ques_currentPV = $ques_currentPV;
        $this->ques_currentMana = $ques_currentMana;
    }

    public function getHeroId()
    {
        return $this->hero_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getChapId()
    {
        return $this->chap_id;
    }

    public function getQuestPv()
    {
        return $this->ques_currentPV;
    }

    public function getQuestMana()
    {
        return $this->ques_currentMana;
    }

    public function update($chapter, $ques_currentPV, $ques_currentMana){
        require("./core/Database.php");
        $sql = "UPDATE Quest SET chap_id = ".$chapter.", ques_currentPV = ".$ques_currentPV.", ques_currentMana = ".$ques_currentMana." 
                where user_id = ".$this->user_id." and hero_id = ".$this->hero_id;
        majDonneesPDO($db,$sql);
    }
}

?>