<?php
/**
 * Création de la classe band
 */
class band extends database {
    public $id;
    public $bandName;
    public $concertNumber;
    public $bandDescription;
    public $idCreator;
    
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
    public function createBand(){
        $query = 'INSERT INTO `15968k4_band`(`bandName`, `bandDescription`, `idCreator`, `concertNumber`) VALUES(:bandName, :bandDescription, :idCreator, 0)';
        $createBand = $this->db->prepare($query);
        $createBand->bindValue(':bandName', $this->bandName, PDO::PARAM_STR);
        $createBand->bindValue(':bandDescription', $this->bandDescription, PDO::PARAM_STR);
        $createBand->bindValue(':idCreator', $this->idCreator, PDO::PARAM_INT);
        return $createBand->execute();
    }
    /**
     * Méthode servant à savoir si le nom du groupe est déjà pris
     */
    public function notSameBandName(){
        $query = 'SELECT COUNT(`bandName`) AS `count` FROM `15968k4_band` '
                . 'WHERE `bandName` = :bandName';
        $check = $this->db->prepare($query);
        $check->bindValue(':bandName', $this->bandName, PDO::PARAM_STR);
        if($check->execute()){
            $result = $check->fetch(PDO::FETCH_OBJ);
            $bool = $result->count;
        }
        return $bool;
    }
    /**
     * Méthode servant à savoir si l'utilisateur a déjà un groupe dont il est le créateur
     */
    public function haveGroup(){
        $query = 'SELECT COUNT(`bandName`) AS `count` FROM `15968k4_band` '
                . 'WHERE `idCreator` = :id';
        $check = $this->db->prepare($query);
        $check->bindValue(':id', $this->id, PDO::PARAM_INT);
        if($check->execute()){
            $result = $check->fetch(PDO::FETCH_OBJ);
            $bool = $result->count;
        }
        return $bool;
    }
    public function showGroupCreated(){
        $query = 'SELECT `bandName`, `concertNumber`, `bandDescription`, `idCreator` FROM `15968k4_band` '
                . 'WHERE idCreator = :id';
        $result = $this->db->prepare($query);
        $result->bindValue(':id', $this->id, PDO::PARAM_INT);
        if ($result->execute()) {
            if (is_object($result)) {
                $isObject = $result->fetch(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
}