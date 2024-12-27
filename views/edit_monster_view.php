<?php require_once 'header.php'?>
        <main>
            <div>
                <h2>Gérer les Monstres</h2>
            </div>
            <div class="description">
                <p> Liste des Monstres </p>
                <select id="listMonster" name="monsterList" size="10">
                    <?php foreach ($admin->getMonsterList() as $monster):
                        echo("<option class=\"space\" value=\"".$monster['mons_id']."\"> <p>".$monster['mons_name']."</p> </option>");
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
                            <input name="mana" type="number" min="0" max="10" required>
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
            
                
                
                <form id="formMonsterDeletion" name="formMonsterDel" action="deleteMonster" method="post">
                    <button type="submit" id="deleteMonsterBtn" name="deleteMonster"> Supprimer ce Monstre</button> 
                </form>

                
                
                
                <button type="button" id="updateMonsterBtn" name="updateMonster"> Mettre à jour ce Monstre</button> 
                
                <div id="divMonsterUpdate" class="hidden">
                    <form id="formMonsterUpdate" name="formMonsterUpdate" action="updateMonster" method="post">
                        <input type="hidden" id="mons_id" name="mons_id" value="">
                        <div>
                            <label for="nom">Nom : </label>
                            <input type="text" id="nomUpdate" name="nom" size="20" value="" placeholder="Nom du Monstre" 
                            pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s'-]{3,20}" required>
                        </div>
                        <div>
                            <label for="bio">Biographie</label>
                            <textarea id="bioUpdate" name="bio" rows="4" cols="50" placeholder=" Biographie du monstre" pattern="^[a-zA-Z0-9 .,!?'\"-]{10,1000}$" required>
                            </textarea>
                        </div>
                        <div>
                            <label for="xp">XP : </label>
                            <input id="xpUpdate" name="xp" type="number" min="0" max="200" required>
                        </div>
                        <div>
                            <label for="attack">Attaque : </label>
                            <input type="text" id="attackUpdate" name="attack" size="100" value="" placeholder="Attaque du monstre" 
                            pattern="^[A-Za-zÀ-ÿ\s'-]{3,100}$" required>
                        </div>
                        <div>
                            <label for="pv">PV : </label>
                            <input id="pvUpdate" name="pv" type="number" min="1" max="100" required>
                        </div>
                        <div>
                            <label for="mana">Mana : </label>
                            <input id="manaUpdate" name="mana" type="number" min="1" max="10" required>
                        </div>
                        <div>
                            <label for="initiative">Initiative : </label>
                            <input id="initiativeUpdate" name="initiative" type="number" min="1" max="30" required>
                        </div>
                        <div>
                            <label for="strength"> Strength : </label>
                            <input id="strengthUpdate" name="strength" type="number" min="1" max="10" required>
                        </div>
                        <button id="btnMonsterUpdate" type="submit" name="submit" value=""> Mettre à jour</button>
                    </form>
                </div>
                
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

                document.getElementById('updateMonsterBtn').addEventListener('click', function() { 
                    var selectedMonster = document.getElementById('listMonster').value; 
                    console.log(selectedMonster); 
                    if (selectedMonster) { 
                        console.log("Est-ce que ça marche ?"); 
                        fetch(`getMonsterData/${selectedMonster}`, { 
                            method: 'POST', 
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
                        }) 
                        .then(response => response.json()) 
                        .then(data => {
                            console.log('Données reçues : ', data);  // Vérification des données reçues

                            // Vérifier si les données sont valides
                            if (data && Array.isArray(data) && data.length > 0) {
                                const monster = data[0];  // Si les données sont dans un tableau, on prend le premier monstre

                                document.getElementById('nomUpdate').value = monster.mons_name.trim();
                                document.getElementById('bioUpdate').value = monster.mons_biography.trim();
                                document.getElementById('xpUpdate').value = monster.mons_xp;
                                document.getElementById('attackUpdate').value = monster.mons_attack.trim();
                                document.getElementById('pvUpdate').value = monster.mons_pv;
                                document.getElementById('manaUpdate').value = monster.mons_mana;
                                document.getElementById('initiativeUpdate').value = monster.mons_initiative;
                                document.getElementById('strengthUpdate').value = monster.mons_strength;
                                document.getElementById('mons_id').value = monster.mons_id;

                                document.getElementById('divMonsterUpdate').classList.remove('hidden');
                            } else {
                                alert('Aucune donnée reçue ou format incorrect');
                            }
                        })
                        .catch(error => {
                            console.error('Erreur lors de la récupération des données : ', error);
                            alert('Erreur lors de la récupération des données');
                        });
                    } else {
                         alert("Veuillez sélectionner un monstre à mettre à jour."); 
                    } 
                });
                    
                    document.getElementById('formMonsterUpdate').addEventListener('submit', function(event) { 
                        var popup = confirm("Voulez-vous vraiment mettre à jour ce monstre ?"); 
                        if (!popup) { 
                            event.preventDefault(); 
                        } 
                    });


               </script>

        </main>
    </body>
</html>
