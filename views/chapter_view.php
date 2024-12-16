<?php
// view/chapter.php
include_once "./../controllers/ChapterController.php";
$chapterController = new ChapterController();

$chapter = $chapterController->getChapter($_GET['chapter']);
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $chapter->getTitle(); ?></title>
    </head>
    <body>
        <?php include_once 'header.php'?>
        <main>
            <h1><?php echo $chapter->getTitle(); ?></h1>
            <img src="<?php echo  $chapter->getImage(); ?>" alt="Image de chapitre" style="max-width: 100%; height: auto;">
            <p><?php echo $chapter->getDescription(); ?></p>

            <h2>Choisissez votre chemin:</h2>
            <ul>
                <?php foreach ($chapter->getChoices() as $choice): ?>
                    <li>
                        <a href="chapter_view.php?chapter=<?php echo $choice['chapter']; ?>">
                            <?php echo $choice['text']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </main>
    </body>
</html>
