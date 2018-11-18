<?php

/**
 * Création de la classe notification
 */

class proPhotos extends database{
    public $id;
    public $proPhotos;
    public $id_15968k4_establishment;
    
    /**
     * Méthode magique constructeur
     */
    public function __construct() {
        parent::__construct();
        $this->dbConnect();
    }
    
    /**
     * Méthode d'ajout de photo
     */
    public function addProPhoto(){
        $query = 'INSERT INTO `15968k4_proPhotos`(`proPhotos`, `id_15968k4_establishment`) '
                . 'VALUES(:proPhotos, :id_15968k4_establishment)';
        $addProPhoto = $this->db->prepare($query);
        $addProPhoto->bindValue(':proPhotos', $this->proPhotos, PDO::PARAM_STR);
        $addProPhoto->bindValue(':id_15968k4_establishment', $this->id_15968k4_establishment, PDO::PARAM_INT);
        return $addProPhoto->execute();
    }
    /**
     * Méthode d'affichage des photos
     */
    public function showProPhotos(){
        $query = 'SELECT `proPhotos`, `id` FROM `15968k4_proPhotos` '
                . 'WHERE `id_15968k4_establishment` = :id_15968k4_establishment';
        $showProPhotos = $this->db->prepare($query);
        $showProPhotos->bindValue(':id_15968k4_establishment', $this->id_15968k4_establishment, PDO::PARAM_INT);
        if($showProPhotos->execute()){
            if(is_object($showProPhotos)){
                $isObject = $showProPhotos->fetchAll(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
    /**
     * Méthode de compte de photo 
     */
    public function countPhotos(){
        $bool = FALSE;
        $query = 'SELECT COUNT(`proPhotos`) AS `count` FROM `15968k4_proPhotos` '
                . 'WHERE `id_15968k4_establishment` = :id_15968k4_establishment';
        $countPhoto = $this->db->prepare($query);
        $countPhoto->bindValue(':id_15968k4_establishment', $this->id_15968k4_establishment, PDO::PARAM_INT);
        if($countPhoto->execute()){
            $result = $countPhoto->fetch(PDO::FETCH_OBJ);
            $bool = $result->count;
        }
        return $bool;
    }
    /**
     * Méthode de suppression de photo
     */
    public function removePhotos(){
        $query = 'DELETE FROM `15968k4_proPhotos` '
                . 'WHERE `id` = :id';
        $removePhotos = $this->db->prepare($query);
        $removePhotos->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $removePhotos->execute();
    }
}
