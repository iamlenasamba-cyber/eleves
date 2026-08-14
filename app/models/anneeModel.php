<?php
require_once dirname(__DIR__) . "/core/database.php";

class AnneeModel {
    public Database $db;
    public function __construct() {
        $this->db = new Database();
}

     public function getAnnee(): array|false {
        $pdo = $this->db->connexionDB();
        $sql = "SELECT * FROM anneeAcademiques WHERE actif = 1";
        $result = $this->db->query($pdo, $sql);

        $pdo = null; 
        return $result;
    }
}