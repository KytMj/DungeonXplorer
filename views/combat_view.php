<?php require_once 'views/header.php';?>
    <h1>Combat: <br></h1>
    <?php
        $combatC->show();
    ?>
    <form method="POST" action="combat">
        <button type="submit" name="action" value="hit">Hit</button>
        <button type="submit" name="action" value="drink">Drink</button>
    </form>
</body>
</html>