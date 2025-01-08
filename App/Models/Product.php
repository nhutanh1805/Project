<?php
require_once 'db_connect.php'; 

class Product {
    private $db;

    public function __construct($db) {
        $this->db = $db; 
    }


    public function search($keyword) {
        $query = "SELECT * FROM products WHERE name LIKE :keyword";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':keyword', '%' . $keyword . '%');

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
