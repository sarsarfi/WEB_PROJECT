<?php
namespace App\Controller;

use App\Model\Product;
use App\Model\Order;
use App\Model\OrderItem;
use App\Model\User; // اگر نیاز به اطلاعات کاربر دارید

class ShopController
{
    public static function index()
    {
        // نمایش لیست محصولات در صفحه اصلی
        $products = Product::all(); // همه محصولات را از دیتابیس بگیرید
        view('shop/products.php', ['products' => $products]);
    }

    public static function products()
    {
        // این متد می‌تواند همانند index باشد یا منطق فیلتر/جستجو داشته باشد
        self::index();
    }

    

    public static function cart()
    {
        $cart = $_SESSION['cart'] ?? [];
        $cartItems = [];
        $totalPrice = 0;

        if (!empty($cart)) {
            $productIds = array_keys($cart);
            $products = Product::whereIn('id', $productIds)->get()->keyBy('id'); // محصولات را بر اساس ID دسته‌بندی کنید

            foreach ($cart as $productId => $quantity) {
                if (isset($products[$productId])) {
                    $product = $products[$productId];
                    $subtotal = $product->price * $quantity;
                    $totalPrice += $subtotal;
                    $cartItems[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'subtotal' => $subtotal
                    ];
                }
            }
        }
        view('shop/cart.php', ['cartItems' => $cartItems, 'totalPrice' => $totalPrice]);
    }

    public static function addToCart()
    {
        $productId = $_POST['product_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        if (!$productId || $quantity <= 0) {
            $_SESSION['error'] = 'اطلاعات محصول نامعتبر است.';
            redirect('/web_project/products');
            return;
        }

        $product = Product::find($productId);
        if (!$product) {
            $_SESSION['error'] = 'محصول یافت نشد.';
            redirect('/web_project/products');
            return;
        }

        // سبد خرید را در سشن ذخیره می‌کنیم
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }

        $_SESSION['success'] = 'محصول به سبد خرید اضافه شد.';
        redirect('/web_project/cart');
    }

    public static function removeFromCart()
    {
        $productId = $_POST['product_id'] ?? null;

        if (!$productId) {
            $_SESSION['error'] = 'شناسه محصول نامعتبر است.';
            redirect('/web_project/cart');
            return;
        }

        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
            $_SESSION['success'] = 'محصول از سبد خرید حذف شد.';
        } else {
            $_SESSION['error'] = 'محصول در سبد خرید شما نیست.';
        }
        redirect('/web_project/cart');
    }

    public static function checkout()
    {
        if (!self::isLoggedIn()) {
            $_SESSION['error'] = 'برای نهایی کردن خرید، باید وارد شوید.';
            redirect('/web_project/login');
            return;
        }

        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            $_SESSION['error'] = 'سبد خرید شما خالی است.';
            redirect('/web_project/cart');
            return;
        }

        $userId = $_SESSION['user_id'];
        $totalPrice = 0;
        $orderItemsData = [];

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        foreach ($cart as $productId => $quantity) {
            if (isset($products[$productId])) {
                $product = $products[$productId];
                $subtotal = $product->price * $quantity;
                $totalPrice += $subtotal;
                $orderItemsData[] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price_at_purchase' => $product->price // ذخیره قیمت محصول در زمان خرید
                ];
            }
        }

        if (empty($orderItemsData)) {
            $_SESSION['error'] = 'سبد خرید نامعتبر است. هیچ محصولی برای خرید یافت نشد.';
            redirect('/web_project/cart');
            return;
        }

        // ایجاد سفارش جدید
        try {
            $order = Order::create([
                'user_id' => $userId,
                'total_amount' => $totalPrice,
                'status' => 'pending' // یا 'completed' بسته به منطق پرداخت
            ]);

            // افزودن آیتم‌های سفارش
            foreach ($orderItemsData as $itemData) {
                $order->orderItems()->create($itemData);
            }

            // پاک کردن سبد خرید پس از نهایی شدن سفارش
            unset($_SESSION['cart']);
            $_SESSION['success'] = 'سفارش شما با موفقیت ثبت شد!';
            redirect('/web_project/home'); // یا به صفحه تأیید سفارش
        } catch (\Exception $e) {
            error_log("Checkout error: " . $e->getMessage());
            $_SESSION['error'] = 'خطا در ثبت سفارش: ' . $e->getMessage();
            redirect('/web_project/cart');
        }
    }

    private static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }
}