<?php require_once 'header.php'?>
    <main>
        <h1>Créez votre personnage</h1>
        <form id ="HeroCreationForm" name="HeroCreationForm" action="userherocreation" method="post" enctype="application/x-www-form-urlencoded">
            <label for="hero_class">Classe de votre héros </label>
            <label>
                <input type="radio" name="classePerso" value="Guerrier" required>
                <img src="./../image/Dark Knight.jpg" style="width: 150px; height: 150px;" alt="Image Guerrier" />
            </label>
            <label>
                <input type="radio" name="classePerso" value="Voleur">
                <img src="./../image/Thief.jpg" style="width: 150px; height: 150px;" alt="Image Voleur" />
            </label>
            <label>
                <input type="radio" name="classePerso" value="Magicien">
                <img src="./../image/Magician01.jpg" style="width: 150px; height: 150px;" alt="Image Magicien" />
            </label>
            <br>

            <label for="hero_name">Nom </label>
            <input name="hero_name" type="text" pattern="^[a-zA-Z][a-zA-Z0-9-_]{2,14}$" required>
            <br>

            <label for="hero_age">Age</label>
            <input name="hero_age" type="number" min="18" max="150" required>
            <br>

            <label for="bio">Biographie</label>
            <textarea id="comments" name="bio" rows="4" cols="50" placeholder=" Entrez la biographie" pattern="^[a-zA-Z0-9 .,!?'\"-]{10,1000}$" required>
            </textarea>
            <br>
            <input name="submit" type="submit" value="Commencez l'aventure">
        </form>
    </main>
</body>
</html>