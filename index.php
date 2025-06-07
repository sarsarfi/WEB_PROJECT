<?php
// index.php

// تعریف ROOT_PATH برای استفاده عمومی در پروژه
define('ROOT_PATH', __DIR__);

// شروع Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Autoload Composer و فایل‌های اصلی پروژه
require_once ROOT_PATH . '/vendor/autoload.php';
require_once ROOT_PATH . '/config/database.php';
require_once ROOT_PATH . '/helper/functions.php';

use App\Route;
use App\Controller\AuthController;
use App\Controller\ShopController;

// تعریف Route
$route = new Route();

// ذخیره شیء Route در متغیر عمومی (جهت استفاده در توابع کمکی مثل get_base_path)
$GLOBALS['route'] = $route;

// -----------------------------
// مسیرهای مربوط به احراز هویت
// -----------------------------
$route->get('/login', [AuthController::class, 'login']);
$route->post('/login', [AuthController::class, 'loginUser']);
$route->get('/register', [AuthController::class, 'register']);
$route->post('/register', [AuthController::class, 'storeUser']);
$route->get('/logout', [AuthController::class, 'logout']);

// -----------------------------
// مسیرهای مربوط به فروشگاه
// -----------------------------
$route->get('/', [ShopController::class, 'index']); // صفحه اصلی
$route->get('/home', [ShopController::class, 'index']);
$route->get('/products', [ShopController::class, 'products']); // لیست محصولات
$route->get('/cart', [ShopController::class, 'cart']); // سبد خرید
$route->post('/cart/add', [ShopController::class, 'addToCart']);
$route->post('/cart/remove', [ShopController::class, 'removeFromCart']);
$route->get('/checkout', [ShopController::class, 'checkout']);
// $route->post('/checkout', [ShopController::class, 'processCheckout']); // در صورت نیاز

// اجرای dispatch برای تطبیق مسیرها با متدهای مشخص‌شده
$route->dispatch();
