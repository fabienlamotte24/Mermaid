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
    /**
     * Méthode servant à ajouter des photos
     */
    public function addPhotos(){
        $query = 'INSERT INTO `15968k4_bandPhotos`(`bandPhotos`, `id_15968k4_band`) '
                . 'VALUES(:bandPhotos, :id_15968k4_band)';
        $addPhotos = $this->db->prepare($query);
        $addPhotos->bindValue(':bandPhotos', $this->bandPhotos, PDO::PARAM_STR);
        $addPhotos->bindValue(':id_15968k4_band', $this->id_15968k4_band, PDO::PARAM_INT);
        return $addPhotos->execute();
    }
    /**
     * Méthode servant à afficher les photos
     */
    public function showPhotos(){
        $query = 'SELECT `bandPhotos`, `id` FROM `15968k4_bandPhotos` '
                . 'WHERE `id_15968k4_band` = :id_15968k4_band ';
        $showPhoto = $this->db->prepare($query);
        $showPhoto->bindValue(':id_15968k4_band', $this->id_15968k4_band, PDO::PARAM_INT);
        if($showPhoto->execute()){
            if(is_object($showPhoto)){
                $isObject = $showPhoto->fetchAll(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
    /**
     * Méthode servant à compter le nombre de photos
     */
    public function countPhotos(){
        $bool = FALSE;
        $query = 'SELECT COUNT(`bandPhotos`) AS `count` FROM `15968k4_bandPhotos` '
                . 'WHERE `id_15968k4_band` = :id_15968k4_band';
        $countPhotos = $this->db->prepare($query);
        $countPhotos->bindValue(':id_15968k4_band', $this->id_15968k4_band, PDO::PARAM_INT);
        if($countPhotos->execute()){
            $result = $countPhotos->fetch(PDO::FETCH_OBJ);
            $bool = $result->count;
        }
        return $bool;
    }
    /**
     * Méthode de suppression de photo
     */
    public function removePhoto(){
        $query = 'DELETE FROM `15968k4_bandPhotos` '
                . 'WHERE `id` = :id';
        $remove = $this->db->prepare($query);
        $remove->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $remove->execute();
    }
}

