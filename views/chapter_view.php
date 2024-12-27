<?php
// view/chapter.php
$chapterController = new ChapterController();
if (isset($_POST['choicesChapter'])){
    $_SESSION['chapter'] = $_POST['choicesChapter'];
    $chapter = $chapterController->getChapter($_POST['choicesChapter']);
}
else{
    $chapter = $chapterController->getChapter($_SESSION['chapter']);
}
?>

<?php require_once 'header.php'?>
        <main>
            <h1><?php echo $chapter->getTitle(); ?></h1>
            <img src="./../image/<?php echo  $chapter->getImage(); ?>" alt="Image de chapitre" class="img-fluid" style="width: 150px; height: 150px;"/>
            <p><?php echo $chapter->getDescription(); ?></p>

            <?php 
                if(count($chapter->getChoices()) != 0){ 
                    echo "<h2>Choisissez votre chemin:</h2>";
                }
            ?>
            <?php if($chapter->getIsCombat() == 1){
                echo(
                "<form id=\"formChapter\" name=\"formChapter\" action=\"combat\" method=\"post\">
                    <button type=\"submit\" name=\"submit\" value=\"".$chapter->getId()."\">Combattre</button>
                </form>");
            }else{
            echo("<ul class=\"chapterChoices\">");
            foreach ($chapter->getChoices() as $choice):
                if($choice['text'] == "Terminer" || $choice['text'] == "C'est reparti !!!"){
                    echo "<li>";
                        echo("<form id=\"formChapter\" name=\"formChapter\" action=\"reinitializeHero\" method=\"post\">");
                            echo("<button type=\"submit`\" name=\"choicesChapter\" value=\"".$choice['chapter']."\">".$choice['text']."</button>");
                        echo("</form>");
                    echo "</li>";
                }else{
                    echo "<li>";
                        echo("<form id=\"formChapter\" name=\"formChapter\" action=\"chapter\" method=\"post\">");
                            echo("<button type=\"submit`\" name=\"choicesChapter\" value=\"".$choice['chapter']."\">".$choice['text']."</button>");
                        echo("</form>");
                    echo "</li>";
                }
            endforeach;
            echo("</ul>");
            }?>
        </main>
    </body>
</html>
