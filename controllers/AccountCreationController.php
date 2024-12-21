<?php
require_once "./models/User.php";
include_once "./core/pdo_agile.php";

class AccountCreationController {

    public function index() {
        require_once 'views/account_creation_view.php';
    }

    public function inscription(){    
        require("./core/Database.php");
        $data = $_POST;
        if(isset($data['submit'])){
            if((isset($data['mail']) && !empty($data['mail'])) 
            && (isset($data['mdp']) && !empty($data['mdp'])) 
            && (isset($data['conf_mdp']) && !empty($data['conf_mdp']))){
                if($data['conf_mdp'] != $data['mdp']){
                    $erreur = 'Les deux mots de passe sont différents.';
                    $_SESSION['erreur'] = $erreur;
                    require_once 'views/404.php';
                    exit();
                }

                $tab = [];
                LireDonneesPDO2($db, "select count(*) as nb from User where user_mail = '".$data['mail']."'", $tab);

                if($tab[0]['nb'] == 0){
                    $data['mail'] = htmlspecialchars($data['mail']);
                    $data['mdp'] = htmlspecialchars($data['mdp']);
                    $data['conf_mdp'] = htmlspecialchars($data['conf_mdp']);

                    $id = [];
                    LireDonneesPDO2($db, "select MAX(user_id) as max from User", $id);

                    $newUser = new User($id[0]['max']+1, $data['mail'], $data['mdp']);
                    $newUser->insert();
                    if(isset($_SESSION['login'])){
                        $deconnexion = new ConnectionController();
                        $deconnexion->deconnexion();
                    }
                    $_SESSION['login'] = strval($newUser->getMail());
                    $_SESSION['chapter'] = 1;
                    require_once 'views/aventure_view.php';
                    exit();
                }
                else{
                    $erreur = 'Un compte existe déjà.';
                    $_SESSION['erreur'] = $erreur;
                    require_once 'views/404.php';
                    exit();
                }
            }
        }
    }
}