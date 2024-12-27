<?php require_once 'header.php'?>
<!-- Page de choix entre continuer l'aventure(si commencée) ou nouvelle aventure-->
        <main>
            <h1> Partir à l'Aventure ! </h1>
            <div class="description">
                <div id="resumeAdventure">
                    <a href="chapter"><button type="button" id="ResumeAdventureButton"> <i class="fa-solid fa-play"></i>  Continuer votre aventure </button></a>
                </div>
                </br>
                <div id="startAdventure">
                    <a href="herocreation" id="startAdventureLink"><button type="button" id="StartNewAdventureButton"> <i class="fa-solid fa-plus"></i>  Commencer une nouvelle aventure</button></a>
                </div>
            </div>
        </main>
        
        <script>
            var hero = <?php echo json_encode($hero); ?>;
            if(hero == true){
                let buttonAdventure = document.getElementById('StartNewAdventureButton');
                buttonAdventure.onclick = () => { 
                    var popup = confirm("Voulez-vous vraiment supprimer votre personnage ?");
                    if(popup){
                        document.getElementById("startAdventureLink").href = "userHeroSuppression";
                    }
                    else{
                        document.getElementById("startAdventureLink").href = "adventure";
                    }
                }
            }
            
            console.log(quest)
            var quest = <?php echo json_encode($quest); ?>;
            if(quest == false){
                let resumeAdventure = document.getElementById('resumeAdventure');
                resumeAdventure.style.display='none';
            }

        </script>
    </body>
</html>