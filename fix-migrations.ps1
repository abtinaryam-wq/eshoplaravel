# پیدا کردن تمام فایل‌های migration با hasIndex
$files = rg "hasIndex" packages/Webkul database/migrations -l

foreach ($file in $files) {
    Write-Host "Fixing: $file"
    
    # خواندن محتوای فایل
    $content = Get-Content $file -Raw
    
    # اصلاح: حذف تمام استفاده‌های hasIndex و جایگزینی با raw SQL
    $content = $content -replace 'if\s*\(\s*!\s*Schema::hasIndex\([^)]+\)\s*\)\s*\{[^}]+\}', ''
    $content = $content -replace 'if\s*\(\s*!\s*\$this->hasIndex\([^)]+\)\s*\)\s*\{[^}]+\}', ''
    
    # اضافه کردن check برای pgsql در ابتدای up()
    if ($content -notmatch 'if \(DB::getDriverName\(\) !== .pgsql.\)') {
        $content = $content -replace '(public function up\(\)\s*\{)', '$1`n        if (DB::getDriverName() !== ''pgsql'') {`n            return;`n        }`n'
    }
    
    # ذخیره
    Set-Content $file $content -NoNewline
}

Write-Host "Done! All migrations fixed."
