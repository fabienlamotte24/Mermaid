<?php
//Création de la classe type
class type extends database{
    //Listing des attributs
    public $id;
    public $type;
    /**
     * Méthode magique constructeur
     */
    public function __construct(){
        parent::__construct();
        $this->dbConnect();
    }
    /**
     * Méthode magique destructeur
     */
    public function __destruct(){
        ;
    }
}
?>