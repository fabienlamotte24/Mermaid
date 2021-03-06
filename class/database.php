<?php
/**
 * class database
 */
class database {
    //Listing des attributs
    protected $db;
    private $host = '';
    private $login = '';
    private $password = '';
    private $dbname = '';
    /**
     * Méthode magique constructeur
     */
    public function __construct(){
        $this->host = HOST;
        $this->login = LOGIN;
        $this->password = PASSWORD;
        $this->dbname = DBNAME;
    }
    /**
     * Méthode servant à la connexion à la base de donnée
     */
    protected function dbConnect(){
        //tentative de connexion à la base de données
        try {
            $this->db = new PDO('mysql:host=' . $this->host . ';port=3306;dbname=' . $this->dbname . 
                    ';charset=UTF8;', $this->login, $this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
    /**
     * Méthode magique destructeur, qui nous déconnecte de la base de donnée
     */
    public function __destruct(){
        $this->db = NULL;
    }
} 
?>
