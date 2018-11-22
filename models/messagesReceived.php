<?php

class messagesReceived extends database{
    public $id;
    public $title;
    public $idReceiver;
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
    public function countMessagesReceived(){
        $query = 'SELECT COUNT(`id`) AS `count` FROM `15968k4_messagesReceived` '
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
     * Methode servant à connaître le nombre de message non lus que possède un utilisateur
     */
    public function countUnreadenMessagesReceived(){
        $query = 'SELECT COUNT(`id`) AS `count`, `readen` FROM `15968k4_messagesReceived` '
                . 'WHERE `idReceiver` = :idReceiver '
                . 'AND `readen` = 0';
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
        $query = 'SELECT `mess`.`id`, `mess`.`title`, `mess`.`readen`, `mess`.`idReceiver`, DATE_FORMAT(`mess`.`dateHour`, \'%d/%m/%Y\') AS `date`, DATE_FORMAT(`mess`.`dateHour`,  \'%Hh%i\') AS `hour`, `mess`.`content`, `us`.`pseudo` '
                . 'FROM `15968k4_messagesReceived` AS `mess` '
                . 'LEFT JOIN `15968k4_users` AS `us` '
                . 'ON `mess`.`id_15968k4_users` = `us`.`id` '
                . 'WHERE `mess`.`idReceiver` = :idReceiver '
                . 'ORDER BY `dateHour` DESC';
        $result = $this->db->prepare($query);
        $result->bindValue(':idReceiver', $this->idReceiver, PDO::PARAM_INT);
        if($result->execute()){
            if(is_object($result)){
                $isObject = $result->fetchAll(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
    /**
     * Méthode permettant d'afficher les messages non lus
     */
    public function showUnreadenMessageReceived(){
        $query = 'SELECT `mess`.`id`, `mess`.`title`, `mess`.`readen`, `mess`.`idReceiver`, DATE_FORMAT(`mess`.`dateHour`, \'%d/%m/%Y\') AS `date`, DATE_FORMAT(`mess`.`dateHour`,  \'%Hh%i\') AS `hour`, `mess`.`content`, `us`.`pseudo` '
                . 'FROM `15968k4_messagesReceived` AS `mess` '
                . 'LEFT JOIN `15968k4_users` AS `us` '
                . 'ON `mess`.`id_15968k4_users` = `us`.`id` '
                . 'WHERE `mess`.`idReceiver` = :idReceiver '
                . 'AND `readen` = 0 ';
        $result = $this->db->prepare($query);
        $result->bindValue(':idReceiver', $this->idReceiver, PDO::PARAM_INT);
        if($result->execute()){
            if(is_object($result)){
                $isObject = $result->fetchAll(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
    /**
     * Méthode servant à afficher les messages dont l'utilisateur est le destinataire
     */
    public function showMessageSelected(){
        $query = 'SELECT `mess`.`id`, `mess`.`title`, `mess`.`idReceiver`, `mess`.`readen`, DATE_FORMAT(`mess`.`dateHour`, \'%Y-%m-%d\') AS `date`, DATE_FORMAT(`mess`.`dateHour`,  \'%Hh%i\') AS `hour`, `mess`.`id_15968k4_users`, `mess`.`content`, `us`.`pseudo` '
                . 'FROM `15968k4_messagesReceived` AS `mess` '
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
    public function sendMessage(){
        $query = 'INSERT INTO `15968k4_messagesReceived`(`title`,`idReceiver`,`dateHour`,`content`,`id_15968k4_users`,`readen`) '
                . 'VALUES(:title, :idReceiver, :dateHour, :content, :id_15968k4_users, :readen)';
        $result = $this->db->prepare($query);
        $result->bindValue(':title', $this->title, PDO::PARAM_STR);
        $result->bindValue(':idReceiver', $this->idReceiver, PDO::PARAM_INT);
        $result->bindValue(':dateHour', $this->dateHour, PDO::PARAM_STR);
        $result->bindValue(':content', $this->content, PDO::PARAM_STR);
        $result->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        $result->bindValue(':readen', $this->readen, PDO::PARAM_INT);
        return $result->execute();
    }
    /**
     * Méthode de listing des id appartenant à l'utilisateur, afin de protéger l'url, quand il est le destinataire
     */
    public function listIdReceivedMessagesUrl(){
        $query = 'SELECT `id` FROM `15968k4_messagesReceived` '
                . 'WHERE `idReceiver` = :idReceiver ';
        $result = $this->db->prepare($query);
        $result->bindValue(':idReceiver', $this->idReceiver, PDO::PARAM_INT);
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
        $query = 'DELETE FROM `15968k4_messagesReceived` '
                . 'WHERE `id` = :id';
        $result = $this->db->prepare($query);
        $result->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $result->execute();
    }
    /**
     * Méthode servant la suppression de tout les messages
     */
    public function deleteAllMessages(){
        $query = 'DELETE FROM `15968k4_messagesReceived` '
                . 'WHERE `idReceiver` = :idReceiver';
        $result = $this->db->prepare($query);
        $result->bindValue('idReceiver', $this->idReceiver, PDO::PARAM_INT);
        return $result->execute();
    }
    /**
     * Méthode servant à compter le nombre de messages non lus de l'utilisateur
     */
    public function messageReaden(){
        $query = 'UPDATE `15968k4_messagesReceived` '
                . 'SET `readen` = :readen '
                . 'WHERE `id` = :id';
        $result = $this->db->prepare($query);
        $result->bindValue(':readen', $this->readen, PDO::PARAM_INT);
        $result->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $result->execute();
    }
}

