<?php
namespace App\Models;

use PDO;
use Exception;

class Cart
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

    // Thêm sản phẩm vào giỏ hàng
    public static function addToCart(int $userId, int $productId, int $quantity = 1): void
{
    self::initDb();

    // Truy vấn thông tin sản phẩm từ bảng product
    $stmt = self::$db->prepare("SELECT id, name, price FROM product WHERE id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        throw new Exception("Sản phẩm không tồn tại.");
    }

    $price = $product['price'];
    $totalPrice = $price * $quantity;

    // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
    $stmt = self::$db->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$userId, $productId]);
    $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingItem) {
        // Cập nhật số lượng và tổng tiền nếu sản phẩm đã có trong giỏ
        $newQuantity = $existingItem['quantity'] + $quantity;
        $newTotalPrice = $price * $newQuantity;

        // Cập nhật giỏ hàng và thời gian cập nhật
        $stmt = self::$db->prepare("UPDATE cart SET quantity = ?, total_price = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute([$newQuantity, $newTotalPrice, $existingItem['id']]);
    } else {
        // Thêm sản phẩm mới vào giỏ hàng
        $stmt = self::$db->prepare("INSERT INTO cart (user_id, product_id, quantity, price, total_price, updated_at) VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");
        $stmt->execute([$userId, $productId, $quantity, $price, $totalPrice]);
    }
}


    // Lấy giỏ hàng từ cơ sở dữ liệu
    public static function getCart(int $userId): array
{
    self::initDb();
    $stmt = self::$db->prepare("SELECT p.id, p.name, p.img, p.price, c.quantity, c.total_price 
                                FROM cart c 
                                JOIN product p ON c.product_id = p.id 
                                WHERE c.user_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public static function getTotal(int $userId): float
{
    self::initDb();
    $stmt = self::$db->prepare("SELECT SUM(c.total_price) AS total 
                                FROM cart c 
                                WHERE c.user_id = ?");
    $stmt->execute([$userId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return (float) $result['total'];
}


    

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public static function updateQuantity(int $userId, int $productId, int $quantity): void
{
    self::initDb();

    // Lấy giá sản phẩm từ bảng product
    $stmt = self::$db->prepare("SELECT p.price FROM product p WHERE p.id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $price = $product['price'];  // Giá sản phẩm từ bảng product
        $totalPrice = $price * $quantity;  // Tính tổng tiền mới

        // Cập nhật giỏ hàng với số lượng mới và tổng tiền mới, đồng thời cập nhật thời gian
        $stmt = self::$db->prepare("UPDATE cart SET quantity = ?, total_price = ?, updated_at = CURRENT_TIMESTAMP WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$quantity, $totalPrice, $userId, $productId]);
    }
}


    // Xóa sản phẩm khỏi giỏ hàng
    public static function removeFromCart(int $userId, int $productId): void
{
    self::initDb();
    // Xóa sản phẩm và cập nhật thời gian
    $stmt = self::$db->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$userId, $productId]);

    // Hoặc nếu muốn ghi lại thời gian xóa:
    // $stmt = self::$db->prepare("UPDATE cart SET updated_at = CURRENT_TIMESTAMP WHERE user_id = ? AND product_id = ?");
    // $stmt->execute([$userId, $productId]);
}


    // Xóa toàn bộ giỏ hàng
    public static function clearCart(int $userId): void
    {
        self::initDb();
        $stmt = self::$db->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->execute([$userId]);
    }
}
