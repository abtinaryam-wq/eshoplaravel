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
use Webkul\Core\Models\Channel;
use Illuminate\Support\Facades\Artisan;

Route::get('/fix-my-db', function () {
    try {
        // 1. پیدا کردن کانال پیش‌فرض
        $channel = Channel::first();
        
        if (!$channel) {
            return "❌ هیچ کانالی در دیتابیس پیدا نشد! احتمالا دیتابیس سید نشده.";
        }

        $oldHost = $channel->hostname;
        
        // 2. تغییر هاست‌نیم به آدرس سایت شما در رندر
        // نکته: این آدرس باید دقیقا همونی باشه که سایت باهاش باز میشه
        $channel->hostname = 'eshoplaravel.onrender.com';
        $channel->save();

        // 3. پاک کردن کش‌ها برای اطمینان
        Artisan::call('optimize:clear');

        return "✅ انجام شد! <br> هاست‌نیم از <b>{$oldHost}</b> به <b>{$channel->hostname}</b> تغییر کرد. <br> کش سیستم هم پاک شد. حالا سایت اصلی رو باز کنید.";
        
    } catch (\Exception $e) {
        return "⚠️ خطا: " . $e->getMessage();
    }
});
