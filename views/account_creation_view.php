<?php require_once 'header.php'?>
        <main>
            <div>
                <h2>Créez votre compte</h2>
            </div>
            <div class="description">
                <form id="monFormulaire" name="monFormulaire" action="addAccount" method="post" enctype="application/x-www-form-urlencoded">
                        <div>
                            <input type="text" id="mail" name="mail" size="20" value="" placeholder="Adresse mail" 
                            pattern="^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$"
                            required>
                            <label for="mail">e.g : (john.doe@gmail.com)</label>
                        </div>

                        <div>
                            <input type="password" id="mdp" name="mdp" size="20"
                            placeholder="Mot de passe" AUTOCOMPLETE=OFF
                            pattern="^(?:(?:(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]))|(?:(?=.*[a-z])(?=.*[A-Z])(?=.*[*.!@$%^&(){}[]:;<>,.?/~_+-=|\]))|(?:(?=.*[0-9])(?=.*[A-Z])(?=.*[*.!@$%^&(){}[]:;<>,.?/~_+-=|\]))|(?:(?=.*[0-9])(?=.*[a-z])(?=.*[*.!@$%^&(){}[]:;<>,.?/~_+-=|\]))).{8,32}$"
                            required>
                            <label for="mdp">Majuscules, minuscules, chiffres, caractères spéciaux, entre 8 et 32 caractères</label>
                        </div>

                        <div>
                            <input type="password" id="conf_mdp" name="conf_mdp" size="20"
                            placeholder="Confirmer le mot de passe" AUTOCOMPLETE=OFF
                            pattern="^(?:(?:(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]))|(?:(?=.*[a-z])(?=.*[A-Z])(?=.*[*.!@$%^&(){}[]:;<>,.?/~_+-=|\]))|(?:(?=.*[0-9])(?=.*[A-Z])(?=.*[*.!@$%^&(){}[]:;<>,.?/~_+-=|\]))|(?:(?=.*[0-9])(?=.*[a-z])(?=.*[*.!@$%^&(){}[]:;<>,.?/~_+-=|\]))).{8,32}$"
                            required>
                            <label for="conf_mdp">Majuscules, minuscules, chiffres, caractères spéciaux, entre 8 et 32 caractères</label>
                        </div>
                        </br>
                        <div class="center">
                            <button type="submit" name="submit" value="Submit"> Valider </button>
                        </div>
                        
                        <a href="connexion">Vous avez déjà un compte ?</a>
                </form>
            </div>
        </main>
    </body>
</html>