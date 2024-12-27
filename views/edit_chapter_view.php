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


                <button type="button" id="updateChapterBtn" name="updateChapter"> Mettre à jour les informations de ce Chapitre</button> 
                
                <div id="divChapterUpdate" class="hidden">
                    <form id="formChapterUpdate" name="formChapterUpdate" action="updateChapter" method="post">
                        <input type="hidden" id="chap_id" name="chap_id" value="">
                        <div>
                            <label for="titleUpdate">Titre : </label>
                            <input type="text" id="titleUpdate" name="titleUpdate" size="100" value="" placeholder="Titre du Chapitre" 
                            pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s'-]{3,255}" required>
                        </div>
                        <div>
                            <label for="contentUpdate">Contenu : </label>
                            <textarea id="contentUpdate" name="contentUpdate" rows="4" cols="50" placeholder=" Contenu du chapitre" value="" pattern="^[a-zA-Z0-9 .,!?'\"-]{10,1000}$" required>
                            </textarea>
                        </div>
                        <div>
                            <label for="imageUpdate">URL de l'image : </label>
                            <input id="imageUpdate" type="text" id="imageUpdate" name="imageUpdate" size="100" value="" placeholder="URL" 
                            pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s'-]{3,255}" required>
                        </div>
                        <div>
                            <label for="xpUpdate">XP : </label>
                            <input id="xpUpdate" name="xpUpdate" type="number" min="0" max="9999" value="" required>
                        </div>
                        <div>
                            <label for="isCombatUpdate">Combat (1=oui, 0=non) : </label>
                            <input id="isCombatUpdate" name="isCombatUpdate" type="number" min="0" max="1" value="" required>
                        </div>
                        <button id="btnChapterUpdate" type="submit" name="submit" value=""> Mettre à jour</button>
                    </form>
                </div>          
                
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



                document.getElementById('updateChapterBtn').addEventListener('click', function() { 
                    var selectedChapter = document.getElementById('listChapter').value; 
                    console.log(selectedChapter); 
                    if (selectedChapter) { 
                        fetch(`getChapterData/${selectedChapter}`, { 
                            method: 'POST', 
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
                        }) 
                        .then(response => response.json()) 
                        .then(data => {
                            console.log('Données reçues : ', data);  // Vérification des données reçues

                            if (data && Array.isArray(data) && data.length > 0) {
                                const chapter = data[0]; 

                                document.getElementById('titleUpdate').value = chapter.chap_title.trim();
                                document.getElementById('contentUpdate').value = chapter.chap_content.trim();
                                document.getElementById('imageUpdate').value = chapter.chap_image.trim();
                                document.getElementById('xpUpdate').value = chapter.chap_XpGained;
                                document.getElementById('isCombatUpdate').value = chapter.chap_isCombat;
                                document.getElementById('chap_id').value = chapter.chap_id;

                                document.getElementById('divChapterUpdate').classList.remove('hidden');
                            } else {
                                alert('Aucune donnée reçue ou format incorrect');
                            }
                        })
                        .catch(error => {
                            console.error('Erreur lors de la récupération des données : ', error);
                            alert('Erreur lors de la récupération des données');
                        });
                    } else {
                         alert("Veuillez sélectionner un chapitre à mettre à jour."); 
                    } 
                });
                    
                document.getElementById('formChapterUpdate').addEventListener('submit', function(event) { 
                    var popup = confirm("Voulez-vous vraiment mettre à jour ce chapitre ?"); 
                    if (!popup) { 
                        event.preventDefault(); 
                    } 
                });
                
            </script>

        </main>
    </body>
</html>
