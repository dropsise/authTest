<?php
require_once './views/View.php';
require_once './models/UserManager.php';

/**
 * Controlleur Register, permet de s'inscrire dans l'application.
 * 
 * PHP version 5
 * 
 * @category Authentication
 * @package  controllers
 * @author   Georgy Guei <gettien98@gmail.com>
 */
class ControllerRegister
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
            $this->register();
            // Générer la vue
            $this->_view->generate($this->_returnData);
        } catch (Exception $e) {
            $this->_returnData = $this->msgErr($e->getMessage(), $data);
            // Générer la vue
            $this->_view->generate($this->_returnData); 
        }
    }

    /**
     * Inscription de l'utilisateur.
     * 
     * @throws Exception
     */
    private function register() {
        // Instance de gestionnaire de model pour `Utilisateur`
        $this->_manager = new UserManager();

        // Récuperer les données de l'utilisateur depuis la base de donnée via son email
        $user = $this->_manager->getUser($this->_data->email);

        // Si l'email est déjà utilisé alors échec de l'opération
        if (isset($user) && !empty($user)):
            throw new Exception($this->_data->email.' - est déjà utilisé!', 422);
        endif;

        // Ajouter un nouvel utilisateur
        $uniqueId = rand(time(), 1000000); // création d'un id unique pour l'utilisateur
        $this->_manager->addUser(
            $uniqueId,
            htmlspecialchars(strip_tags(ucfirst(strtolower(trim($this->_data->firstname))).' '.ucfirst(strtolower(trim($this->_data->lastname))))),
            $this->_data->email,
            password_hash($this->_data->password, PASSWORD_DEFAULT),
            $this->_data->gender,
            $this->_data->birthdate
        );

        // Envoie des données
        $this->_returnData = array(
            'success' => true,
            'status' => 200,
            'message' => json_encode([
                'Inscription réussie!',
                $this->_manager->getUser($this->_data->email)
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
        if (!isset($data->firstname) || empty(trim($data->firstname))):
            throw new Exception('Veillez renseigner votre prénom!', 422);
        elseif (!isset($data->lastname) || empty(trim($data->lastname))):
            throw new Exception('Veillez renseigner votre nom!', 422);
        elseif (!isset($data->email) || empty(trim($data->email))):
            throw new Exception('Veillez renseigner votre e-mail!', 422);
        elseif (!isset($data->email_check) || empty(trim($data->email_check))):
            throw new Exception('L\'e-mail de confirmation est incorrect!', 422);
        elseif (!isset($data->password) || empty(trim($data->password))):
            throw new Exception('Veillez renseigner votre mot de passe!', 422);
        elseif (!isset($data->birthdate) || empty(trim($data->birthdate))):
            throw new Exception('Veillez renseigner votre date de naissance!', 422);
        elseif (!isset($data->gender) || empty(trim($data->gender))):
            throw new Exception('Veillez renseigner votre sexe!', 422);
        endif;

        $firstname = trim($data->firstname);
        $lastname = trim($data->lastname);
        $email = trim($data->email);
        $email_check = trim($data->email_check);
        $password = trim($data->password);

        // Quelques expressions régulières pour effectuer des tests de validation
        $name_pattern = "/[0-9!@#$%^&*()_+\-=\[\]{};':\"\\|,.<>\/?]+/";
        $email_pattern = "/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/";
        $password_pattern = "/.{4,}$/";
        $tel_pattern = "/^[0-9]{10}$/";

        // vérification du prénom (longueur entre 3 et 8)
        if (strlen($firstname) < 3 || strlen($firstname) > 8):
            throw new Exception('Votre prénom doit contenir entre 3 et 8 caractères!', 422);
        // vérification du prénom (format : alphabétique)
        elseif (preg_match($name_pattern, $firstname) != 0):
            throw new Exception('Votre prénom doit être alphabétique!');
        // vérification du nom (longueur entre 3 et 8)
        elseif (strlen($lastname) < 3 || strlen($lastname) > 8):
            throw new Exception('Votre nom doit contenir entre 3 et 8 caractères!', 422);
        // vérification du nom (format : alphabétique)
        elseif (preg_match($name_pattern, $lastname) != 0):
            throw new Exception('Votre nom doit être alphabétique!');
        // Vérification du format du numéro de téléphone (10 chiffres)
        elseif (preg_match($tel_pattern, $email) == 0):
            // Vérification du format de l'email
            if (preg_match($email_pattern, $email) == 0):
                throw new Exception($email.' - n\'est pas un email valide!', 422);
            endif;
        // Vérification de la confirmation de l'email
        elseif ($email != $email_check):
            throw new Exception('L\'e-mail de confirmation est incorrect!', 422);
        // vérification du mot de passe (longueur > 4)
        elseif (preg_match($password_pattern, $password) == 0):
            throw new Exception('Votre mot de passe doit contenir au moins 4 caractères', 422);
        endif;
    }

    /**
     * Générer un message d'erreur
     * 
     * @param int    $success le succès
     * @param int    $status le status
     * @param string $message le message
     * @param array  $data les données
     * 
     * @return array Un tableau qui représent les données à générer
     */
    private function msgErr($message, $data) {
        return array(
            'message' => $message,
            'register' => $data
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



    