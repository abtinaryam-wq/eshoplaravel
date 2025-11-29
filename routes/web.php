<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Webkul\Core\Models\Channel;

Route::get('/emergency-install', function () {
    ini_set('max_execution_time', 300); 
    
    $output = '<div style="font-family:tahoma; direction:rtl; padding:20px;">';
    $output .= '<h1>🚀 گزارش عملیات نصب اضطراری</h1>';

    try {
        // مرحله ۱: مایگریشن
        Artisan::call('migrate', ['--force' => true]);
        $output .= '<h3 style="color:green">✅ مرحله ۱: جداول دیتابیس بررسی/ساخته شدند.</h3>';

        // مرحله ۲: سید کردن
        Artisan::call('db:seed', ['--force' => true]);
        $output .= '<h3 style="color:green">✅ مرحله ۲: اطلاعات پایه وارد شد.</h3>';

        // مرحله ۳: تنظیم آدرس
        $channel = Channel::first();
        if ($channel) {
            $oldHost = $channel->hostname;
            $channel->hostname = 'eshoplaravel.onrender.com';
            $channel->save();
            // خط اصلاح شده 👇
            $output .= "<h3 style='color:blue'>✅ مرحله ۳: آدرس کانال از <b>{$oldHost}</b> به <b>eshoplaravel.onrender.com</b> تغییر یافت.</h3>";
        } else {
            $output .= '<h3 style="color:red">❌ خطا در مرحله ۳: کانال ساخته نشد!</h3>';
        }

        // مرحله ۴: پاکسازی
        Artisan::call('optimize:clear');
        Artisan::call('view:clear');
        $output .= '<h3 style="color:green">✅ مرحله ۴: کش سیستم پاک شد.</h3>';
        
        $output .= '<hr><h2>🎉 تمام شد! حالا صفحه اصلی سایت را باز کنید.</h2>';

    } catch (\Exception $e) {
        $output .= '<h2 style="color:red">💀 عملیات با خطا مواجه شد:</h2>';
        $output .= '<pre style="direction:ltr; text-align:left; background:#eee; padding:10px;">' . $e->getMessage() . '</pre>';
    }

    $output .= '</div>';
    return $output;
});
