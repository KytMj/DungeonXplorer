<?php 
require_once 'header.php';
?>
        <main>
            <h1>Page de compte</h1>
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
        </main>
    </body>
</html>