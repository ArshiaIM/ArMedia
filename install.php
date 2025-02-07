<?php

echo "🚀 نصب ماژول در حال انجام است...\n";

// اجرای دستورات نصب
$commands = [
    "composer install", // نصب وابستگی‌ها
    "php artisan module:enable Armedia", // فعال‌سازی ماژول
    "php artisan migrate --path=Modules/Armedia/Database/Migrations", // اجرای مایگریشن‌ها
    "php artisan module:publish Armedia", // انتشار تنظیمات و assets
    "composer dump-autoload", // به‌روزرسانی autoload
];

// اجرای دستورات
foreach ($commands as $command) {
    echo "▶ اجرای: $command\n";
    $output = shell_exec($command);
    echo $output . "\n";
}

echo "✅ نصب ماژول با موفقیت انجام شد!\n";
