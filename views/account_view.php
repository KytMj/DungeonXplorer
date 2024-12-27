<?php 
require_once 'header.php';
?>
        <main>
            <h1>Page de compte</h1>
            <div class="description" id="infosAccount">
                <div>
                    <p> Votre adresse email : <?php if(isset($_SESSION['login'])){ $mail = $_SESSION['login']; echo $mail;} ?> </p>
                    <button id="buttonModifMail" type="button" name="modifMail" value="">Modifier l'adresse mail</button>
                </div>

                <div>
                    <p> Votre mot de passe : <?php if(isset($_SESSION['login'])){ echo "•••••";} ?> </p>
                    <button id="buttonModifMDP" type="button" name="modifMDP" value="">Modifier le mot de passe</button>
                </div>
                <?php if(!isset($_SESSION['admin'])){
                echo("
                <a href=\"account\" id=\"suppAccount\">
                    <button id=\"btnSuppAccount\" type=\"submit\" name=\"submit\" value=\"\">SUPPRIMER VOTRE COMPTE</button>
                </a>");}?>
            </div>

            <div class="none description" id="modifMDP">
                <div>
                    <form id="formMDP" name="formMDP" action="modifMDPAccount" method="post">
                        <input type="password" id="inputCurrentMdp" name="mdpCurrAccount" size="20" placeholder="Ancien mot de passe" AUTOCOMPLETE=OFF pattern="^(?:(?:(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]))|(?:(?=.*[a-z])(?=.*[A-Z])(?=.*[*.!@$%^&(){}[]:;<>,.?/~_+-=|\]))|(?:(?=.*[0-9])(?=.*[A-Z])(?=.*[*.!@$%^&(){}[]:;<>,.?/~_+-=|\]))|(?:(?=.*[0-9])(?=.*[a-z])(?=.*[*.!@$%^&(){}[]:;<>,.?/~_+-=|\]))).{8,32}$"
                            required>
                        <label for="mdpAccount">Majuscules, minuscules, chiffres, caractères spéciaux, entre 8 et 32 caractères</label>
                        <input type="password" id="inputModifMdp" name="mdpModifAccount" size="20" placeholder="Nouveau mot de passe" AUTOCOMPLETE=OFF pattern="^(?:(?:(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]))|(?:(?=.*[a-z])(?=.*[A-Z])(?=.*[*.!@$%^&(){}[]:;<>,.?/~_+-=|\]))|(?:(?=.*[0-9])(?=.*[A-Z])(?=.*[*.!@$%^&(){}[]:;<>,.?/~_+-=|\]))|(?:(?=.*[0-9])(?=.*[a-z])(?=.*[*.!@$%^&(){}[]:;<>,.?/~_+-=|\]))).{8,32}$"
                            required>
                        <input type="password" id="inputConfModif" name="mdpConfAccount" size="20" placeholder="Confirmation du mot de passe" AUTOCOMPLETE=OFF pattern="^(?:(?:(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]))|(?:(?=.*[a-z])(?=.*[A-Z])(?=.*[*.!@$%^&(){}[]:;<>,.?/~_+-=|\]))|(?:(?=.*[0-9])(?=.*[A-Z])(?=.*[*.!@$%^&(){}[]:;<>,.?/~_+-=|\]))|(?:(?=.*[0-9])(?=.*[a-z])(?=.*[*.!@$%^&(){}[]:;<>,.?/~_+-=|\]))).{8,32}$"
                            required>

                        <button id="confModifMDP" type="submit" name="modifMDP" value="">Confirmer</button>
                    </form>
                </div>
            </div>

            <div class="none description" id="modifMail">
                <div>
                    <form id="formMail" name="formMail" action="modifMailAccount" method="post">
                        <input type="text" id="modifCurrMail" name="modifCurrMail" size="20" value="" placeholder="Nouvelle adresse mail" pattern="^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$"
                            required>
                        <label for="modifCurrMail">e.g : (john.doe@gmail.com)</label>

                        <button id="confModifMail" type="submit" name="modifMail" value="">Confirmer</button>
                    </form>
                </div>
            </div>
        </main>

        <script>
            document.getElementById('btnSuppAccount').onclick = () => { 
                var popup = confirm("Voulez-vous vraiment supprimer votre compte ?");
                if(popup){
                    document.getElementById("suppAccount").href = "supprAccountUser";
                }
                else{
                    document.getElementById("suppAccount").href = "account";
                }
            }

            document.getElementById('buttonModifMail').onclick = function() { 
                document.getElementById('infosAccount').classList.add('none');
                document.getElementById('modifMail').classList.remove('none');
            }

            document.getElementById('buttonModifMDP').onclick = function() { 
                document.getElementById('infosAccount').classList.add('none');
                document.getElementById('modifMDP').classList.remove('none');
            }

            document.getElementById('confModifMail').onclick = function() { 
                document.getElementById('infosAccount').classList.remove('none');
                document.getElementById('modifMail').classList.add('none');
            }

            document.getElementById('confModifMDP').onclick = function() { 
                document.getElementById('infosAccount').classList.remove('none');
                document.getElementById('modifMDP').classList.add('none');
            }
        </script>
    </body>
</html>