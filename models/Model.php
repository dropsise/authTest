<?php

/**
 * Le Model de la base de donnée.
 * 
 * PHP version 5
 * 
 * @category Authentication
 * @package  controllers
 * @author   Georgy Guei <gettien98@gmail.com>
 */
abstract class Model {

    /**
     * Etablit la connexion à la base de donnée
     * 
     * @throws PDOException  Echec de connexion
     */
    private static function setDB() {
        $hostname = "localhost";	
        $base= "testStage";
        $loginDB= "root";	
        $passDB="root";

        try {
            // DSN (Data Source Name) pour se connecter à MySQL
            $dsn = "mysql:server=$hostname ; dbname=$base";
            self::$_db = new PDO ($dsn, $loginDB, $passDB,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            // Le dernier argument sert à ce que toutes les chaines de caractères 
            // en entrée et sortie de MySql soit dans le codage UTF-8
            
            // On active le mode d'affichage des erreurs, et le lancement d'exception en cas d'erreur
            self::$_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            throw new Exception('Echec de connexion : '.$e->getMessage(), 500);
        }
    }

    /**
     * Récuperer la connexion à la base de donnée
     * 
     * @return PDO $_db une instance de PDO
     */
    protected function getDB() {
        if (!isset(self::$_db)):
            self::setDB();
        endif;
        return self::$_db;
    }

    // La base de donnée
    private static $_db;
    
}
