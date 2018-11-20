<?php
/**
 * Création de la classe notification
 */

class notifications extends database{
    public $id;
    public $notifDescription;
    public $id_15968k4_users;
    
    /**
     * Création de la méthode magique constructeur
     */
    public function __construct() {
        parent::__construct();
        $this->dbConnect();
    }
    /**
     * Méthode servant au compte du nombre de notification pour un utilisateur
     */
    public function countNotification(){
        $bool = FALSE;
        $query = 'SELECT COUNT(`id`) AS `count` FROM `15968k4_notifications` '
                . 'WHERE `id_15968k4_users` = :id_15968k4_users';
        $check = $this->db->prepare($query);
        $check->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        if($check->execute()){
            $result = $check->fetch(PDO::FETCH_OBJ);
            $bool = $result->count;
        }
        return $bool;
    }
    /**
     * Méthode d'ajout de notification
     */
    public function addNotification(){
        $query = 'INSERT INTO `15968k4_notifications`(`notifDescription`, `id_15968k4_users`) '
                . 'VALUES(:notifDescription, :id_15968k4_users)';
        $result = $this->db->prepare($query);
        $result->bindValue(':notifDescription', $this->notifDescription, PDO::PARAM_STR);
        $result->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        return $result->execute();
    }
    /**
     * Méthode d'affichage de notification
     */
    public function showNotif(){
        $query = 'SELECT `id`, `notifDescription`, `id_15968k4_users` FROM `15968k4_notifications` '
                . 'WHERE `id_15968k4_users` = :id_15968k4_users';
        $result = $this->db->prepare($query);
        $result->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        if($result->execute()){
            if(is_object($result)){
                $isObject = $result->fetchAll(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
    /**
     * Méthode de suppression de notification
     */
    public function removeNotif(){
        $query = 'DELETE FROM `15968k4_notifications` '
                . 'WHERE `id` = :id';
        $result = $this->db->prepare($query);
        $result->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $result->exeucte();
    }
}
