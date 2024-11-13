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
    <h1><?php echo $chapter->getTitle(); ?></h1>
    <img src="<?php echo  $chapter->getImage(); ?>" alt="Image de chapitre" style="max-width: 100%; height: auto;">
    <p><?php echo $chapter->getDescription(); ?></p>

    <h2>Choisissez votre chemin:</h2>
    <ul>
        <?php foreach ($chapter->getChoices() as $choice):
            
//             You cant redirect page with post values in php.

// If you want then you have to use javascript as most sites are doing (if you have seen paypal or other sites saying “wait for 5 seconds”.).

// You can do it as below.

// <form name=‘fr’ action=‘redirect(.)php’ method=‘POST’>
// <include type=‘hidden’ name=‘var1’ value=‘val1’>
// <include type=‘hidden’ name=‘var2’ value=‘val2’>
// </form>
// <script type=‘text/javascript’>
// document.fr.submit();
// </script>

// This will post all variables to redirect(.)php.

// I hope this will help you.
?>
            <li>
                <a href="chapter_view.php?chapter=<?php echo $choice['chapter']; ?>">
                    <?php echo $choice['text']; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>


