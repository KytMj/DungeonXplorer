<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'autoload.php';

class Router
{
    private $routes = [];
    private $prefix;

    public function __construct($prefix = '')
    {
        $this->prefix = trim($prefix, '/');
    }

    public function addRoute($uri, $controllerMethod)
    {
        $this->routes[trim($uri, '/')] = $controllerMethod;
    }

    public function route($url)
    {
        // Enlève le préfixe du début de l'URL
        if ($this->prefix && strpos($url, $this->prefix) === 0) {
            $url = substr($url, strlen($this->prefix) + 1);
        }
        // Enlève les barres obliques en trop
        $url = trim($url, '/');

        // Vérification de la correspondance de l'URL à une route définie
        foreach ($this->routes as $route => $controllerMethod) {
            // Vérifie si l'URL correspond à une route avec des paramètres
            $routeParts = explode('/', $route);
            $urlParts = explode('/', $url);

            // Si le nombre de segments correspond
            if (count($routeParts) === count($urlParts)) {
                // Vérification de chaque segment
                $params = [];
                $isMatch = true;
                foreach ($routeParts as $index => $part) {
                    if (preg_match('/^{\w+}$/', $part)) {
                        // Capture les paramètres
                        $params[] = $urlParts[$index];
                    } elseif ($part !== $urlParts[$index]) {
                        $isMatch = false;
                        break;
                    }
                }

                if ($isMatch) {
                    // Extraction du nom du contrôleur et de la méthode
                    list($controllerName, $methodName) = explode('@', $controllerMethod);

                    // Instanciation du contrôleur et appel de la méthode avec les paramètres
                    $controller = new $controllerName();
                    call_user_func_array([$controller, $methodName], $params);
                    return;
                }
            }
        }
        $_SESSION['erreur'] = "Erreur 404 : cette page n'existe pas.";

        // Si aucune route n'a été trouvée, gérer l'erreur 404
        require_once 'views/404.php';
        
    }
}

// Instanciation du routeur
$router = new Router('merge');

// Ajout des routes
//NAVBAR
$router->addRoute('', 'HomeController@index'); // Pour la racine
$router->addRoute('home', 'HomeController@index');
$router->addRoute('adminPanel', 'AdminController@index');
$router->addRoute('signin', 'AccountCreationController@index');
$router->addRoute('connexion', 'ConnectionController@index');
$router->addRoute('accountHero', 'HeroController@index');
$router->addRoute('account', 'AccountController@index');

//OTHERS PAGES
$router->addRoute('chapter', 'ChapterController@index');
$router->addRoute('character', 'CharacterController@index');
$router->addRoute('herocreation', 'HeroCreationController@index');
$router->addRoute('adventure', 'AventureController@index');
$router->addRoute('combat', 'CombatController@index');

//ACTIONS

$router->addRoute('connexionAccount', 'ConnectionController@connexion');
$router->addRoute('deconnexionAccount', 'ConnectionController@deconnexion');

$router->addRoute('addAccount', 'AccountCreationController@inscription');
$router->addRoute('modifMailAccount', 'AccountController@modifMail');
$router->addRoute('modifMDPAccount', 'AccountController@modifMDP');
$router->addRoute('supprAccountUser', 'AccountController@supprimerCompte');

$router->addRoute('userherocreation', 'HeroCreationController@creation');
$router->addRoute('herodeletion', 'HeroDeletionController@deletion');

$router->addRoute('supprUser', 'AdminController@supprimerUser');

$router->addRoute('userHeroSuppression', 'AventureController@supprimerHero');

$router->addRoute('reinitializeHero', 'ChapterController@reinitialize');

$router->addRoute('editMonster', 'EditMonsterController@index');
$router->addRoute('creationMonster', 'EditMonsterController@creation');
$router->addRoute('deletionMonster', 'EditMonsterController@deletion');
$router->addRoute('updateMonster', 'EditMonsterController@update');
$router->addRoute('getMonsterData/{id}', 'EditMonsterController@getMonsterData');

$router->addRoute('editItem', 'EditItemController@index');
$router->addRoute('creationItem', 'EditItemController@creation');
$router->addRoute('deletionItem', 'EditItemController@deletion');
$router->addRoute('updateItem', 'EditItemController@update');
$router->addRoute('getItemData/{id}', 'EditItemController@getItemData');

$router->addRoute('editChapter', 'EditChapterController@index');
$router->addRoute('creationChapter', 'EditChapterController@creation');
$router->addRoute('deletionChapter', 'EditChapterController@deletion');
$router->addRoute('updateChapter', 'EditChapterController@update');
$router->addRoute('getChapterData/{id}', 'EditChapterController@getChapterData');

// Appel de la méthode route
$router->route(trim($_SERVER['REQUEST_URI'], '/'));
?>