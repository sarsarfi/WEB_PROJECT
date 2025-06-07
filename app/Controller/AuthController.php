<?php
namespace App\Controller;

use App\Model\User;

class AuthController
{
    public static function login()
    {
        if (self::isLoggedIn()) {
            redirect('/web_project/home'); // مسیر صحیح ریدایرکت
        }
        view('auth/login.php'); // مسیر view
    }

    public static function register()
    {
        if (self::isLoggedIn()) {
            redirect('/web_project/home'); // مسیر صحیح ریدایرکت
        }
        view('auth/register.php'); // مسیر view
    }

    public static function storeUser()
    {
        if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])) {
            $_SESSION['error'] = 'لطفا تمام فیلدها را پر کنید';
            redirect('/web_project/register');
            return;
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'فرمت ایمیل نامعتبر است';
            redirect('/web_project/register');
            return;
        }

        if (User::where('email', $_POST['email'])->exists()) {
            $_SESSION['error'] = 'این ایمیل قبلا ثبت شده است';
            redirect('/web_project/register');
            return;
        }

        $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
        if (!$hashedPassword) {
            $_SESSION['error'] = 'خطا در ایجاد رمز عبور';
            redirect('/web_project/register');
            return;
        }

        $user = User::create([
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $hashedPassword
        ]);

        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['success'] = 'ثبت‌نام با موفقیت انجام شد';

        redirect('/web_project/home');
    }

    public static function loginUser()
    {
        if (empty($_POST['email']) || empty($_POST['password'])) {
            $_SESSION['error'] = 'لطفا ایمیل و رمز عبور را وارد کنید';
            redirect('/web_project/login');
            return;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = User::where('email', $email)->first();

        if (!$user) {
            $_SESSION['error'] = 'کاربری با این ایمیل یافت نشد';
            redirect('/web_project/login');
            return;
        }

        if (!password_verify($password, $user->password)) {
            $_SESSION['error'] = 'رمز عبور نادرست است';
            redirect('/web_project/login');
            return;
        }

        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;
        
        $_SESSION['success'] = 'با موفقیت وارد شدید';
        redirect('/web_project/home');
    }

    private static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public static function logout()
    {
        session_unset();
        session_destroy();
        redirect('/web_project/login');
    }
}