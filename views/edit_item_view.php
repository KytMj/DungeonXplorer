<?php require_once 'header.php'?>
        <main>
            <div>
                <h2>Gérer les Objets / Items</h2>
            </div>
            <div class="description">
                <p> Liste des Objets / Items </p>
                <select id="listItem" name="itemList" size="15">
                    <?php foreach ($admin->getItemList() as $item):
                        echo("<option class=\"space\" value=\"".$item['ite_id']."\"> <p>".$item['ite_name']."</p> </option>");
                    endforeach;?>
                </select>

                <!-- Bouton de création tout le temps accessible -->
                <button type="button" id="createItemBtn">Créer un nouvel Objet</button>
                
                <div id="divItemCreation" class="hidden">
                    <form id="formItemCreation" name="formItemCreation" action="creationItem" method="post">
                        <div>
                            <label for="nom">Nom : </label>
                            <input type="text" id="nom" name="nom" size="50" value="" placeholder="Nom de l'Objet" 
                            pattern="^[a-zA-Z0-9 .,!?'\"-]{2,50}$" required>
                        </div>
                        <div>
                            <label for="itetype">Type d'Objet : </label>
                            <input type="text" id="itetype" name="itetype" size="100" value="" placeholder="Type de l'Objet" 
                            pattern="^[a-zA-Z0-9 .,!?'\"-]{1,50}$" required>
                        </div>
                        <div>
                            <label for="description">Description</label>
                            <textarea id="description" name="description" rows="4" cols="50" placeholder="Description de l'objet" pattern="^[a-zA-Z0-9 .,!?'\"-]{10,1000}$" required>
                            </textarea>
                        </div>
                        
                        <div>
                            <label for="itecle">Item clé : </label>
                            <input name="itecle" type="number" min="0" max="1" value="0" required>
                        </div>
                        <div>
                            <label for="effect">Effet : </label>
                            <input type="text" id="effect" name="effect" size="100" value="" placeholder="Effet de l'Objet" 
                            pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s'-]{3,100}" required>
                        </div>
                        
                        <div>
                            <label for="iteequipable">Equipable : </label>
                            <input name="iteequipable" type="number" min="0" max="1" value="0" required>
                        </div>
                        
                        <button id="btnItemCreation" type="submit" name="submit"> Créer </button>   
                    </form>
                </div>



                <form id="formItemDeletion" name="formItemDel" action="deleteItem" method="post">
                    <button type="submit" id="deleteItemBtn" name="deleteItem"> Supprimer cet Objet</button> 
                </form>



                <button type="button" id="updateItemBtn" name="updateItem"> Mettre à jour cet Objet</button> 
                
                <div id="divItemUpdate" class="hidden">
                    <form id="formItemUpdate" name="formItemUpdate" action="updateItem" method="post">
                        <div>
                            <label for="nomUpdate">Nom : </label>
                            <input type="text" id="nomUpdate" name="nomUpdate" size="50" value="" placeholder="Nom de l'Objet" 
                            pattern="^[a-zA-Z0-9 .,!?'\"-]{2,50}$" required>
                        </div>
                        <div>
                            <label for="itetypeUpdate">Type d'Objet : </label>
                            <input type="text" id="itetypeUpdate" name="itetypeUpdate" size="100" value="" placeholder="Type de l'Objet" 
                            pattern="^[a-zA-Z0-9 .,!?'\"-]{1,50}$" required>
                        </div>
                        <div>
                            <label for="descriptionUpdate">Description</label>
                            <textarea id="descriptionUpdate" name="descriptionUpdate" rows="4" cols="50" placeholder="Description de l'objet" pattern="^[a-zA-Z0-9 .,!?'\"-]{10,1000}$" required>
                            </textarea>
                        </div>
                        
                        <div>
                            <label for="itecleUpdate">Item clé : </label>
                            <input id="itecleUpdate" name="itecleUpdate" type="number" min="0" max="1" value="" required>
                        </div>
                        <div>
                            <label for="effectUpdate">Effet : </label>
                            <input type="text" id="effectUpdate" name="effectUpdate" size="100" value="" placeholder="Effet de l'Objet" 
                            pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s'-]{3,100}" required>
                        </div>
                        
                        <div>
                            <label for="iteequipableUpdate">Equipable : </label>
                            <input id="iteequipableUpdate" name="iteequipableUpdate" type="number" min="0" max="1" value="" required>
                        </div>
                        
                        <button id="btnItemUpdate" type="submit" name="submit"> Créer </button>   
                    </form>
                </div>
                
            </div>


                <script>
                document.getElementById('createItemBtn').addEventListener('click', function() {
                    document.getElementById('divItemCreation').classList.remove('hidden');
                });




                const buttonDelete = document.getElementById('deleteItemBtn');
                const select = document.getElementById('listItem');
                select.addEventListener('change', function() {
                    buttonDelete.disabled = !this.selectedIndex;
                });
                buttonDelete.onclick = function() { 
                    buttonDelete.value = select.options[select.selectedIndex].value;
                    var popup = confirm("Voulez-vous vraiment supprimer cet Objet ?");
                    if(popup){
                        document.getElementById("formItemDeletion").action = "deletionItem";
                    }
                    else{
                        document.getElementById("formItemDeletion").action = "editItem";
                    }
                }





                document.getElementById('updateItemBtn').addEventListener('click', function() { 
                    var selectedItem = document.getElementById('listItem').value; 
                    if (selectedItem) { 
                        fetch(`getItemData/${selectedItem}`, { 
                            method: 'POST', 
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
                        }) 
                        .then(response => response.json()) 
                        .then(data => {
                            console.log('Données reçues : ', data);  // Vérification des données reçues

                            // Vérifier si les données sont valides
                            if (data && Array.isArray(data) && data.length > 0) {
                                const item = data[0];
                                // Directement accéder aux propriétés de l'objet
                                document.getElementById('nomUpdate').value = item.ite_name;
                                document.getElementById('itetypeUpdate').value = item.ite_type;
                                document.getElementById('descriptionUpdate').value = item.ite_description.trim();
                                document.getElementById('itecleUpdate').value = item.ite_itemCle;
                                document.getElementById('effectUpdate').value = item.ite_effects.trim();
                                document.getElementById('iteequipableUpdate').value = item.ite_equipable;

                                // Afficher la section de mise à jour
                                document.getElementById('divItemUpdate').classList.remove('hidden');
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
                    
                    document.getElementById('formItemUpdate').addEventListener('submit', function(event) { 
                        var popup = confirm("Voulez-vous vraiment mettre à jour cet Objet ?"); 
                        if (!popup) { 
                            event.preventDefault(); 
                        } 
                    });


               </script>
                
                

        </main>
    </body>
</html>
