<?php

//Création de la classe cities
class cities extends database {
    //Listing des attributs
    public $id;
    public $postalCode;
    public $city;
    
    /**
     * Méthode magique constructeur
     */
    public function __construct(){
        parent::__construct();
        $this->dbConnect();
    }
    /**
     * Méthode pour afficher la liste des codes postaux
     */
    public function postalCodeList(){
        $query = "SELECT `id`, `postalCode`, `city` FROM `15968k4_cities` WHERE `postalCode` LIKE :postalCode ORDER BY `city` ASC";
        $postaleResearch = $this->db->prepare($query);
        $postaleResearch->bindValue(':postalCode', $this->postalCode . '%', PDO::PARAM_STR);
        if($postaleResearch->execute()){
            if(is_object($postaleResearch)){
                $result = $postaleResearch->fetchAll(PDO::FETCH_OBJ);
            }
        }
        return $result;
    }
    /**
     * Méthode magique destructeur
     */
    public function __destruct(){
        ;
    }
}
?>