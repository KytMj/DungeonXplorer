<?php require_once 'views/header.php'; ?>
<h1>Combat: <br></h1>

<?php
    $this->show();
?>

<form method="POST" action="combat">
    <button type="submit" name="action" value="hit">Attaquer</button>
    <button type="submit" name="action" value="drink">Boire une potion</button>
    <button type="submit" name="action" value="fuir">Fuir</button>
    
    <?php if ($this->getCombat()->getHero()->isMage() == 1): ?>
        <button id="castSpell" type="submit" name="sort" value="" disabled>Utiliser un sort</button>
    <?php endif; ?>
</form>

<?php if ($this->getCombat()->getHero()->isMage() == 1): ?>
    <select id="listSpell" name="spellList" size="5">
        <option class="space" value=""> <p>-------------------</p> </option>
        <?php foreach ($this->getCombat()->getHero()->getSpells() as $spell): ?>
            <option class="space" value="<?= htmlspecialchars($spell['effets']); ?>"> <p><?= htmlspecialchars($spell['libelle']); ?></p> </option>
        <?php endforeach; ?>
    </select>
<?php endif; ?>

<h2>Inventaire</h2>
<?php require_once 'views/inventory_view.php'; ?>

<script>
    const button = document.getElementById('castSpell');
    const select = document.getElementById('listSpell');
    select.addEventListener('change', function() {
        button.disabled = !this.selectedIndex;
    });
    button.onclick = function() {
        button.value = select.options[select.selectedIndex].value;
    }
</script>

</body>
</html>
