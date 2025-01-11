<?php
namespace App\Models;

class Cart
{
    // Lấy giỏ hàng từ session
    public static function getCart()
    {
        // Kiểm tra xem giỏ hàng đã tồn tại trong session chưa, nếu chưa thì khởi tạo giỏ hàng rỗng
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];  // Khởi tạo giỏ hàng rỗng nếu chưa có
        }
        // Trả về giỏ hàng
        return $_SESSION['cart'];
    }

    // Thêm sản phẩm vào giỏ hàng
    public static function addToCart($productId, $quantity)
    {
        // Lấy giỏ hàng hiện tại
        $cart = self::getCart();
        
        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        if (isset($cart[$productId])) {
            // Nếu sản phẩm đã có trong giỏ hàng, cộng thêm số lượng
            $cart[$productId]['quantity'] += $quantity;
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới sản phẩm vào giỏ hàng
            $product = [
                'name' => 'Product ' . $productId, // Tên sản phẩm giả định (có thể thay thế bằng tên thật từ cơ sở dữ liệu)
                'price' => 100,  // Giá sản phẩm giả định (có thể thay thế bằng giá thật từ cơ sở dữ liệu)
                'quantity' => $quantity  // Số lượng sản phẩm
            ];
            $cart[$productId] = $product;  // Thêm sản phẩm vào giỏ hàng
        }

        // Cập nhật lại giỏ hàng trong session
        $_SESSION['cart'] = $cart;
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public static function removeFromCart($productId)
    {
        // Kiểm tra xem sản phẩm có trong giỏ hàng không
        if (isset($_SESSION['cart'][$productId])) {
            // Nếu có, xóa sản phẩm khỏi giỏ hàng
            unset($_SESSION['cart'][$productId]);
        }
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public static function updateQuantity($productId, $quantity)
    {
        // Kiểm tra xem sản phẩm có trong giỏ hàng không
        if (isset($_SESSION['cart'][$productId])) {
            // Nếu có, cập nhật số lượng sản phẩm trong giỏ hàng
            $_SESSION['cart'][$productId]['quantity'] = $quantity;
        }
    }

    // Tính tổng tiền giỏ hàng
    public static function getTotal()
    {
        $total = 0;  // Khởi tạo biến tổng tiền

        // Lặp qua từng sản phẩm trong giỏ hàng và tính tổng tiền
        foreach (self::getCart() as $item) {
            $total += $item['price'] * $item['quantity'];  // Cộng dồn giá trị (giá * số lượng) của từng sản phẩm
        }

        // Trả về tổng tiền
        return $total;
    }
    // Xóa giỏ hàng
    public static function clearCart()
    {
        // Xóa toàn bộ giỏ hàng trong session
        $_SESSION['cart'] = [];
    }
}
