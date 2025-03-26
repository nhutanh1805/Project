<?php
namespace App\Models;

use PDO;
use Exception;

class Order
{
    private static ?PDO $db = null;

    public static function setDb(PDO $pdo): void
    {
        self::$db = $pdo;
    }

    private static function initDb(): void
    {
        if (self::$db === null) {
            $dsn = "mysql:host=localhost;dbname=nienluancoso1;charset=utf8";
            $username = "root";
            $password = "";
            try {
                self::$db = new PDO($dsn, $username, $password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                throw new Exception("Không thể kết nối đến database: " . $e->getMessage());
            }
        }
    }

    // Tạo đơn hàng
    public static function createOrder(int $userId, float $totalPrice): int
    {
        self::initDb();
        // Insert vào bảng orders
        $stmt = self::$db->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 0)"); // status default là 0 (đang chờ xử lý)
        $stmt->execute([$userId, $totalPrice]);

        // Lấy id của đơn hàng vừa tạo
        return self::$db->lastInsertId();
    }

    // Lưu các sản phẩm vào đơn hàng
    public static function createOrderItems(int $orderId, int $productId, int $quantity, float $price, float $totalPrice): void
    {
        self::initDb();
        // Thêm sản phẩm vào bảng order_items
        $stmt = self::$db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price, total_price) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$orderId, $productId, $quantity, $price, $totalPrice]);
    }

    // Cập nhật trạng thái đơn hàng
    public static function updateOrderStatus(int $orderId, int $status): void
    {
        self::initDb();
        // Cập nhật trạng thái đơn hàng
        $stmt = self::$db->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->execute([$status, $orderId]);
    }

    // Lấy thông tin đơn hàng theo ID
    public static function getOrderById(int $orderId): array
    {
        self::initDb();
        $stmt = self::$db->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách các sản phẩm trong một đơn hàng
    public static function getOrderItems(int $orderId): array
    {
        self::initDb();
        $stmt = self::$db->prepare("SELECT oi.*, p.name AS product_name 
                                    FROM order_items oi 
                                    JOIN products p ON oi.product_id = p.id 
                                    WHERE oi.order_id = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả đơn hàng của người dùng (Admin có thể lấy của tất cả người dùng)
    public static function getOrdersByUserId(int $userId): array
    {
        self::initDb();
        $stmt = self::$db->prepare("SELECT * FROM orders WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả đơn hàng (Admin có thể xem)
    public static function getAllOrders(): array
    {
        self::initDb();
        $stmt = self::$db->query("SELECT * FROM orders");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
