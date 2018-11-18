<?php

/**
 * Création de la classe band
 */
class band extends database {

    public $id;
    public $bandName;
    public $bandDescription;
    public $idCreator;
    public $bandPicture;

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
        $query = 'INSERT INTO `15968k4_band`(`bandName`, `bandDescription`, `idCreator`, `bandPicture`) '
                . 'VALUES(:bandName, :bandDescription, :idCreator, :bandPicture)';
        $createBand = $this->db->prepare($query);
        $createBand->bindValue(':bandName', $this->bandName, PDO::PARAM_STR);
        $createBand->bindValue(':bandDescription', $this->bandDescription, PDO::PARAM_STR);
        $createBand->bindValue(':idCreator', $this->idCreator, PDO::PARAM_INT);
        $createBand->bindValue(':bandPicture', $this->bandPicture, PDO::PARAM_STR);
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
        $bool = FALSE;
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
     * Méthode servant à lister tout les groupes de musique
     */
    public function showAllBand() {
        $query = "SELECT `id`, `bandName`, `bandDescription`, `idCreator`, `bandPicture` FROM `15968k4_band`";
        $showAll = $this->db->query($query);
        if ($showAll->execute()) {
            if (is_object($showAll)) {
                $isObject = $showAll->fetchAll(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }

    /**
     * Méthode servant à afficher les informations du groupe
     * @return type
     */
    public function showGroupCreated() {
        $query = 'SELECT `bd`.`id`, `bd`.`bandName`, `bd`.`idCreator`, `bd`.`bandDescription`, `bd`.`bandPicture`, `res`.`research`
                FROM `15968k4_band` AS `bd` 
                LEFT JOIN `15968k4_bandInResearch` AS `res`
                ON `bd`.`id` = `res`.`id_15968k4_band`
                WHERE `bd`.`idCreator` = :idCreator';
        $result = $this->db->prepare($query);
        $result->bindValue(':idCreator', $this->idCreator, PDO::PARAM_INT);
        if ($result->execute()) {
            if (is_object($result)) {
                $isObject = $result->fetchAll(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
    /**
     * Méthode servant à afficher les informations du groupe
     * @return type
     */
    public function showGroupByUrl() {
        $query = 'SELECT `bd`.`id`, `bd`.`bandName`, `bd`.`idCreator`, `bd`.`bandDescription`, `bd`.`bandPicture`, `res`.`research`
                FROM `15968k4_band` AS `bd` 
                LEFT JOIN `15968k4_bandInResearch` AS `res`
                ON `bd`.`id` = `res`.`id_15968k4_band`
                WHERE `bd`.`id` = :id';
        $result = $this->db->prepare($query);
        $result->bindValue(':id', $this->id, PDO::PARAM_INT);
        if ($result->execute()) {
            if (is_object($result)) {
                $isObject = $result->fetch(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
    /**
     * Méthode servant à lister les groupes créés par l'utilisateur par leur id
     */
    public function listBandId(){
        $query = 'SELECT `id` FROM `15968k4_band` '
                . 'WHERE `idCreator` = :idCreator';
        $result = $this->db->prepare($query);
        $result->bindValue(':idCreator', $this->idCreator, PDO::PARAM_INT);
        if ($result->execute()) {
            if (is_object($result)) {
                $isObject = $result->fetchAll(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
    /**
     * Méthode servant à supprimer le compte
     */
    public function removeBand() {
        $query = 'DELETE FROM `15968k4_band` WHERE `id` = :id';
        $removeBand = $this->db->prepare($query);
        $removeBand->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $removeBand->execute();
    }

    /**
     * Méthode servant à modifier la photo du groupe
     */
    public function modifyPhoto() {
        $query = 'UPDATE `15968k4_band` '
                . 'SET `bandPicture` = :bandPicture '
                . 'WHERE `idCreator` = :idCreator';
        $modifyPhoto = $this->db->prepare($query);
        $modifyPhoto->bindValue(':bandPicture', $this->bandPicture, PDO::PARAM_STR);
        $modifyPhoto->bindValue(':idCreator', $this->idCreator, PDO::PARAM_INT);
        return $modifyPhoto->execute();
    }

    /**
     * Méthode servant à modifier le nom du groupe
     */
    public function modifyBandName() {
        $query = 'UPDATE `15968k4_band` '
                . 'SET `bandName` = :bandName '
                . 'WHERE `idCreator` = :idCreator';
        $modifyPhoto = $this->db->prepare($query);
        $modifyPhoto->bindValue(':bandName', $this->bandName, PDO::PARAM_STR);
        $modifyPhoto->bindValue(':idCreator', $this->idCreator, PDO::PARAM_INT);
        return $modifyPhoto->execute();
    }

    /**
     * Méthode servant à modifier la présentation du groupe
     */
    public function modifyBandDescription() {
        $query = 'UPDATE `15968k4_band` '
                . 'SET `bandDescription` = :bandDescription '
                . 'WHERE `idCreator` = :idCreator';
        $modifyPhoto = $this->db->prepare($query);
        $modifyPhoto->bindValue(':bandDescription', $this->bandDescription, PDO::PARAM_STR);
        $modifyPhoto->bindValue(':idCreator', $this->idCreator, PDO::PARAM_INT);
        return $modifyPhoto->execute();
    }

    /**
     * Méthode servant à retrouver l'id
     */
    public function idFind() {
        $query = 'SELECT `id` FROM `15968k4_band` '
                . 'WHERE `idCreator` = :idCreator';
        $idFinding = $this->db->prepare($query);
        $idFinding->bindValue(':idCreator', $this->idCreator, PDO::PARAM_INT);
        if ($idFinding->execute()) {
            if (is_object($idFinding)) {
                $isObject = $idFinding->fetch(PDO::FETCH_OBJ);
                $this->id = $isObject->id;
            }
        }
        return $isObject;
    }
    /**
     * Méthode servant à changer toute les informations du groupe de musique
     */
    public function changeAllDetailsBand(){
        $query = 'UPDATE `15968k4_band` '
                . 'SET `bandName` = :bandName, '
                . '`bandPicture` = :bandPicture, '
                . '`bandDescription` = :bandDescription '
                . 'WHERE `id` = :id';
        $result = $this->db->prepare($query);
        $result->bindValue(':bandName', $this->bandName, PDO::PARAM_STR);
        $result->bindValue(':bandPicture', $this->bandPicture, PDO::PARAM_STR);
        $result->bindValue(':bandDescription', $this->bandDescription, PDO::PARAM_STR);
        $result->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $result->execute();
    }
}
