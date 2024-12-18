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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $chapter->getTitle(); ?></title>
    <link rel="stylesheet" href="./css/inventory.css">
</head>
<body>
    <h1><?php echo $chapter->getTitle(); ?></h1>
    <img src="<?php echo  $chapter->getImage(); ?>" alt="Image de chapitre" style="max-width: 100%; height: auto;">
    <p><?php echo $chapter->getDescription(); ?></p>

    <h2>Choisissez votre chemin:</h2>
    <ul>
        <?php foreach ($chapter->getChoices() as $choice): ?>
            <li>
                <form id="chapterForm" action="chapter_view.php" method="POST">
                    <input type="hidden" name="chapter" value="<?php echo $choice['chapter']; ?>">
                    <button type="submit">
                        <?php echo $choice['text']; ?>
                    </button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="popup" onclick="showInventory()">
        Inventory
        <?php foreach ($inventory->getInventory() as $index => $item) :?>
            
            <div class="popuptext" id="inventory-<?php echo $index; ?>">
                <?php echo ($item->getName()) ?>
            </div>
        <?php endforeach ?>
        </div>
    </div>
    <div>
        <?php
        include './hero_view.php';
        ?>
    </div>
    <script src="./js/inventory.js"></script>
</body>
</html>
