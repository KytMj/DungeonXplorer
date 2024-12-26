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

    public function modifMail(){
        require("./core/Database.php");
        $data = $_POST;
        if(isset($data['modifMail'])){
            if(isset($data['modifCurrMail']) && !empty($data['modifCurrMail'])){
                $data['modifCurrMail'] = htmlspecialchars($data['modifCurrMail']);

                $userMails = [];
                LireDonneesPDO2($db, "select user_mail from User", $userMails);

                foreach($userMails as $mail):
                    if($mail['user_mail'] == $data['modifCurrMail']){
                        echo 'cette adresse email existe déjà';
                        exit();
                    }
                endforeach;

                $userInfos = [];
                LireDonneesPDO2($db, "select * from User where user_mail = '".$_SESSION['login']."'", $userInfos);

                $modifUser = new User($userInfos[0]['user_id'], $data['modifCurrMail'], $userInfos[0]['user_passwd']);
                $modifUser->updateMail();

                $_SESSION['login'] = $data['modifCurrMail'];

                require 'views/home_view.php';
                exit();
            }
        }
    }

    public function modifMDP(){
        require("./core/Database.php");
        $data = $_POST;
        if(isset($data['modifMDP'])){
            if((isset($data['mdpCurrAccount']) && !empty($data['mdpCurrAccount'])) 
            && (isset($data['mdpModifAccount']) && !empty($data['mdpModifAccount'])) 
            && (isset($data['mdpConfAccount']) && !empty($data['mdpConfAccount']))){
                if($data['mdpConfAccount'] != $data['mdpModifAccount']){
                    $erreur = 'Les deux mots de passe sont différents.';
                    $_SESSION['erreur'] = $erreur;
                    require_once 'views/404.php';
                    exit();
                }
                $data['mdpCurrAccount'] = htmlspecialchars($data['mdpCurrAccount']);
                $data['mdpModifAccount'] = htmlspecialchars($data['mdpModifAccount']);
                $data['mdpConfAccount'] = htmlspecialchars($data['mdpConfAccount']);

                $userInfos = [];
                LireDonneesPDO2($db, "select user_passwd, user_id from User where user_mail = '".$_SESSION['login']."'", $userInfos);

                if(password_verify($data['mdpCurrAccount'], $userInfos[0]['user_passwd'])){
                    $modifUser = new User($userInfos[0]['user_id'], $_SESSION['login'], $data['mdpModifAccount']);
                    $modifUser->updateMDP();
                    require 'views/home_view.php';
                    exit();
                }
                else{
                    echo("Ce n'est pas le bon mot de passe");
                    exit();
                }
            }
        }
    }

    public function supprimerCompte(){
        require("./core/Database.php");
        $user = [];
        LireDonneesPDO2($db, "select * from User where user_mail = '".$_SESSION['login']."'", $user); 
        $user = new User($user[0]['user_id'], $user[0]['user_mail'], $user[0]['user_passwd']);

        if(isset($_SESSION['hero'])){
            $heroes = [];
            LireDonneesPDO2($db, "select hero_id from Quest where user_id = ".$user->getId(), $heroes); 

            $sql = "DELETE FROM Hero WHERE hero_id = ".$heroes[0]['hero_id'];
            majDonneesPDO($db,$sql);
            unset($_SESSION['hero']);
        }
        $user->delete();

        $deco = new ConnectionController();
        $deco->deconnexion();
        exit();
    }
}