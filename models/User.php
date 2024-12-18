<?php

class User{
    private $id;
    private $mail;
    private $passwd;

    public function __construct($id, $mail, $passwd)
    {
        $this->id = $id;
        $this->mail = $mail;
        $hache = password_hash($passwd, PASSWORD_DEFAULT);
        $this->passwd = $hache;
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

    public function insert($bdd){
        $sql = "INSERT INTO user (user_mail, user_passwd) VALUES ('".$this->mail."', '".$this->passwd."')";
        majDonneesPDO($bdd,$sql);
    }
}

?>