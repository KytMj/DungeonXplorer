<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Connexion</title>

  <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
  <link href="../assets/css/style_connexion.css" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</head>
<body class="bg-connexion">
  <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">
              <form id="formulaireConnexion" name="formulaireConnexion" action="connexion.php" method="post"
              enctype="application/x-www-form-urlencoded">
  
              <div class="mb-md-5 mt-md-4 pb-5">
                <a class="navbar-brand text-brand" href="../site.php"><img class="logo" src="../Images/logo.png" alt="logo"></a>
  
                <h2 class="fw-bold mb-2 text-uppercase">Connexion</h2>
                <p class="text-white-50 mb-5">Entrez votre adresse mail et votre mot de passe</p>

  
                <div data-mdb-input-init class="form-outline form-white mb-4">
                  <label for="mail" class="form-label" >Email</label>
                  <input for="mail" name="mail" type="email" id="mail" class="form-control form-control-lg" value="" placeholder="" required/>
                </div>
  
                <div data-mdb-input-init class="form-outline form-white mb-4">
                  <label class="form-label" for="mdp">Mot de passe</label>
                  <input type="password" id="code" name="code" class="form-control form-control-lg" AUTOCOMPLETE=OFF required/>
                </div>
                
                <br>
                <br>
                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5" type="submit" name="BtSub">Connexion</button>
  
                <div class="d-flex justify-content-center text-center mt-4 pt-1">
                  <a href="#!" class="text-white"><i class="bi bi-facebook fa-lg"></i></a>
                  <a href="#!" class="text-white"><i class="bi bi-twitter-x fa-lg mx-4 px-2"></i></a>
                  <a href="#!" class="text-white"><i class="bi bi-instagram fa-lg"></i></a>
                </div>
              </div>
              <div>
                <p class="mb-0">Vous n'avez pas de compte ? <a href="account_creation_view.php" class="text-white-50 fw-bold">Créer un compte</a>
                </p>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


</body>
</html>