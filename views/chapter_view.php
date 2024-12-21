<?php
// view/chapter.php
include_once "./../controllers/ChapterController.php";
include_once "./../models/Inventory.php";
include_once "./../models/Item.php";

$chapterController = new ChapterController();
if (isset($_POST['chapter'])){
    $chapter = $chapterController->getChapter($_POST['chapter']);
}
else{
    $chapter = $chapterController->getChapter(1);

}
$inventory = new Inventory();
$inventory->add(new Item("pouler", "aaah", 0));
?>

<?php require_once 'header.php'?>
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
