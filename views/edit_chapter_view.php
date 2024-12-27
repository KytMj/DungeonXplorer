<?php require_once 'header.php'?>
        <main>
            <div>
                <h2>Gérer les Chapitres</h2>
            </div>
            <div class="description">
                <p> Liste des Chapitres </p>
                <select id="listChapter" name="chapterList" size="10">
                    <?php foreach ($admin->getChapterList() as $chapter):
                        echo("<option class=\"space\" value=\"".$chapter['chap_id']."\"> <p>".$chapter['chap_title']."</p> </option>");
                    endforeach;?>
                </select>

                <!-- Bouton de création tout le temps accessible -->
                <button type="button" id="createChapterBtn">Créer un nouveau Chapitre</button>
                
                <div id="divChapterCreation" class="hidden">
                    <form id="formChapterCreation" name="formChapterCreation" action="creationChapter" method="post">
                        <div>
                            <label for="title">Titre : </label>
                            <input type="text" id="title" name="title" size="100" value="" placeholder="Titre du Chapitre" 
                            pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s'-]{3,255}" required>
                        </div>
                        <div>
                            <label for="content">Contenu : </label>
                            <textarea id="content" name="content" rows="4" cols="50" placeholder=" Biographie du monstre" pattern="^[a-zA-Z0-9 .,!?'\"-]{10,1000}$" required>
                            </textarea>
                        </div>
                        <div>
                            <label for="image">URL de l'image : </label>
                            <input type="text" id="image" name="image" size="100" value="" placeholder="URL" 
                            pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s'-]{3,255}" required>
                        </div>
                        <div>
                            <label for="xp">XP : </label>
                            <input name="xp" type="number" min="0" max="9999" required>
                        </div>
                        <div>
                            <label for="isCombat">Combat (1=oui, 0=non) : </label>
                            <input name="isCombat" type="number" min="0" max="1" required>
                        </div>

                        <button id="btnChapterCreation" type="submit" name="submit" value=""> Créer</button>   
                    </form>
                </div>

                
                <form id="formChapterDeletion" name="formChapterDel" action="deleteChapter" method="post">
                    <button type="submit" id="deleteChapterBtn" name="deleteChapter"> Supprimer ce Chapitre</button> 
                </form>
                
                
            </div>

            <script>
                document.getElementById('createChapterBtn').addEventListener('click', function() {
                    document.getElementById('divChapterCreation').classList.remove('hidden');
                });


                const buttonDelete = document.getElementById('deleteChapterBtn');
                const select = document.getElementById('listChapter');
                select.addEventListener('change', function() {
                    buttonDelete.disabled = !this.selectedIndex;
                });
                buttonDelete.onclick = function() { 
                    buttonDelete.value = select.options[select.selectedIndex].value;
                    var popup = confirm("Voulez-vous vraiment supprimer ce chapitre ?");
                    if(popup){
                        document.getElementById("formChapterDeletion").action = "deletionChapter";
                    }
                    else{
                        document.getElementById("formChapterDeletion").action = "editChapter";
                    }
                }
                
            </script>

        </main>
    </body>
</html>
