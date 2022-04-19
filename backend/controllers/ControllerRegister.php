<?php
require_once './tokens/middlewares/Auth.php';
require_once './controllers/Controller.php';

/**
 * Controlleur Register, permet de s'inscrire dans l'application.
 * 
 * PHP version 5
 * 
 * @category Authentication
 * @package  controllers
 * @author   Georgy Guei <gettien98@gmail.com>
 */
class ControllerRegister extends Controller
{
    /**
     * Constructeur
     * 
     * @param array $url L'URL de la page
     * 
     * @throws Exception
     * 
     * @uses hydrate
     * @uses register
     * @uses msgErr
     */
    public function __construct($url) {
        parent::__construct();
        // Setup request to send json via POST
        try {
            // PRENDRE LES DONNEES BRUTES DE LA REQUETE
            $json = file_get_contents('php://input');
            // LES CONVERTIR EN TABLEAU PHP
            $data = json_decode($json);

            // SI LA REQUEST METHOD EST DIFFERENTE DE POST
            if ($_SERVER['REQUEST_METHOD'] != 'POST'):
                throw new Exception('Page Introuvable', 404);
            endif;
            // L'UTILISATEUR PEUT SE CONNECTER
            $this->_data = $data;
            $this->register();
            $this->_view->generate($this->_returnData);
        } catch (Exception $e) {
            $this->_returnData = $this->msgErr(false,$e->getCode(),$e->getMessage());
            $this->_view->generate($this->_returnData); 
        }
    }

    /**
     * Connexion de l'utilisateur
     * 
     * @throws Exception
     */
    private function register() {
        $this->_manager = new UserManager();

        $user = $this->_manager->getUser(array(
            'email' => $this->_data->email
        ));

        // SI L'EMAIL EST DEJA UTILISE
        if (isset($user[0]) && !empty($user[0])):
            throw new Exception($this->_data->email.' - est déjà utilisé!', 422);
        endif;

        // AJOUTER UN NOUVEL UTILISATEUR
        $uniqueId = rand(time(), 1000000); // CREATION D'UN ID UNIQUE POUR L'UTILISATEUR
        $this->_manager->addUser(array(
            'id' => $uniqueId,
            'name' => htmlspecialchars(strip_tags(ucfirst(trim($this->_data->firstname)).' '.ucfirst(trim($this->_data->lastname)))),
            'email' => $this->_data->email,
            'password' => password_hash($this->_data->password, PASSWORD_DEFAULT),
            'online' => 1,
            'gender' => $this->_data->gender,
            'birthday' => date('Y-m-d H:i:s', $this->_data->birthday/1000),
        ));

        // CREATION DU TOKEN & EXPORTATION DES DONNEES
        $jwt = new JwtHandler();
        $token = $jwt->_jwt_encode_data(
            'http://localhost/backend/',
            array("user_id"=> $uniqueId)
        );

        // ENVOIE DES DONNEES 
        $this->_returnData = array(
            'success' => true,
            'status' => 200,
            'message' => 'Inscription réussie!',
            'token' => $token
        );
        
    }

    private $_data;
}