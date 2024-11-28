<?php

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
        // Suppression du préfixe du début de l'URL
        if ($this->prefix && strpos($url, $this->prefix) === 0) {
            $url = substr($url, strlen($this->prefix) + 1);
        }

        // Suppression des barres obliques en trop
        $url = trim($url, '/');

        // Vérification de la correspondance de l'URL à une route définie
        if (array_key_exists($url, $this->routes)) {
            // Extraction du nom du contrôleur et de la méthode
            list($controllerName, $methodName) = explode('@', $this->routes[$url]);

            // Instanciation du contrôleur et appel de la méthode
            $controller = new $controllerName();
            $controller->$methodName();
        } else {
            // Gestion des erreurs (page 404, etc.)
            echo '<h2>la page demandée n\'existe pas</h2>';
        }
    }
}

// Instanciation du routeur
$router = new Router('DUNGEONXPLORER');

// Ajout des routes
$router->addRoute('', 'HomeController@index'); // Pour la racine
$router->addRoute('creer_un_compte', 'AccountCreationController@index'); // Pour la racine
$router->addRoute('connection', 'ConnectionController@index');


// Appel de la méthode route
$router->route(trim($_SERVER['REQUEST_URI'], '/'));