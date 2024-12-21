<?php
require_once "./models/User.php";
include_once "./core/pdo_agile.php";

class AccountController {
    public function index() {
        if(!isset($_SESSION['login'])){
            require 'views/home_view.php';
            exit();
        }
        require_once 'views/account_view.php';
    }

    public function modifMail(){}

    public function modifMDP(){}
}