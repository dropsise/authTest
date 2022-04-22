<?php

/**
 * La vue permet d'afficher un rendu de la page
 * 
 * PHP version 5
 * 
 * @category Vue
 * @package  views
 * @author   Georgy Guei <gettien98@gmail.com>
 */
class View
{
    /**
     * Constructeur
     */
    public function __construct($section=null) {
        if (isset($section)):
            $this->_file = './views/view'.$section.'.php';
        endif;
    }
    /**
     * Générer et afficher la vue
     * 
     * @param array $data Les données à ajouter au fichier généré
     * 
     * @throws Exception
     */
    public function generate($data=array()) {
        // Création de la vue
        $view = $this->generateFile($data);
        echo $view;
    }

    /**
     * Générer un fichier vue avec des données
     * 
     * @param array $data Les données à ajouter au fichier généré
     * 
     * @return string un fichier vue
     * 
     * @throws Exception
     */
    private function generateFile($data) {
        if (file_exists($this->_file)):
            // Importer les données passées en paramètre dans le fichier vue
            extract($data);
            // Mise en tempon
            ob_start();
            require_once $this->_file;
            return ob_get_clean();
            // Fin de la temporisation
        else:
            throw new Exception('Page introuvable', 404);
        endif;
    }

    // Le fichier vue
    private $_file;

}