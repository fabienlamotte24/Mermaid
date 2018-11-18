<?php

class instrument extends database {
    public $id;
    public $id_15968k4_typeInstrument;
    public $id_15968k4_users;
    /**
     * Méthode magique constructeur
     */
    public function __construct() {
        parent::__construct();
        $this->dbConnect();
    }
    /**
     * Méthode d'insertion de donnée suite au formulaire
     */
    public function addInstrumentPlayer(){
        $query = 'INSERT INTO `15968k4_instrument`(`id_15968k4_typeInstrument`, `id_15968k4_users`) '
                . 'VALUES (:id_15968k4_typeInstrument, :id_15968k4_users)';
        $result = $this->db->prepare($query);
        $result->bindValue(':id_15968k4_typeInstrument', $this->id_15968k4_typeInstrument, PDO::PARAM_INT);
        $result->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        return $result->execute();
    }
    /**
     * Méthode de changement d'instrument
     */
    public function changeInstrument(){
        $query = 'UPDATE `15968k4_instrument` '
                . 'SET `id_15968k4_typeInstrument` = :id_15968k4_typeInstrument '
                . 'WHERE `id_15968k4_users` = :id_15968k4_users';
        $result = $this->db->prepare($query);
        $result->bindValue(':id_15968k4_typeInstrument', $this->id_15968k4_typeInstrument, PDO::PARAM_INT);
        $result->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        return $result->execute();
    }
    /**
     * Méthode pour savoir si l'utilisateur a déjà choisi son rôle
     * @return type
     */
    public function isPlayInstrument(){
        $bool = FALSE;
        $query = 'SELECT COUNT(`id`) AS `count` FROM `15968k4_instrument` '
                . 'WHERE id_15968k4_users = id_15968k4_users';
        $result = $this->db->prepare($query);
        $result->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        if($result->execute()){
            $check = $result->fetch(PDO::FETCH_OBJ);
            $bool = $check->count;
        }
        return $bool;
    }
    /**
     * Méthode pour afficher le rôle de l'utilisateur
     */
    public function showHisRole(){
        $query = 'SELECT `t`.`instrument`, `i`.`id_15968k4_typeInstrument` FROM `15968k4_instrument` AS `i` INNER JOIN `15968k4_typeInstrument` AS `t` ON `i`.`id_15968k4_typeInstrument` = `t`.`id` WHERE `i`.`id_15968k4_users` = :id_15968k4_users';
        $result = $this->db->prepare($query);
        $result->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        if($result->execute()){
            if(is_object($result)){
                $isObject = $result->fetch(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
}

