<?php
namespace App\Models;

class Cart
{
    // Lấy giỏ hàng từ session
    public static function getCart()
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        return $_SESSION['cart'];
    }

    // Thêm sản phẩm vào giỏ hàng
    public static function addToCart($productId, $quantity)
    {
        $cart = self::getCart();
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
 
            $product = [
                'name' => 'Product ' . $productId,
                'price' => 100, 
                'quantity' => $quantity
            ];
            $cart[$productId] = $product;
        }
        $_SESSION['cart'] = $cart;
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public static function removeFromCart($productId)
    {
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public static function updateQuantity($productId, $quantity)
    {
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] = $quantity;
        }
    }

    // Tính tổng tiền giỏ hàng
    public static function getTotal()
    {
        $total = 0;
        foreach (self::getCart() as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}
