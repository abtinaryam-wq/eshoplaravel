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
use Illuminate\Support\Facades\DB;
use Webkul\Core\Models\Channel;

Route::get('/final-fix', function () {
    ini_set('max_execution_time', 300); // افزایش زمان اجرا
    
    $output = '<div style="font-family:sans-serif; direction:ltr; padding:20px; line-height:1.6;">';
    $output .= '<h1>🚀 Final Emergency Database Fix</h1><hr>';

    try {
        // 1. Force Migrate
        Artisan::call('migrate', ['--force' => true]);
        $output .= '<div style="color:green">✔ Migrations ran successfully.</div>';

        // 2. Run Specific Bagisto Seeders (Core & Shop)
        // این قسمت مهم‌ترین تغییره: فراخوانی مستقیم سیدرهای باگیستو
        try {
            Artisan::call('db:seed', ['--class' => 'Webkul\Core\Database\Seeders\DatabaseSeeder', '--force' => true]);
            Artisan::call('db:seed', ['--class' => 'Webkul\Shop\Database\Seeders\DatabaseSeeder', '--force' => true]);
            $output .= '<div style="color:green">✔ Bagisto Seeders ran successfully.</div>';
        } catch (\Exception $e) {
            $output .= '<div style="color:orange">⚠ Seeders warning: ' . $e->getMessage() . '</div>';
        }

        // 3. Find or Create Channel (The Critical Part)
        // تلاش برای پیدا کردن کانال
        $channel = Channel::first();
        
        // اگر کانال نبود، دستی می‌سازیم (روش Raw SQL برای اطمینان ۱۰۰٪)
        if (!$channel) {
            $output .= '<div style="color:blue">ℹ No channel found via Eloquent. Attempting Raw SQL injection...</div>';
            
            // ساخت زبان فارسی اگر نباشه
            DB::table('locales')->insertOrIgnore([
                'id' => 1, 'code' => 'fa', 'name' => 'Persian', 'direction' => 'rtl', 'created_at' => now(), 'updated_at' => now()
            ]);
            
            // ساخت واحد پول اگر نباشه
            DB::table('currencies')->insertOrIgnore([
                'id' => 1, 'code' => 'USD', 'name' => 'US Dollar', 'symbol' => '$', 'created_at' => now(), 'updated_at' => now()
            ]);

            // ساخت کانال پیش‌فرض
            $channelId = DB::table('channels')->insertGetId([
                'code' => 'default',
                'name' => 'Default Channel',
                'hostname' => 'eshoplaravel.onrender.com', // آدرس دقیق سایت شما
                'default_locale_id' => 1,
                'base_currency_id' => 1,
                'root_category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // اتصال جدول‌های واسط
            DB::table('channel_locales')->insertOrIgnore(['channel_id' => $channelId, 'locale_id' => 1]);
            DB::table('channel_currencies')->insertOrIgnore(['channel_id' => $channelId, 'currency_id' => 1]);
            DB::table('channel_inventory_sources')->insertOrIgnore(['channel_id' => $channelId, 'inventory_source_id' => 1]);

            $output .= "<h3 style='color:green'>✔ SUCCESS: Channel created manually with ID: {$channelId}</h3>";
        } else {
            // اگر کانال بود، فقط آدرسش رو آپدیت می‌کنیم
            $oldHost = $channel->hostname;
            $channel->hostname = 'eshoplaravel.onrender.com';
            $channel->save();
            $output .= "<h3 style='color:green'>✔ SUCCESS: Existing channel updated from '{$oldHost}' to 'eshoplaravel.onrender.com'</h3>";
        }

        // 4. Clear Cache
        Artisan::call('optimize:clear');
        Artisan::call('view:clear');
        $output .= '<div style="color:green">✔ System cache cleared.</div>';
        
        $output .= '<hr><h2>🎉 DONE! Go to your homepage now.</h2>';

    } catch (\Exception $e) {
        $output .= '<h2 style="color:red">💀 CRITICAL ERROR:</h2>';
        $output .= '<pre style="background:#eee; padding:10px;">' . $e->getMessage() . '</pre>';
        $output .= '<pre style="background:#eee; padding:10px;">' . $e->getTraceAsString() . '</pre>';
    }

    $output .= '</div>';
    return $output;
});
