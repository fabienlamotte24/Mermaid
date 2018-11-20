<?php

class messagesTransmitted extends database{
    public $id;
    public $title;
    public $idTransmitter;
    public $dateHour;
    public $content;
    public $readen;
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
    public function countMessagesUnreaden(){
        $query = 'SELECT COUNT(`id`) AS `count`, `readen` FROM `15968k4_messagesTransmitted` '
                . 'WHERE `idTransmitter` = :idTransmitter '
                . 'AND `readen` = 0';
        $result = $this->db->prepare($query);
        $result->bindValue(':idTransmitter', $this->idTransmitter, PDO::PARAM_INT);
        if($result->execute()){
            $check = $result->fetch(PDO::FETCH_OBJ);
            $bool = $check->count;
        }
        return $bool;
    }
    /**
     * Méthode servant à connaître le nombre de message dont l'utilisateur est l'emmeteur
     */
    public function countSentMessages(){
        $query = 'SELECT COUNT(`id`) AS `count` FROM `15968k4_messagesTransmitted` '
                . 'WHERE `idTransmitter` = :idTransmitter ';
        $result = $this->db->prepare($query);
        $result->bindValue(':idTransmitter', $this->idTransmitter, PDO::PARAM_INT);
        if($result->execute()){
            $check = $result->fetch(PDO::FETCH_OBJ);
            $bool = $check->count;
        }
        return $bool;
    }
    /**
     * Méthode servant à afficher les messages dont l'utilisateur est le destinataire
     */
    public function showMessageSelected(){
        $query = 'SELECT `mess`.`id`, `mess`.`title`, `mess`.`idTransmitter`, `mess`.`readen`, DATE_FORMAT(`mess`.`dateHour`, \'%d/%m/%Y\') AS `date`, DATE_FORMAT(`mess`.`dateHour`,  \'%Hh%i\') AS `hour`,`mess`.`id_15968k4_users` ,`mess`.`content`, `us`.`pseudo` '
                . 'FROM `15968k4_messagesTransmitted` AS `mess` '
                . 'LEFT JOIN `15968k4_users` AS `us` '
                . 'ON `mess`.`id_15968k4_users` = `us`.`id` '
                . 'WHERE `mess`.`id` = :id';
        $result = $this->db->prepare($query);
        $result->bindValue(':id', $this->id, PDO::PARAM_INT);
        if($result->execute()){
            if(is_object($result)){
                $isObject = $result->fetch(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
    /**
     * Méthode servant à l'envoi du message
     */
    public function keepMessage(){
        $query = 'INSERT INTO `15968k4_messagesTransmitted`(`title`,`idTransmitter`,`dateHour`,`content`,`id_15968k4_users`,`readen`) '
                . 'VALUES(:title, :idTransmitter, :dateHour, :content, :id_15968k4_users, :readen)';
        $result = $this->db->prepare($query);
        $result->bindValue(':title', $this->title, PDO::PARAM_STR);
        $result->bindValue(':idTransmitter', $this->idTransmitter, PDO::PARAM_INT);
        $result->bindValue(':dateHour', $this->dateHour, PDO::PARAM_STR);
        $result->bindValue(':content', $this->content, PDO::PARAM_STR);
        $result->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        $result->bindValue(':readen', $this->readen, PDO::PARAM_INT);
        return $result->execute();
    }
    /**
     * Méthode servant à lister les messages envoyés
     */
    public function showMessagesSent(){
        $query = 'SELECT `mess`.`id`, `mess`.`title`, `mess`.`idTransmitter`, `mess`.`readen`, DATE_FORMAT(`mess`.`dateHour`, \'%d/%m/%Y\') AS `date`, DATE_FORMAT(`mess`.`dateHour`,  \'%Hh%i\') AS `hour`, `mess`.`content`, `us`.`pseudo` '
                . 'FROM `15968k4_messagesTransmitted` AS `mess` '
                . 'LEFT JOIN `15968k4_users` AS `us` '
                . 'ON `mess`.`id_15968k4_users` = `us`.`id` '
                . 'WHERE `mess`.`idTransmitter` = :idTransmitter';
        $result = $this->db->prepare($query);
        $result->bindValue(':idTransmitter', $this->idTransmitter, PDO::PARAM_INT);
        if($result->execute()){
            if(is_object($result)){
                $isObject = $result->fetchAll(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
    /**
     * Méthode de listing des id appartenant à l'utilisateur, afin de protéger l'url, quand il est l'emetteur
     */
    public function listIdSentMessagesUrl(){
        $query = 'SELECT `id` FROM `15968k4_messagesTransmitted` '
                . 'WHERE `idTransmitter` = :idTransmitter';
        $result = $this->db->prepare($query);
        $result->bindValue(':idTransmitter', $this->idTransmitter, PDO::PARAM_INT);
        if($result->execute()){
            if(is_object($result)){
                $isObject = $result->fetchAll(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
    
    /**
     * Méthode servant à la suppression d'un message
     */
    public function removeMessage(){
        $query = 'DELETE FROM `15968k4_messagesTransmitted` '
                . 'WHERE `id` = :id';
        $result = $this->db->prepare($query);
        $result->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $result->execute();
    }
    
}

