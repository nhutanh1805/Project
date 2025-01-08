<?php
namespace App\Controllers;

use App\Models\Cart;

class CartController extends Controller
{
    public function index()
    {

        $cart = Cart::getCart();
        $total = Cart::getTotal();
        
        // Truyền dữ liệu sang view
        $this->sendPage('cart/index', [
            'cart' => $cart,
            'total' => $total
        ]);
    }

    // Thêm sản phẩm vào giỏ hàng
public function add($productId)
{
    $quantity = $_POST['quantity'] ?? 1; 
    Cart::addToCart($productId, $quantity);

    redirect('/cart');
}


    public function remove($productId)
    {
        Cart::removeFromCart($productId);

        redirect('/cart');
    }

    public function update($productId)
    {
        $quantity = $_POST['quantity'] ?? 1; 
        Cart::updateQuantity($productId, $quantity);

        redirect('/cart');
    }
}
