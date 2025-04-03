<?php
namespace App\Models;

use PDO;
use Exception;

class Order
{
    private static ?PDO $db = null;

    // Thiết lập kết nối cơ sở dữ liệu
    public static function setDb(PDO $pdo): void
    {
        self::$db = $pdo;
    }

    // Khởi tạo kết nối nếu chưa có
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

    // Thêm đơn hàng vào hệ thống
    public static function createOrder(int $userId, string $address, float $totalAmount): int
    {
        self::initDb();

        // Bắt đầu transaction
        self::$db->beginTransaction();

        try {
            // Lưu thông tin đơn hàng vào bảng `orders`
            $stmt = self::$db->prepare("INSERT INTO `orders` (user_id, address, total_amount, created_at, updated_at) 
                                        VALUES (?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
            $stmt->execute([$userId, $address, $totalAmount]);

            // Kiểm tra nếu đơn hàng được tạo thành công
            $orderId = self::$db->lastInsertId();
            if (!$orderId) {
                throw new Exception('Không thể lưu đơn hàng vào cơ sở dữ liệu.');
            }

            // Lưu chi tiết đơn hàng vào bảng `order_details`
            self::createOrderDetails($orderId, $userId);

            // Commit transaction
            self::$db->commit();

            return $orderId;  // Trả về ID của đơn hàng
        } catch (Exception $e) {
            // Rollback transaction nếu có lỗi
            self::$db->rollBack();
            error_log("Lỗi khi lưu đơn hàng: " . $e->getMessage());
            throw $e;  // Ném lại exception để controller xử lý
        }
    }

    // Thêm chi tiết đơn hàng vào bảng `order_details`
    private static function createOrderDetails(int $orderId, int $userId): void
    {
        self::initDb();
        
        // Lấy giỏ hàng của người dùng
        $stmt = self::$db->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $stmt->execute([$userId]);
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($cartItems)) {
            throw new Exception('Giỏ hàng của bạn trống. Không thể tạo đơn hàng.');
        }

        // Lưu từng sản phẩm trong giỏ hàng vào bảng `order_details`
        foreach ($cartItems as $item) {
            $stmt = self::$db->prepare("INSERT INTO `order_details` (order_id, product_id, quantity, price, total_price) 
                                        VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([ 
                $orderId,
                $item['product_id'],
                $item['quantity'],
                $item['price'],
                $item['total_price']
            ]);
        }
    }

    // Lấy thông tin đơn hàng của người dùng
    public static function getOrdersByUserId(int $userId): array
    {
        self::initDb();
        $stmt = self::$db->prepare("SELECT * FROM `orders` WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết đơn hàng
    public static function getOrderDetails(int $orderId): array
    {
        self::initDb();
        $stmt = self::$db->prepare("SELECT o.id, o.address, o.total_amount, o.created_at, p.name, p.price, od.quantity
                                    FROM `order_details` od
                                    JOIN `orders` o ON od.order_id = o.id
                                    JOIN `product` p ON od.product_id = p.id
                                    WHERE o.id = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật trạng thái đơn hàng
    public static function updateOrderStatus(int $orderId, string $status): void
    {
        self::initDb();
        $stmt = self::$db->prepare("UPDATE `orders` SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute([$status, $orderId]);
    }

    // Xóa đơn hàng (nếu cần)
    public static function deleteOrder(int $orderId): void
    {
        self::initDb();
        $stmt = self::$db->prepare("DELETE FROM `orders` WHERE id = ?");
        $stmt->execute([$orderId]);
    }
}
