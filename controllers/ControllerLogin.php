<?php
require_once './views/View.php';
require_once './models/UserManager.php';

/**
 * Controlleur Login, permet de se connecteur à l'application.
 * 
 * PHP version 5
 * 
 * @category Authentication
 * @package  controllers
 * @author   Georgy Guei <gettien98@gmail.com>
 */
class ControllerLogin
{
    /**
     * Constructeur
     * 
     * @param array $url L'URL de la page
     * 
     * @throws Exception
     * 
     * @uses login
     * @uses msgErr
     */
    public function __construct($url) {
        try {
            $this->_view = new View('Connexion');
            // Si la méthode de requête est différente de POST
            if ($_SERVER['REQUEST_METHOD'] != 'POST'):
                throw new Exception('Page Introuvable', 404);
            endif;
            // Récupération des données issues du formulaire de connexion
            $data = (object) $_POST; // données de type object(stdClass)
            // Vérification des données saisies par l'utilisateur
            $this->verrifyEntry($data);
            // L'utilisateur peut se connecter
            $this->_data = $data;
            $this->login();
            // Générer la vue
            $this->_view->generate($this->_returnData);
        } catch (Exception $e) {
            $this->_returnData = $this->msgErr($e->getMessage(), $data);
            // Générer la vue
            $this->_view->generate($this->_returnData); 
        }
    }

    /**
     * Connexion de l'utilisateur
     * 
     * @throws Exception
     */
    private function login() {
        // Instance de gestionnaire de model pour `Utilisateur`
        $this->_manager = new UserManager();

        // Récuperer les données de l'utilisateur depuis la base de donnée via son email
        $user = $this->_manager->getUser($this->_data->email);

        // Si l'email ne correspond à aucun utilisateur alors échec de l'opération
        if (!isset($user) || empty($user)):
            throw new Exception('E-mail (et/ou) Mot de passe invalide(s)!', 422);
        endif;
        $user = $user;

        // vérification du mot de passe
        $passwordVerify = password_verify($this->_data->password, $user->password());
        if (!$passwordVerify):
            throw new Exception('E-mail (et/ou) Mot de passe invalide(s)!', 422);
        endif;

        // Envoie des données
        $this->_returnData = array(
            'success' => true,
            'status' => 200,
            'message' => json_encode([
                'Connexion réussie!',
                $user
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );
    }

    /**
     * Vérifier les données saisies par l'utilisateur
     * 
     * @param object $data Les données renseignées par l'utilisateur
     * 
     * @throws Exception
     */
    private function verrifyEntry($data) {
        if (!isset($data->email) || empty(trim($data->email))):
            throw new Exception('Veillez renseigner votre e-mail!', 422);
        elseif (!isset($data->password) || empty(trim($data->password))):
            throw new Exception('Veillez renseigner votre mot de passe!', 422);
        endif;

        $email = trim($data->email);
        $password = trim($data->password);

        // Quelques expressions régulières pour effectuer des tests de validation
        $email_pattern = "/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/";
        $password_pattern = "/.{4}$/";
        $tel_pattern = "/^[0-9]{10}$/";
        
        // Vérification du format du numéro de téléphone (10 chiffres) et du format de l'email
        elseif (preg_match($tel_pattern, $email) == 0 && preg_match($email_pattern, $email) == 0):
            throw new Exception($email.' - n\'est pas un email valide!', 422);
        // vérification du mot de passe (longueur > 4)
        elseif (preg_match($password_pattern, $password) == 0):
            throw new Exception('Votre mot de passe doit contenir au moins 4 caractères', 422);
        endif;
    }

    /**
     * Générer un message d'erreur.
     * 
     * @param int    $success le succès
     * @param int    $status le status
     * @param string $message le message
     * @param array  $data les données
     * 
     * @return array Un tableau qui représent les données à afficher
     */
    protected function msgErr($message, $data) {
        return array(
            'message' => $message,
            'login' => $data
        );
    }

    // Les données de l'utilisateur
    private $_data;
    // Les données renvoyées
    private $_returnData;
    // Le gestionnaire de model
    private $_manager;
    // La vue
    private $_view;
}