<?php 
$login = false;
$heroSession = false;
$adminSession = false;
$chapitreSession = false;
$combatSession = false;
if(isset($_SESSION['login'])){
    $login = true;
    if(isset($_SESSION['hero'])){
        $heroSession = true;
    }else{
        $heroSession = false;
    }

    if(isset($_SESSION['admin'])){
        $adminSession = true;
    }else{
        $adminSession = false;
    }

    if(isset($_SESSION['chapter'])){
        $chapitreSession = true;
    }else{
        $chapitreSession = false;
    }

    if(isset($_SESSION['curP'])){
        $combatSession = true;
    }else{
        $combatSession = false;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dungeon Xplorer</title>
        <style> 
            @import url('https://fonts.googleapis.com/css2?family=Pirata+One&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
            <?php require_once 'css/navbar.css'; ?>
            <?php require_once 'css/design.css'; ?>
        </style>
        <script src="https://kit.fontawesome.com/ed6f34f20e.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <header>
            <nav class="navBar">
                <a href="home" id="logoNav"><img src="./../../image/Logo.png" class="" alt="Logo Dungeon Xplorer" /></a>
                <div class="buttonNav">
                    <a href="adminPanel"><button type="button" class="btn" id="adminPanelButton">Accès au panel admin</button></a>
                    <a href="chapter"><button type = "button" class="btn" id="returnAdventureButton">Retour à l'aventure</button></a>
                    <a href="combat"><button type = "button" class="btn" id="returnCombatButton">Retour au combat</button></a>

                    <a href="signin"><button type="button" class="btn" id="NewAccountButton">Créer un compte</button></a>
                    <a href="connexion"><button type="button" class="btn" id="LogInButton">Connexion</button></a>
                    <a href="deconnexionAccount"><button type="button" class="btn" id="LogOutButton">Déconnexion</button></a>
                    <a href="accountHero"><button type="button" class="btn" id="accountHero">Personnage <i class="fa-solid fa-campground"></i></button></a>
                </div>
                <a href="account" id="accountNav"><img src="./../../image/Account.png" id="accountIcon" alt="Icône compte" /></a>
            </nav>
        </header>
        <script>
            var login = <?php echo json_encode($login); ?>;
            var heroSession = <?php echo json_encode($heroSession); ?>;
            var adminSession = <?php echo json_encode($adminSession); ?>;
            var chapitreSession = <?php echo json_encode($chapitreSession); ?>;
            var combatSession = <?php echo json_encode($combatSession); ?>;

            var path = <?php echo json_encode($_SERVER["REQUEST_URI"]); ?>;
            var __filename = path.split(/(\\|\/)/g).pop()

            let account = document.getElementById('accountIcon');
            let deconnexion = document.getElementById('LogOutButton');
            let connexion = document.getElementById('LogInButton');
            let creationAccount = document.getElementById('NewAccountButton');
            if(login == false){
                account.classList.add('none');
                deconnexion.classList.add('none');

                connexion.classList.remove('none');
                creationAccount.classList.remove('none');
            }
            else{
                connexion.classList.add('none');
                creationAccount.classList.add('none');

                account.classList.remove('none');
                deconnexion.classList.remove('none');
            }

            let heroAccount = document.getElementById('accountHero');
            if(heroSession == false){
                heroAccount.classList.add('none');
            }
            else{
                heroAccount.classList.remove('none');
            }

            let adminPanel = document.getElementById('adminPanelButton');
            if(adminSession == false){
                adminPanel.classList.add('none');
            }
            else{
                adminPanel.classList.remove('none');
            }

            let returnAdventure = document.getElementById('returnAdventureButton');
            console.log(__filename);
            if(chapitreSession == false || login == false || __filename == "chapter" || combatSession == true || __filename == "combat" || __filename == "userherocreation"){
                returnAdventure.classList.add('none');
            }else{
                returnAdventure.classList.remove('none');
            }

            let returnCombatButton = document.getElementById('returnCombatButton');
            if(combatSession == false || login == false || __filename == "combat"){
                returnCombatButton.classList.add('none');
            }else{
                returnCombatButton.classList.remove('none');
            }

        </script>
    </body>
</html>