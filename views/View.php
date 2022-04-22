<?php

class View
{
    // CONSTRUCTEUR
    public function __construct($section=null) {
        if (isset($section)):
            $this->_file = './views/view'.$section.'.php';
        endif;
    }
    // GENERER ET AFFICHER LA VUE
    public function generate($data=array()) {
        // Création de la vue
        $view = $this->generateFile($data);
        echo $view;
    }

    // GENERER UN FICHIER VUE
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