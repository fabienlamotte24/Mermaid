<?php

/**
 * Création de la classe band
 */
class band extends database {

    public $id;
    public $bandName = '';
    public $concertNumber = 0;
    public $bandDescription = '';
    public $idCreator = 0;
    public $bandPicture = '';

    /**
     * Création de la méthode magique constructeur
     */
    public function __construct() {
        parent::__construct();
        $this->dbConnect();
    }

    /**
     * Méthode servant à la création d'un groupe de musique
     */
    public function createBand() {
        $query = 'INSERT INTO `15968k4_band`(`bandName`, `bandDescription`, `idCreator`, `concertNumber`, `$bandPicture`) '
                . 'VALUES(:bandName, :bandDescription, :idCreator, 0, "")';
        $createBand = $this->db->prepare($query);
        $createBand->bindValue(':bandName', $this->bandName, PDO::PARAM_STR);
        $createBand->bindValue(':bandDescription', $this->bandDescription, PDO::PARAM_STR);
        $createBand->bindValue(':idCreator', $this->idCreator, PDO::PARAM_INT);
        return $createBand->execute();
    }

    /**
     * Méthode servant à savoir si le nom du groupe est déjà pris
     */
    public function notSameBandName() {
        $query = 'SELECT COUNT(`bandName`) AS `count` FROM `15968k4_band` '
                . 'WHERE `bandName` = :bandName';
        $check = $this->db->prepare($query);
        $check->bindValue(':bandName', $this->bandName, PDO::PARAM_STR);
        if ($check->execute()) {
            $result = $check->fetch(PDO::FETCH_OBJ);
            $bool = $result->count;
        }
        return $bool;
    }

    /**
     * Méthode servant à savoir si l'utilisateur a déjà un groupe dont il est le créateur
     */
    public function haveGroup() {
        $query = 'SELECT COUNT(`bandName`) AS `count` FROM `15968k4_band` '
                . 'WHERE `idCreator` = :idCreator';
        $check = $this->db->prepare($query);
        $check->bindValue(':idCreator', $this->idCreator, PDO::PARAM_INT);
        if ($check->execute()) {
            $result = $check->fetch(PDO::FETCH_OBJ);
            $bool = $result->count;
        }
        return $bool;
    }
    /**
     * Méthode servant à afficher les informations du groupe
     * @return type
     */
    public function showGroupCreated() {
        $query = 'SELECT `bandName`, `concertNumber`, `bandDescription`, `idCreator`, `bandPicture` FROM `15968k4_band` '
                . 'WHERE idCreator = :idCreator';
        $result = $this->db->prepare($query);
        $result->bindValue(':idCreator', $this->idCreator, PDO::PARAM_INT);
        if ($result->execute()) {
            if (is_object($result)) {
                $isObject = $result->fetch(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
    /**
     * Méthode servant à retrouver l'id du groupe en fonction de l'utilisateur
     */
    public function idFind(){
        $query = 'SELECT `id` FROM `15968k4_band` '
                . 'WHERE idCreator = :idCreator';
        $idFinding = $this->db->prepare($query);
        $idFinding->bindValue('idCreator', $this->idCreator, PDO::PARAM_INT);
        if ($idFinding->execute()) {
            if (is_object($idFinding)) {
                $isObject = $idFinding->fetch(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
    /**
     * Méthode servant à supprimer le compte
     */
    public function removeBand(){
        $query = 'DELETE FROM `15968k4_band` WHERE `id` = :id';
        $removeBand = $this->db->prepare($query);
        $removeBand->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $removeBand->execute();
    }
    /**
     * Méthode servant à modifier la photo du groupe
     */
    public function modifyPhoto(){
        $query = 'UPDATE `15968k4_band` '
                . 'SET `bandPicture` = :bandPicture '
                . 'WHERE `idCreator` = :idCreator';
        $modifyPhoto = $this->db->prepare($query);
        $modifyPhoto->bindValue(':bandPicture', $this->bandPicture, PDO::PARAM_STR);
        $modifyPhoto->bindValue(':idCreator', $this->idCreator, PDO::PARAM_INT);
        return $modifyPhoto->execute();
    }
}
