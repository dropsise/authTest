<?php

class View
{
    // CONSTRUCTEUR
    public function __construct($section=null) {
        if (isset($section)):
            $this->_file = 'views/view'.$section.'.php';
        endif;
    }
    // GENERER ET AFFICHER LA VUE
    public function generate($data) {
        //http_response_code($data['status']);
        // CREATION DE LA VUE
        // if (!isset($data['message'])):
        //     $data = $this->generateFile($data);
        // endif;
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); 
    }

    // GENERER UN FICHIER VUE
    private function generateFile($data) {
        if (file_exists($this->_file)):
            // IMPORTATION DES DONNEES PASSEES EN PARAMETRE DANS LE FICHIER VUE 
            extract($data);
            // MISE EN TEMPON
            ob_start();
            require_once $this->_file;
            return ob_get_clean();
            // FIN DE LA TEMPORISATION
        else:
            throw new Exception('Page introuvable', 404);
        endif;
    }

    private $_file;
    private $_title;

}