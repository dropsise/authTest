<?php

require_once './views/View.php';

/**
 * 
 */
class Router
{
    /**
     * La requête 
     */
    public function routeReq() {
        try {
            $url = '';
            if (isset($_GET['url'])) :
                // Le controlleur est inclus selon l'action de l'utilisateur
                $url = explode('/', filter_var($_GET['url'], FILTER_SANITIZE_URL));
                $controller = ucfirst(strtolower($url[0]));
                $controllerClass = 'Controller'.$controller;
                $controllerFile = './controllers/'.$controllerClass.'.php';
                if (file_exists($controllerFile)) :
                    require_once($controllerFile);
                    $this->_ctrl = new $controllerClass($url);
                else :
                    throw new Exception('Page introuvable', 404);
                endif;
            else:
                $this->_view = new View('Connexion');
                $this->_view->generate();
            endif;
        } catch (Exception $e) {
            // Gestion des érreurs
            $this->_view = new View();
            $this->_view->generate(array(
                'success' => false,
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ));
        }
    }

    // Le controlleur
    private $_ctrl;
    // La vue
    private $_view;
}