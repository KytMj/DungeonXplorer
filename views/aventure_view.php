<?php require_once 'header.php'?>
<!-- Page de choix entre continuer l'aventure(si commencée) ou nouvelle aventure-->
        <main>
            <h1>Choisissez</h1>
            <div id="resumeAdventure">
                <a href="chapter"><button type="button" id="ResumeAdventureButton">Continuer votre aventure</button></a>
            </div>
            <div id="startAdventure">
                <a href="herocreation"><button type="button" id="StartNewAdventureButton">Commencer une nouvelle aventure</button></a>
            </div>
        </main>
        
        <script>
            var quest = <?php echo json_encode($quest); ?>;
            if(quest == false){
                let resumeAdventure = document.getElementById('resumeAdventure');
                resumeAdventure.style.display='none';
            }

            var hero = <?php echo json_encode($hero); ?>;
            if(hero == true){
                let buttonAdventure = document.getElementById('StartNewAdventureButton');
                buttonAdventure.onclick = () => { 
                    var popup = confirm("Voulez-vous vraiment supprimer votre personnage ?");
                    if(popup){
                        console.log("JE SUPPRIME");
                        document.getElementById("startAdventureLink").href = "userHeroSuppression";
                    }
                    else{
                        document.getElementById("startAdventureLink").href = "adventure";
                    }
                }
            }
        </script>
    </body>
</html>