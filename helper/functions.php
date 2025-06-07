<?php

// تابع برای دریافت basePath (برای استفاده در Viewها)
function get_base_path() {
    return '/web_project';
}


// تابع برای ریدایرکت با مدیریت basePath
function redirect($path) {
    $basePath = get_base_path();
    $fullPath = rtrim($basePath, '/') . '/' . ltrim($path, '/');
    header("Location: " . $fullPath);
    exit();
}

// تابع برای رندر کردن Viewها
function view($viewName, $data = []) {
    // پیام‌های سشن را برای نمایش در layout دریافت کنید
    $session_error = $_SESSION['error'] ?? null;
    $session_success = $_SESSION['success'] ?? null;
    
    // بعد از خواندن، پیام‌ها را پاک کنید تا فقط یک بار نمایش داده شوند
    unset($_SESSION['error']);
    unset($_SESSION['success']);

    // متغیرهای data را به صورت محلی در view در دسترس قرار دهید
    extract($data);

    // مسیر کامل به فایل view
    $viewPath = ROOT_PATH . '/views/' . $viewName; 

    // بررسی وجود فایل view
    if (!file_exists($viewPath)) {
        die("View file not found: " . htmlspecialchars($viewPath));
    }
    
    // محتوای view اصلی را با استفاده از Output Buffering دریافت کنید
    ob_start();
    require $viewPath;
    $content = ob_get_clean();

    // سپس layout را شامل کنید که خودش متغیر $content را رندر خواهد کرد
    // این اطمینان حاصل می‌کند که layout فقط یک بار بارگذاری می‌شود
    require ROOT_PATH . '/views/layout.php'; 
}



// اگر توابع دیگری دارید، اینجا اضافه کنید