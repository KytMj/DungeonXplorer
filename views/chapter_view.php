<?php
// view/chapter.php
include_once "./controllers/ChapterController.php";
include_once "./models/Inventory.php";
include_once "./models/Item.php";

$chapterController = new ChapterController();
if (isset($_POST['submit']) && $_POST['submit'] != "Commencez l'aventure"){
    $_SESSION['chapter'] = $_POST['submit'];
    $chapter = $chapterController->getChapter($_POST['submit']);
}
else{
    $chapter = $chapterController->getChapter($_SESSION['chapter']);
}
$inventory = new Inventory();
$inventory->add(new Item("pouler", "aaah", 0));
?>

<?php require_once 'header.php'?>
        <main>
            <h1><?php echo $chapter->getTitle(); ?></h1>
            <img src="./../image/<?php echo  $chapter->getImage(); ?>" alt="Image de chapitre" class="img-fluid" style="width: 150px; height: 150px;"/>
            <p><?php echo $chapter->getDescription(); ?></p>

            <?php 
                if(count($chapter->getChoices()) != 0){ 
                    echo "<h2>Choisissez votre chemin:</h2>";
                }else{
                    // retour au chapitre 1 ? réinitialisation du perso ?
                }
            ?>
            <?php if($chapter->getIsCombat() == 1){
                echo(
                "<form id=\"formChapter\" name=\"formChapter\" action=\"combat\" method=\"post\">
                    <button type=\"submit\" name=\"submit\" value=\"".$chapter->getId()."\">Combattre</button>
                </form>");
            }else{
            echo("<ul>");
            foreach ($chapter->getChoices() as $choice):
                echo "<li>";
                    echo("<form id=\"formChapter\" name=\"formChapter\" action=\"chapter\" method=\"post\">");
                        echo("<button type=\"submit`\" name=\"submit\" value=\"".$choice['chapter']."\">".$choice['text']."</button>");
                    echo("</form>");
                echo "</li>";
            endforeach;
            echo("</ul>");
            }?>
        </main>
    </body>
</html>
