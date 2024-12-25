<?php 
require_once 'header.php';
?>
        <main>
            <h1>Page de compte</h1>
            <div class="description">
                <div>
                    <p> Votre adresse email : <?php if(isset($_SESSION['login'])){ $mail = $_SESSION['login']; echo $mail;} ?> </p>
                    <form id="formMail" name="formMail" action="modifMailAccount" method="post">
                        <button type="submit" name="submit" value="">Modifier le mot de passe</button>
                    </form>
                </div>

                <div>
                    <p> Votre mot de passe : <?php if(isset($_SESSION['login'])){ echo "•••••";} ?> </p>
                    <form id="formMDP" name="formMDP" action="modifMDPAccount" method="post">
                        <button type="submit" name="submit" value="">Modifier le mot de passe</button>
                    </form>
                </div>
                <?php if(!isset($_SESSION['admin'])){
                echo("
                <a href=\"account\" id=\"suppAccount\">
                    <button id=\"btnSuppAccount\" type=\"submit\" name=\"submit\" value=\"\">SUPPRIMER VOTRE COMPTE</button>
                </a>");}?>
            </div>
        </main>
        <script>
            let buttonSupp = document.getElementById('btnSuppAccount');
            buttonSupp.onclick = () => { 
                var popup = confirm("Voulez-vous vraiment supprimer votre compte ?");
                if(popup){
                    document.getElementById("suppAccount").href = "supprAccountUser";
                }
                else{
                    document.getElementById("suppAccount").href = "account";
                }
            }
        </script>
    </body>
</html>