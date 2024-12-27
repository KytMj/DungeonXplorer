<?php require_once 'header.php'?>
    <main>
        <h1>Souhaitez-vous vraiment supprimer votre héro ?</h1>
        <h2> Votre progression sera perdue.</h2>
        
        <form id ="HeroDeletionForm" name="HeroDeletionForm" method="post" action="herodeletion" >
            <input type="submit" value="Supprimer"> 
            <button type="button" onclick="window.location.href='adventure'">Annuler</button> 
        </form>

    </main>
</body>
</html>