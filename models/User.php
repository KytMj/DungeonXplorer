<?php

class User{
    private $id;
    private $mail;
    private $passwd;

    public function __construct($id, $mail, $passwd)
    {
        $this->id = $id;
        $this->mail = $mail;
        $this->passwd = $passwd;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function getPasswd()
    {
        return $this->passwd;
    }

    public function insert($mail, $passwd){
        
    }
}

?>