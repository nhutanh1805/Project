<?php
namespace App\Models;

use PDO;

class Search
{
    private PDO $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function searchProducts(string $query): array
    {
        $stmt = $this->db->prepare('
            SELECT id, name, img, description, price FROM product
            WHERE name LIKE :query OR description LIKE :query
            LIMIT 10
        ');

        $stmt->bindValue(':query', '%' . $query . '%');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
