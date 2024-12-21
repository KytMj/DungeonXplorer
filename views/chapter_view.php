<?php
// view/chapter.php
include_once "./controllers/ChapterController.php";
include_once "./models/Inventory.php";
include_once "./models/Item.php";

$chapterController = new ChapterController();
if (isset($_POST['submit'])){
    $chapter = $chapterController->getChapter($_POST['submit']);
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
            <img src="./../image/<?php echo  $chapter->getImage(); ?>" alt="Image de chapitre" class="img-fluid" style="width: 150px; height: 150px;"/>
            <p><?php echo $chapter->getDescription(); ?></p>

            <?php if(count($chapter->getChoices()) != 0){ echo "<h2>Choisissez votre chemin:</h2>";}?>
            <ul>
                <?php foreach ($chapter->getChoices() as $choice): ?>
                    <li>
                        <form id="formChapter" name="formChapter" action="chapter" method="post">
                            <button type="submit" name="submit" value="<?php echo $choice['chapter'] ?>"><?php echo $choice['text'] ?></button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        </main>
    </body>
</html>
