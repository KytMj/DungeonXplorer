<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dungeon Xplorer - Connexion</title>
    </head>
    
    <body>
        <header>
            <nav>
                <a href="home"><img src="./../image/Logo.png" class="img-fluid" style="width: 150px; height: 150px;" alt="Logo Dungeon Xplorer" /></a>
                <a href="signin"><button type="button" id="NewAccountButton">Créer un compte</button></a>
            </nav>
        </header>
        <main>
            <div>
                <form id="monFormulaire" name="monFormulaire" action="inscription_site.php" method="post" enctype="application/x-www-form-urlencoded">
                        <div>
                            <h2>Se connecter</h2>
                        </div>
        
                        <div>
                            <input type="text" id="mail" name="mail" size="20" value="" placeholder="Adresse mail" pattern="^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$"
                            required>
                            <label for="mail">e.g : (john.doe@gmail.com)</label>
                        </div>
        
                        <div>
                            <input type="password" id="code" name="code" size="20"
                            placeholder="Mot de passe" AUTOCOMPLETE=OFF
                            pattern="^(?:(?:(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]))|(?:(?=.*[a-z])(?=.*[A-Z])(?=.*[*.!@$%^&(){}[]:;<>,.?/~_+-=|\]))|(?:(?=.*[0-9])(?=.*[A-Z])(?=.*[*.!@$%^&(){}[]:;<>,.?/~_+-=|\]))|(?:(?=.*[0-9])(?=.*[a-z])(?=.*[*.!@$%^&(){}[]:;<>,.?/~_+-=|\]))).{8,32}$"
                            required>
                            <label for="mdp">Majuscules, minuscules, chiffres, caractères spéciaux, entre 8 et 32 caractères</label>
                        </div>
                        
                        <div>
                            <button type="submit" name="BtSub" value=""> Connexion </button>
                        </div>

                        <a href="signin">Vous n'avez pas de compte ? Créez-en un !</a>
                </form>
            </div>
        </main>
    </body>
</html>