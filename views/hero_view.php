<?php 
require_once 'header.php';
include_once "./controllers/HeroController.php";
$hero = new HeroController($_SESSION['hero']);
?>
        <main>
            <h1>Personnage</h1>
            <?php echo($hero->show()); ?>
        </main>
    </body>
</html>
