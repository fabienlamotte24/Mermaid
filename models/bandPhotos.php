<?php

/**
 * Création de la classe band
 */
class bandPhotos extends database {
    public $id;
    public $bandPhotos;
    public $id_15968k4_band;
    
    /**
     * Création de la méthode magique constructeur
     */
    public function __construct() {
        parent::__construct();
        $this->dbConnect();
    }
}

