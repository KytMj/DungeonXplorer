<?php
require_once "./models/User.php";
include_once "./core/pdo_agile.php";

class AccountCreationController {
    private $users = [];

    public function index() {
        require_once 'views/account_creation_view.php';
    }
    
    public function __construct()
    {    
        require("./core/Database.php");
        // Exemple de chapitres avec des images
        $tab = [];
        LireDonneesPDO2($db, "select * from User", $tab);


        foreach($tab as $user){    
            $this->users[] = new User(
                $user['user_id'],
                $user['user_mail'],
                $user['user_passwd']
            );
        }
    }

    public function inscription(){    
        require("./core/Database.php");
        $data = $_POST;
        if(isset($data['submit'])){
            $data['mail'] = htmlspecialchars($data['mail']);
            $data['mdp'] = htmlspecialchars($data['mdp']);
            $data['conf_mdp'] = htmlspecialchars($data['conf_mdp']);

            /*si tout est okay, envoie données au modèle pour insérer les données dans la table*/ 
            $id = [];
            LireDonneesPDO2($db, "select MAX(user_id) as max from User", $id);

            $newUser = new User($id[0]['max']+1, $data['mail'], $data['mdp']);
            $newUser->insert();
            require_once 'views/aventure_view.php';
        }
    }
}