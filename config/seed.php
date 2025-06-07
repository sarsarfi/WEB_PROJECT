<?php
// seed.php

// بارگذاری تنظیمات کانفیگ
$config = require __DIR__ . '/database.php'; // <-- اصلاح شده

// اتصال به دیتابیس با PDO
try {
    $dsn = "{$config['driver']}:host={$config['host']};charset={$config['charset']}";
    $pdo = new PDO($dsn, $config['username'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$config['database']}` CHARACTER SET {$config['charset']} COLLATE {$config['collation']}");
    $pdo->exec("USE `{$config['database']}`");

    // خواندن محتوای فایل SQL
    $sqlFile = __DIR__ . '/onlin_shop.sql'; // <-- اصلاح شده
    if (!file_exists($sqlFile)) {
        throw new Exception("File onlin_shop.sql not found!"); // <-- پیام خطا هم اصلاح شود
    }

    $sql = file_get_contents($sqlFile);
    $pdo->exec($sql);

    echo "Database seeded successfully.\n";

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}