<?php

class messages extends database{
    public $id;
    public $title;
    public $idReceiver;
    public $dateHour;
    public $content;
    public $id_15968k4_users;
    /**
     * Création de la méthode magique constructeur
     */
    public function __construct() {
        parent::__construct();
        $this->dbConnect();
    }
    /**
     * Methode servant à connaître le nombre de message que possède un utilisateur
     */
    public function countMessages(){
        $query = 'SELECT COUNT(`id`) AS `count` FROM `15968k4_messages` '
                . 'WHERE `idReceiver` = :idReceiver';
        $result = $this->db->prepare($query);
        $result->bindValue(':idReceiver', $this->idReceiver, PDO::PARAM_INT);
        if($result->execute()){
            $check = $result->fetch(PDO::FETCH_OBJ);
            $bool = $check->count;
        }
        return $bool;
    }
    /**
     * Méthode servant à afficher les messages dont l'utilisateur est le destinataire
     */
    public function messageReceived(){
        $query = 'SELECT `mess`.`id`, `mess`.`title`, `mess`.`idReceiver`, DATE_FORMAT(`mess`.`dateHour`, \'%d/%m/%Y\') AS `date`, DATE_FORMAT(`mess`.`dateHour`,  \'%Hh%i\') AS `hour`, `mess`.`content`, `us`.`pseudo` '
                . 'FROM `15968k4_messages` AS `mess` '
                . 'LEFT JOIN `15968k4_users` AS `us` '
                . 'ON `mess`.`id_15968k4_users` = `us`.`id` '
                . 'WHERE `mess`.`idReceiver` = :idReceiver';
        $result = $this->db->prepare($query);
        $result->bindValue(':idReceiver', $this->idReceiver, PDO::PARAM_INT);
        if($result->execute()){
            if(is_object($result)){
                $isObject = $result->fetchAll(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
}

