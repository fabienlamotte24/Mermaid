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
}
