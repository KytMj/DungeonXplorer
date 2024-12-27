<?php
include_once "./core/pdo_agile.php";

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

    public function insert(){
        require("./core/Database.php");
        $hache = password_hash($this->passwd, PASSWORD_DEFAULT);
        $this->passwd = $hache;
        $sql = "INSERT INTO User(user_id, user_mail, user_passwd) VALUES ('".$this->id."','".$this->mail."', '".$this->passwd."')";
        majDonneesPDO($db,$sql);
    }

    public function delete(){
        require("./core/Database.php");
        $sql = "DELETE FROM User WHERE user_id = ".$this->id." and user_isAdmin = 0";
        majDonneesPDO($db,$sql);
    }

    public function updateMDP(){
        require("./core/Database.php");
        $hache = password_hash($this->passwd, PASSWORD_DEFAULT);
        $this->passwd = $hache;
        $sql = "UPDATE User SET user_passwd = '".$this->passwd."' WHERE user_id = ".$this->id;
        majDonneesPDO($db,$sql);
    }

    public function updateMail(){
        require("./core/Database.php");
        $sql = "UPDATE User SET user_mail = '". $this->mail ."' WHERE user_id = ".$this->id;
        majDonneesPDO($db,$sql);
    }
}
?>