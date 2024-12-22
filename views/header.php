<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dungeon Xplorer</title>
        <style> <?php require_once 'css/navbar.css'; ?> </style>
    </head>
    <body>
        <header>
            <nav class="navBar">
                <a href="home" id="logoNav"><img src="./../../images/Logo.png" class="" alt="Logo Dungeon Xplorer" /></a>
                <div class="buttonNav">
                    <a href="adminPanel"><button type="button" class="btn" id="adminPanelButton">Accès au panel admin</button></a>
                    <a href="signin"><button type="button" class="btn" id="NewAccountButton">Créer un compte</button></a>
                    <a href="connexion"><button type="button" class="btn" id="LogInButton">Connexion</button></a>
                    <a href="deconnexionAccount"><button type="button" class="btn" id="LogOutButton">Déconnexion</button></a>
                    <a href="accountHero"><button type="button" class="btn" id="accountHero">Personnage</button></a>
                </div>
                <a href="account" id="accountNav"><img src="./../../images/Account.png" alt="Icône compte" /></a>
            </nav>
        </header>
    </body>
</html>