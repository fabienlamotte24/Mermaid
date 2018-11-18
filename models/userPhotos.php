<?php

/**
 * Création de la classe users
 */
class userPhotos extends database {

    public $id;
    public $userPhotos;
    public $id_15968k4_users;

    /**
     * Création de la méthode magique constructeur
     */
    public function __construct() {
        parent::__construct();
        $this->dbConnect();
    }

    /**
     * Méthode servant à connaître l'existence d'une photo
     */
    public function alreadyUsedPhoto() {
        $query = 'SELECT COUNT(`userPhotos`) AS `count` FROM `15968k4_userPhotos`'
                . 'WHERE `id_15968k4_users` = :id_15968k4_users '
                . 'AND `userPhotos` = :userPhotos';
        $result = $this->db->prepare($query);
        $result->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        $result->bindValue(':userPhotos', $this->userPhotos, PDO::PARAM_STR);
        if ($result->execute()) {
            $check = $result->fetch(PDO::FETCH_OBJ);
            $bool = $check->count;
        }
        return $bool;
    }

    /**
     * Méthode servant à l'ajout de photos
     */
    public function addPhotos() {
        $query = 'INSERT INTO `15968k4_userPhotos`(`userPhotos`, `id_15968k4_users`) VALUES(:userPhotos, :id_15968k4_users)';
        $addPhoto = $this->db->prepare($query);
        $addPhoto->bindValue(':userPhotos', $this->userPhotos, PDO::PARAM_STR);
        $addPhoto->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        return $addPhoto->execute();
    }

    /**
     * Méthode servant à afficher les photos de l'utilisateur
     */
    public function showPhotos() {
        $query = 'SELECT `userPhotos`, `id` FROM `15968k4_userPhotos` '
                . 'WHERE `id_15968k4_users` = :id_15968k4_users ';
        $showPhotos = $this->db->prepare($query);
        $showPhotos->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        if ($showPhotos->execute()) {
            if (is_Object($showPhotos)) {
                $object = $showPhotos->fetchAll(PDO::FETCH_OBJ);
            }
        }
        return $object;
    }
    /**
     * Compte du nombre de photo
     */
    public function countPhotos(){
        $query = 'SELECT COUNT(`userPhotos`) AS `count` FROM `15968k4_userPhotos`'
                . 'WHERE `id_15968k4_users` = :id_15968k4_users ';
        $result = $this->db->prepare($query);
        $result->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        if ($result->execute()) {
            $check = $result->fetch(PDO::FETCH_OBJ);
            $bool = $check->count;
        }
        return $bool;
    }

    /**
     * Méthode servant à la suppression d'une photo
     */
    public function removePhoto(){
        $query= 'DELETE FROM `15968k4_userPhotos`'
                . 'WHERE `id` = :id';
        $remove = $this->db->prepare($query);
        $remove->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $remove->execute();
    }
}
