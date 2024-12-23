<?php
class AdminController {
    public function index() {
        if(!isset($_SESSION['admin'])){
            require 'views/home_view.php';
            exit();
        }
        require_once 'views/admin_view.php';
    }
}