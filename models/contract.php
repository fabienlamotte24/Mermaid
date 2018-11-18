<?php

class contract extends database {
    public $id;
    public $amount;
    public $id_15968k4_establishment;
    public $id_15968k4_band;
    public $id_15968k4_users;
    
    /**
     * Création de la méthode magique constructeur
     */
    public function __construct() {
        parent::__construct();
        $this->dbConnect();
    }
    /**
     * Méthode de compte de contract pour un utilisateur
     */
    public function contractCount(){
        $bool = FALSE;
        $query = 'SELECT COUNT(`id`) AS `count` FROM `15968k4_contract` '
                . 'WHERE `id_15968k4_users` = :id';
        $result = $this->db->prepare($query);
        $result->bindValue(':id', $this->id, PDO::PARAM_INT);
        if($result->execute()){
                $check = $result->fetch(PDO::FETCH_OBJ);
                $bool = $check->count;
        }
         return $bool;       
    }
}