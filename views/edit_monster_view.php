<?php require_once 'header.php'?>
        <style> .hidden { display: none; } </style>
        <main>
            <div>
                <h2>Gérer les Monstres</h2>
            </div>
            <div class="description">
                <p> Liste des Monstres </p>
                <select id="listMonster" name="monsterList" size="10">
                    <?php foreach ($admin->getMonsterList() as $monster):
                        echo("<option class=\"space\" value=\"".$monster['mons_id']."\"> <p>".$monster['mons_name']."</p> </option>");
                        echo var_dump($monster);
                    endforeach;?>
                </select>
                <!-- Bouton de création tout le temps accessible -->
                <button type="button" id="createMonsterBtn">Créer un nouveau Monstre</button>
                
                <div id="divMonsterCreation" class="hidden">
                    <form id="formMonsterCreation" name="formMonsterCreation" action="creationMonster" method="post">
                        <div>
                            <label for="nom">Nom : </label>
                            <input type="text" id="nom" name="nom" size="20" value="" placeholder="Nom du Monstre" 
                            pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s'-]{3,20}" required>
                        </div>
                        <div>
                            <label for="bio">Biographie</label>
                            <textarea id="comments" name="bio" rows="4" cols="50" placeholder=" Biographie du monstre" pattern="^[a-zA-Z0-9 .,!?'\"-]{10,1000}$" required>
                            </textarea>
                        </div>
                        <div>
                            <label for="xp">XP : </label>
                            <input name="xp" type="number" min="0" max="200" required>
                        </div>
                        <div>
                            <label for="attack">Attaque : </label>
                            <input type="text" id="attack" name="attack" size="100" value="" placeholder="Attaque du monstre" 
                            pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s'-]{3,100}" required>
                        </div>
                        <div>
                            <label for="pv">PV : </label>
                            <input name="pv" type="number" min="1" max="100" required>
                        </div>
                        <div>
                            <label for="mana">Mana : </label>
                            <input name="mana" type="number" min="1" max="10" required>
                        </div>
                        <div>
                            <label for="initiative">Initiative : </label>
                            <input name="initiative" type="number" min="1" max="30" required>
                        </div>
                        <div>
                            <label for="strength"> Strength : </label>
                            <input name="strength" type="number" min="1" max="10" required>
                        </div>
                        <button id="btnMonsterCreation" type="submit" name="submit" value=""> Créer</button>   
                    </form>
                </div>
                
                <!-- Accessible que quand une option est sélectionnée-->
                <button type="button" id="editMonsterBtn">Mettre à jour ce Monstre</button>

                <form id="formMonsterDeletion" name="formMonsterDel" action="editMonster" method="post">
                    <button type="submit" id="deleteMonsterBtn" name="deleteMonster"> Supprimer ce Monstre</button> 
                </form>
                
            </div>

            <script>
                document.getElementById('createMonsterBtn').addEventListener('click', function() {
                    document.getElementById('divMonsterCreation').classList.remove('hidden');
                });



                const buttonDelete = document.getElementById('deleteMonsterBtn');
                const select = document.getElementById('listMonster');
                select.addEventListener('change', function() {
                    buttonDelete.disabled = !this.selectedIndex;
                });
                buttonDelete.onclick = function() { 
                    buttonDelete.value = select.options[select.selectedIndex].value;
                    var popup = confirm("Voulez-vous vraiment supprimer ce monstre ?");
                    if(popup){
                        document.getElementById("formMonsterDeletion").action = "deletionMonster";
                    }
                    else{
                        document.getElementById("formMonsterDeletion").action = "editMonster";
                    }
                }
            </script>

        </main>
    </body>
</html>