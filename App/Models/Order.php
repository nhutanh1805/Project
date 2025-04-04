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

    // Tạo đơn hàng mới
    public static function createOrder(int $userId, string $address): int
    {
        self::initDb();
        // Tính tổng tiền từ giỏ hàng
        $totalAmount = Cart::getTotal($userId);

        if ($totalAmount <= 0) {
            throw new Exception("Giỏ hàng của bạn không có sản phẩm.");
        }

        // Thêm đơn hàng vào bảng orders
        $stmt = self::$db->prepare("INSERT INTO orders (user_id, address, total_amount, created_at) VALUES (?, ?, ?, CURRENT_TIMESTAMP)");
        $stmt->execute([$userId, $address, $totalAmount]);

        // Lấy ID của đơn hàng vừa tạo
        $orderId = self::$db->lastInsertId();

        // Thêm chi tiết đơn hàng vào bảng order_details từ giỏ hàng
        $stmt = self::$db->prepare("SELECT product_id, quantity, total_price FROM cart WHERE user_id = ?");
        $stmt->execute([$userId]);
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($cartItems as $item) {
            $stmt = self::$db->prepare("INSERT INTO order_details (order_id, product_id, quantity, price, total_price) 
                                        VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $orderId, 
                $item['product_id'], 
                $item['quantity'], 
                $item['total_price'] / $item['quantity'],  // Giá sản phẩm
                $item['total_price']
            ]);
        }

        // Xóa giỏ hàng sau khi tạo đơn hàng
        Cart::clearCart($userId);

        return $orderId;
    }

    // Lấy thông tin đơn hàng
    public static function getOrder(int $orderId): array
    {
        self::initDb();
        $stmt = self::$db->prepare("SELECT o.id, o.user_id, o.address, o.total_amount, o.created_at, o.updated_at, 
                                            d.product_id, d.quantity, d.price, d.total_price, p.name AS product_name
                                    FROM orders o
                                    JOIN order_details d ON o.id = d.order_id
                                    JOIN product p ON d.product_id = p.id
                                    WHERE o.id = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả đơn hàng của người dùng
    public static function getUserOrders(int $userId): array
    {
        self::initDb();
        $stmt = self::$db->prepare("SELECT o.id, o.address, o.total_amount, o.created_at, o.updated_at 
                                    FROM orders o
                                    WHERE o.user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật địa chỉ của đơn hàng
    public static function updateOrderAddress(int $orderId, string $newAddress): void
    {
        self::initDb();
        $stmt = self::$db->prepare("UPDATE orders SET address = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute([$newAddress, $orderId]);
    }

    // Cập nhật trạng thái đơn hàng (ví dụ: đang xử lý, đã giao hàng, v.v.)
    public static function updateOrderStatus(int $orderId, string $status): void
    {
        self::initDb();
        $stmt = self::$db->prepare("UPDATE orders SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute([$status, $orderId]);
    }

    // Hủy đơn hàng
    public static function cancelOrder(int $orderId): void
    {
        self::initDb();
        // Hủy đơn hàng, có thể cập nhật trạng thái thay vì xóa trực tiếp
        $stmt = self::$db->prepare("UPDATE orders SET status = 'Cancelled', updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute([$orderId]);
    }
}
?>
