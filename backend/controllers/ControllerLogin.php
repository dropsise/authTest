<?php
require_once './tokens/middlewares/Auth.php';
require_once './controllers/Controller.php';

/**
 * Controlleur Login, permet de se connecteur à l'application.
 * 
 * PHP version 5
 * 
 * @category Authentication
 * @package  controllers
 * @author   Georgy Guei <gettien98@gmail.com>
 */
class ControllerLogin extends Controller
{
    /**
     * Constructeur
     * 
     * @param array $url L'URL de la page
     * 
     * @throws Exception
     * 
     * @uses hydrate
     * @uses login
     * @uses msgErr
     */
    public function __construct($url) {
        parent::__construct();
        // Setup request to send json via POST        
        try {
            // Takes raw data from the request
            $json = file_get_contents('php://input');
            // Converts it into a PHP StdClass
            $data = json_decode($json);
            // SI LA REQUEST METHOD EST DIFFERENTE DE POST
            if ($_SERVER['REQUEST_METHOD'] != 'POST'):
                throw new Exception('Page Introuvable', 404);
            else:
                
            endif;
            // L'UTILISATEUR PEUT SE CONNECTER
            $this->_data = $data;
            $this->login();
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
    private function login() {
        $this->_manager = new UserManager();

        // RECUPERER L'UTILISATEUR VIA SON EMAIL
        $user = $this->_manager->getUser(array(
            'email' => $this->_data->email,
        ));

        // SI L'EMAIL OU MOT DE PASSE NE CORRESPONDENT A AUCUN UTILISATEUR
        if (!isset($user) || empty($user[0])):
            throw new Exception('E-mail (et/ou) Mot de passe invalide(s)!', 422);
        endif;
        $user = $user[0];

        // VERIFICATION DU MOT DE PASSE
        $passwordVerify = password_verify($this->_data->password, $user->password());
        if (!$passwordVerify):
            throw new Exception('E-mail (et/ou) Mot de passe invalide(s)!', 422);
        endif;

        // CREATION DU TOKEN & EXPORTATION DES DONNEES
        $jwt = new JwtHandler();
        $token = $jwt->_jwt_encode_data(
            'http://localhost/backend/',
            array("user_id"=> $user->id())
        );

        // ENVOIE DES DONNEES 
        $this->_returnData = array(
            'success' => true,
            'status' => 200,
            'message' => 'Connexion réussie!',
            'token' => $token
        );
        
    }

    private $_data;
}