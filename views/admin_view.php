<?php 
require_once 'header.php';
?>
        <main>
            <h1>Panel administrateur</h1>

            <p> Liste d'utilisateurs </p>
            <select id="listUser" name="userList" size="5">
                <?php foreach ($admin->getUserList() as $user):
                    echo("<option class=\"space\" value=\"".$user['user_id']."\"> <p>".$user['user_mail']."</p> </option>");
                endforeach;?>
            </select>

            <form id="formUserSUPP" name="formUserSUPP" action="adminPanel" method="post">
                <button id="btnSuppUser" type="submit" name="supprimerUser" value="" disabled>Supprimer</button>   
            </form>
        </main>
        <script>
            const button = document.getElementById('btnSuppUser');
            const select = document.getElementById('listUser');
            select.addEventListener('change', function() {
            button.disabled = !this.selectedIndex;
            });
            button.onclick = function() { 
                button.value = select.options[select.selectedIndex].value;
                var popup = confirm("Voulez-vous vraiment supprimer votre compte ?");
                if(popup){
                    document.getElementById("formUserSUPP").action = "supprUser";
                }
                else{
                    document.getElementById("formUserSUPP").action = "adminPanel";
                }
            }

        </script>
    </body>
</html>