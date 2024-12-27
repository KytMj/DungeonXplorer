<?php 
require_once 'header.php';
?>
        <main>
            <h1>Personnage</h1>
            <?php echo($hero->show()); ?>

            <section>
                <h2>Inventaire</h2>
                <?php
                require_once './controllers/InventoryController.php';
                $inventoryController = new InventoryController();
                $inventoryController->show();
                ?>
            </section>
        </main>
    </body>
</html>
