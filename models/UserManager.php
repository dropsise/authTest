<?php
require_once './models/Model.php';
require_once './models/User.php';

/**
 * User Manager, permet de gérer les requêtes sur la table User.
 * 
 * PHP version 5
 * 
 * @category Managment
 * @package  models
 * @author   Georgy Guei <gettien98@gmail.com>
 */
class UserManager extends Model {
    /**
     * Récuperer les données d'un utilisateur via son email.
     * 
     * @param string $email L'email de l'utilisateur.
     * 
     * @return User Un Objet utilisateur.
     * 
     * @throws Exception Echec de la requête.
     */
    public function getUser($email) {
        try {
            // Connexion à la base de donnée
            $db = $this->getDB();
            // REQUETE SQL
            $sql = 'SELECT * FROM users WHERE email=:email LIMIT 1';
            // Préparation de la requête SQL
            $query = $db->prepare($sql);
            $query->bindValue(':email', $email);
            // Exécution de la requête SQL
            $query->execute();
            // Récuperation des données
            if ($query->rowCount()):
                while ($res = $query->fetch(PDO::FETCH_ASSOC)):
                    $data = new User($res);
                endwhile;
                $query->closeCursor();
                return $data;
            else:
                return null;
            endif;
        } catch (PDOException $e) {
            throw new Exception('Echec de SELECT : '.$e->getMessage(), 500);
        }
    }

    /**
     * Ajouter un nouvel utilisateur.
     * 
     * @param int $id L'identifiant de l'utilisateur.
     * @param string $name Le nom de l'utilisateur.
     * @param string $email L'email de l'utilisateur.
     * @param string $password Le mot de passe de l'utilisateur.
     * @param int $gender Le sexe de l'utilisateur.
     * @param date $birthdate La date de naissance de l'utilisateur.
     * 
     * @throws PDOException  Echec de la requête.
     */
    public function addUser($id,$name,$email,$password,$gender,$birthdate) {
        try {
            // Connexion à la base de donnée
            $db = $this->getDB();
            // REQUETE SQL
            $sql = 'INSERT INTO users (id,name,email,password,gender,birthdate)
                    VALUES (:id,:name,:email,:password,:gender,:birthdate)';
            // Préparation de la requête SQL
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->bindValue(':name', $name);
            $query->bindValue(':email', $email);
            $query->bindValue(':password', $password);
            $query->bindValue(':gender', $gender);
            $query->bindValue(':birthdate', $birthdate);
            // Exécution de la requête SQL
            $query->execute();
        } catch (PDOException $e) {
            throw new Exception('Echec de INSERT : '.$e->getMessage(), 500);
        }
    }

}