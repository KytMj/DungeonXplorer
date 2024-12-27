<?php
require_once "./models/Admin.php";
include_once "./core/pdo_agile.php";
class EditChapterController {

    public function index() {
        if(!isset($_SESSION['admin'])){ 
            require 'views/home_view.php';
            exit();
        }
        $admin = new Admin();
        require_once 'views/edit_chapter_view.php';
    }
    
    public function creation(){
        require("./core/Database.php");
        if(isset($_SESSION['admin'])){
            $data = $_POST;
            if(isset($data['submit'])){
                if(  (isset($data['title']) && !empty($data['title'])) 
                && (isset($data['content']) && !empty($data['content'])) 
                && (isset($data['image']) && !empty($data['image'])) 
                && (isset($data['xp']) && !empty($data['xp']))
                && (isset($data['isCombat'])) ){
                    $tab = [];
                    LireDonneesPDO2($db, "select count(*) as nb from Chapter where chap_title = '".$data['title']."'", $tab);
                    if($tab[0]['nb'] == 0){
            
                        $data['title'] = htmlspecialchars($data['title']);
                        $data['content'] = htmlspecialchars($data['content']);
                        $data['image'] = htmlspecialchars($data['image']);
                        $data['xp'] = htmlspecialchars($data['xp']);
                        $data['isCombat'] = htmlspecialchars($data['isCombat']);
                        
                        $sql = "INSERT into Chapter (chap_title, chap_content,chap_image,chap_XpGained,chap_isCombat) values 
                            ('".$data['title']." ' , ' ".$data['content']." ' , ' ".$data['image']." ' , ".$data['xp']." , ".$data['isCombat']." )";
                        majDonneesPDO($db,$sql);

                        $this->index();
                        exit();
                    }else{
                        $erreur = "Le Chapitre existe déjà";
                        $_SESSION['erreur'] = $erreur;
                        require_once 'views/404.php';
                        exit();
                    }
                }
            }
        }else{
            $erreur = "Vous n'avez pas le droit d'accéder à cette page";
            $_SESSION['erreur'] = $erreur;
            require_once 'views/404.php';
            exit();
        }
    }

    public function deletion(){
        require("./core/Database.php");
        if(isset($_SESSION['admin'])){
            $tab = [];
            LireDonneesPDO2($db, "select count(*) as nb from Chapter where chap_id = ".$_POST['deleteChapter'], $tab); 

            if($tab[0]['nb'] != 0){
                $sql = "DELETE FROM Chapter WHERE chap_id = ".$_POST['deleteChapter'];
                majDonneesPDO($db,$sql);
            }else{
                $erreur = "Le Chapitre n'existe pas.";
                $_SESSION['erreur'] = $erreur;
                require_once 'views/404.php';
                exit();
            }
            $this->index();
            exit();
        }else{
            $erreur = "Vous n'avez pas le droit d'accéder à cette page";
            $_SESSION['erreur'] = $erreur;
            require_once 'views/404.php';
            exit();
        }
    }


    public function update(){
        
    }

    public function getChapterData($id) {
        $admin =new Admin();
        if($id > 0){
            $admin->getChapterData($id); 
        } else { 
            echo json_encode(["error" => "ID de monstre non spécifié ou requête incorrecte"]); 
        }
    }


}