<?php
namespace App\Models;

use PDO;
use Exception;

class Cart
{
    // Khai báo thuộc tính PDO dưới dạng nullable
    private static ?PDO $db = null;

    // Gán đối tượng PDO cho model Cart
    public static function setDb(PDO $pdo): void
    {
        self::$db = $pdo;
    }
    
    // Hàm khởi tạo tự động kết nối PDO nếu chưa được thiết lập
    private static function initDb(): void
    {
        if (self::$db === null) {
            $dsn = "mysql:host=localhost;dbname=ct275_project;charset=utf8";
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

    // Lấy giỏ hàng từ session
    public static function getCart(): array
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];  // Khởi tạo giỏ hàng rỗng nếu chưa có
        }
        return $_SESSION['cart'];
    }

    // Thêm sản phẩm vào giỏ hàng với thông tin từ cơ sở dữ liệu (name, img, price)
    public static function addToCart(int $productId, int $quantity = 1): void
    {
        $cart = self::getCart();
        
        // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            // Nếu chưa có kết nối PDO, tự động khởi tạo
            if (self::$db === null) {
                self::initDb();
            }

            // Truy vấn thông tin sản phẩm từ database
            $stmt = self::$db->prepare("SELECT id, name, img, price FROM product WHERE id = ?");
            $stmt->execute([$productId]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                $_SESSION['error_message'] = "Sản phẩm không tồn tại.";
                return;
            }

            // Tạo chuỗi HTML để hiển thị ảnh sản phẩm (img tag)
            $imgTag = '<img src="' . $product['img'] . '" alt="' . htmlspecialchars($product['name']) . '" style="max-width:150px;">';

            // Thêm sản phẩm vào giỏ hàng với thông tin đầy đủ
            $cart[$productId] = [
                'name'      => $product['name'],
                'img'       => $product['img'],    // Đường dẫn ảnh chính
                'img_tag'   => $imgTag,            // Chuỗi HTML để hiển thị ảnh
                'price'     => $product['price'],
                'quantity'  => $quantity
            ];
        }

        $_SESSION['cart'] = $cart;
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public static function removeFromCart(int $productId): void
    {
        $cart = self::getCart();
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $_SESSION['cart'] = $cart;
            $_SESSION['message'] = "Sản phẩm đã được xóa khỏi giỏ hàng.";
        } else {
            $_SESSION['error_message'] = "Sản phẩm không tồn tại trong giỏ hàng.";
        }
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public static function updateQuantity(int $productId, int $quantity): void
    {
        $cart = self::getCart();
        if (isset($cart[$productId])) {
            if ($quantity <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['quantity'] = $quantity;
            }
            $_SESSION['cart'] = $cart;
        }
    }

    // Tính tổng tiền giỏ hàng
    public static function getTotal(): float
    {
        $total = 0;
        foreach (self::getCart() as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    // Xóa toàn bộ giỏ hàng
    public static function clearCart(): void
    {
        $_SESSION['cart'] = [];
    }
    
}
