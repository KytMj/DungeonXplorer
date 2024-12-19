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
            // Si l'utilisateur est connecté
            let resumeAdventure = document.getElementById('resumeAdventure');
            resumeAdventure.style.display='none';
        </script>
    </body>
</html>

