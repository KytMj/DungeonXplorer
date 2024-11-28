<?php
    echo "bonjour !"
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hero creation</title>
</head>
<body>
    <h1>c'est la creation de héros en fait</h1>
    <form method="post">
        <label for="hero_name">nom de votre héros : </label>
        <input name="hero_name" type="text">

        <label for="hero_class">choisissez la classe de votre héros</label>
        <select name="hero_class" id="hero_class">
            <option value="guerrier">guerrier de metal</option>
            <option value="voleur">voleur</option>
        </select>
        
        <label for="bio">biographie</label>
        <input name="bio" type="text">

        <input name="submit" type="submit" value="finir la creation">
    </form>
</body>
</html>