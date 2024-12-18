<?php
require_once "./models/User.php";
include_once "./core/pdo_agile.php";

class ConnectionController {
    public function index() {
        require_once 'views/connection_view.php';
    }

    public function connexion(){
        require("./core/Database.php");
        $data = $_POST;
        if(isset($data['submit'])){
            if((isset($data['mail']) && !empty($data['mail'])) 
            && (isset($data['mdp']) && !empty($data['mdp']))){
                $tab = [];
                LireDonneesPDO2($db, "select count(*) as nb from User where user_mail = '".$data['mail']."'", $tab);

                if(!isset($_SESSION['login'])){
                    if($tab[0]['nb'] == 1){
                        $data['mail'] = htmlspecialchars($data['mail']);
                        $data['mdp'] = htmlspecialchars($data['mdp']);

                        $passwd = [];
                        LireDonneesPDO2($db, "select user_passwd from User where user_mail = '".$data['mail']."'", $passwd);

                        if(password_verify($data['mdp'], $passwd[0]['user_passwd'])){
                            $id = [];
                            LireDonneesPDO2($db, "select user_id from User where user_mail = '".$data['mail']."'", $id);

                            $user = new User($id[0]['user_id'], $data['mail'], $data['mdp']);
                            $_SESSION['login'] = strval($user->getMail());
                            require_once 'views/aventure_view.php';
                        }
                        else{
                            $erreur = "Ce n'est pas le bon mot de passe.";
                            $_SESSION['erreur'] = $erreur;
                            require_once 'views/404.php';
                            exit();
                        }
                    }
                    else{
                        $erreur = "Ce compte n'existe pas.";
                        $_SESSION['erreur'] = $erreur;
                        require_once 'views/404.php';
                        exit();
                    }
                }
                else{
                    $erreur = "Un compte est déjà connecté, veuillez vous déconnecter.";
                    $_SESSION['erreur'] = $erreur;
                    require_once 'views/404.php';
                    exit();
                }
            }
        }
    }

    public function deconnexion(){
        session_unset();
        session_destroy();
        require_once 'views/home_view.php';
        exit();
    }
}