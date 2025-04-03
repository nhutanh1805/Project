<?php
namespace App\Models;

use PDO;
use Exception;

class Inventory
{
    private static ?PDO $db = null;

    public static function setDb(PDO $pdo): void
    {
        self::$db = $pdo;
    }

    private static function initDb(): void
    {
        if (self::$db === null) {
            $dsn = "mysql:host=localhost;dbname=nienluancoso;charset=utf8";
            $username = "root";
            $password = "123456";
            try {
                self::$db = new PDO($dsn, $username, $password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                throw new Exception("Không thể kết nối đến database: " . $e->getMessage());
            }
        }
    }

    // Lấy tất cả sản phẩm trong kho
    public static function getAllProductsInStock(): array
    {
        self::initDb();
        $stmt = self::$db->prepare("SELECT p.id, p.name, p.img, p.price, i.quantity_in_stock 
                                    FROM product p
                                    JOIN inventory i ON p.id = i.product_id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm sản phẩm vào kho
    public static function addToInventory(int $productId, int $quantity): void
    {
        self::initDb();

        // Kiểm tra xem sản phẩm đã có trong kho chưa
        $stmt = self::$db->prepare("SELECT id, quantity_in_stock FROM inventory WHERE product_id = ?");
        $stmt->execute([$productId]);
        $existingProduct = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingProduct) {
            // Nếu sản phẩm đã có trong kho, cập nhật số lượng
            $newQuantity = $existingProduct['quantity_in_stock'] + $quantity;
            $stmt = self::$db->prepare("UPDATE inventory SET quantity_in_stock = ? WHERE product_id = ?");
            $stmt->execute([$newQuantity, $productId]);
        } else {
            // Nếu sản phẩm chưa có trong kho, thêm sản phẩm vào kho
            $stmt = self::$db->prepare("INSERT INTO inventory (product_id, quantity_in_stock) VALUES (?, ?)");
            $stmt->execute([$productId, $quantity]);
        }
    }

    // Cập nhật số lượng sản phẩm trong kho
    public static function updateStock(int $productId, int $quantity): void
    {
        self::initDb();

        // Cập nhật số lượng sản phẩm trong kho
        $stmt = self::$db->prepare("UPDATE inventory SET quantity_in_stock = ? WHERE product_id = ?");
        $stmt->execute([$quantity, $productId]);
    }

    // Xóa sản phẩm khỏi kho
    public static function removeFromInventory(int $productId): void
    {
        self::initDb();

        // Xóa sản phẩm khỏi kho
        $stmt = self::$db->prepare("DELETE FROM inventory WHERE product_id = ?");
        $stmt->execute([$productId]);
    }

    // Lấy thông tin sản phẩm trong kho
    public static function getProductInStock(int $productId): ?array
    {
        self::initDb();
        $stmt = self::$db->prepare("SELECT * FROM inventory WHERE product_id = ?");
        $stmt->execute([$productId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
