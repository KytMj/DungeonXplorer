<?php
include_once "./core/pdo_agile.php";

class User{
    private $id;
    private $mail;
    private $passwd;

    public function __construct($id, $mail, $passwd)
    {
        $hache = password_hash($passwd, PASSWORD_DEFAULT);
        $this->id = $id;
        $this->mail = $mail;
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

    public function insert(){
        require("./core/Database.php");
        $sql = "INSERT INTO User(user_id, user_mail, user_passwd) VALUES ('".$this->id."','".$this->mail."', '".$this->passwd."')";
        majDonneesPDO($db,$sql);
    }
}
?>