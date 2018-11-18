<?php

class typeInstrument extends database {
    public $id;
    public $instrument;
    /**
     * Méthode magique constructeur
     */
    public function __construct() {
        parent::__construct();
        $this->dbConnect();
    }
    /**
     * Méthode permettant de lister les instruments stockés en BDD
     */
    public function showListOfInstruments(){
        $query = 'SELECT `id`, `instrument` FROM `15968k4_typeInstrument`';
        $result = $this->db->query($query);
        if($result->execute()){
            if(is_object($result)){
                $isObject = $result->fetchAll(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
}

