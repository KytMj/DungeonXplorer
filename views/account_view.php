<?php 
require_once 'header.php';
?>
        <main>
            <h1>Page de compte</h1>
            <div>
                <p> Votre adresse email : <?php if(isset($_SESSION['login'])){ $mail = $_SESSION['login']; echo $mail;} ?> </p>
            </div>
        </main>
    </body>
</html>