<?php require_once 'views/header.php'; ?>
        <h1>Combat: <br></h1>
        <?php
            $combatC->show();
        ?>
        <form method="POST" action="combat">
            <button type="submit" name="action" value="hit">Attaquer</button>
            <button type="submit" name="action" value="drink">Boire une potion</button>
            <button type="submit" name="action" value="fuir">Fuir</button>
            <?php if($combatC->getCombat()->getHero()->isMage() == 1){
                echo("<button id=\"castSpell\" type=\"submit\" name=\"sort\" value=\"\" disabled>Utiliser un sort</button>");
            } ?>
        </form>
        <?php if($combatC->getCombat()->getHero()->isMage() == 1){
            echo("<select id=\"listSpell\" name=\"spellList\" size=\"5\">");
                echo("<option class=\"space\" value=\"\"> <p>-------------------</p> </option>");
                foreach ($combatC->getCombat()->getHero()->getSpells() as $spell):
                    echo("<option class=\"space\" value=\"".$spell['effets']."\"> <p>".$spell['libelle']."</p> </option>");
                endforeach;
            echo("</select>");
        }?>
        <script>
            const button = document.getElementById('castSpell');
            const select = document.getElementById('listSpell');
            select.addEventListener('change', function() {
            button.disabled = !this.selectedIndex;
            });
            button.onclick = function(){
                button.value = select.options[select.selectedIndex].value;
            }
        </script>
    </body>
</html>