<?php 
require_once 'header.php';
?>
        <main>
            <h1>Page de compte</h1>
            <div>
                <p> Votre adresse email : <?php if(isset($_SESSION['login'])){ $mail = $_SESSION['login']; echo $mail;} ?> </p>
                <form id="formChapter" name="formChapter" action="chapter" method="post">
                    <button type="submit" name="submit" value="<?php echo $choice['chapter'] ?>">Modifier le mot de passe</button>
                </form>
            </div>
        </main>
    </body>
</html>