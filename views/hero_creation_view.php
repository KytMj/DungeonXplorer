<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créez votre personnage</title>
</head>
<body>
    <a href="home"><img src="./../image/Logo.png" class="img-fluid" style="width: 150px; height: 150px;" alt="Logo Dungeon Xplorer" /></a>
    <h1>Créez votre personnage</h1>
    <form method="post">
        <label for="hero_class">Classe de votre héros </label>
        <label>
            <input type="radio" name="classePerso" value="guerrier">
            <img src="./../image/Dark Knight.jpg" style="width: 150px; height: 150px;" alt="Image Guerrier" />
        </label>
        <label>
            <input type="radio" name="classePerso" value="voleur">
            <img src="./../image/Thief.jpg" style="width: 150px; height: 150px;" alt="Image Voleur" />
        </label>
        <label>
            <input type="radio" name="classePerso" value="magicien">
            <img src="./../image/Magician01.jpg" style="width: 150px; height: 150px;" alt="Image Magicien" />
        </label>
        <br>

        <label for="hero_name">Nom </label>
        <input name="hero_name" type="text">
        <br>

        <label for="hero_age">Age</label>
        <input name="hero_age" type="number" min="18" max="150">
        <br>

        <label for="bio">Biographie</label>
        <textarea id="comments" name="comments" rows="4" cols="50" placeholder=" Entrez la biographie">
        </textarea>
        <br>
        <input name="submit" type="submit" value="Commencez l'aventure">
    </form>
</body>
</html>