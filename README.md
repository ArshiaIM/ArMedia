# ArMedia
# نصب و راه‌اندازی ماژول Armedia برای لاراول

این مستند راهنمای نصب و استفاده از ماژول `Armedia` برای پروژه لاراول است.

## پیش‌نیازها

قبل از شروع نصب ماژول، مطمئن شوید که موارد زیر را در پروژه خود نصب کرده‌اید:
- [PHP](https://www.php.net/) نسخه 7.4 یا بالاتر
- [Composer](https://getcomposer.org/)
- [Laravel](https://laravel.com/) نسخه 8 یا بالاتر
- [nwidart](https://nwidart.com/)پیش از استفاده از ماژول حتما nwidart رو نصب و تنظیمات اون رو کامل کنید.

## نصب ماژول

برای نصب ماژول `Armedia` در پروژه لاراول خود، مراحل زیر را دنبال کنید:

### 1. اجرای اسکریپت نصب

ابتدا اسکریپت زیر را اجرا کنید که تمام مراحل نصب ماژول را به‌صورت خودکار انجام می‌دهد:

```bash
php install.php
```

```php
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
```


## خطا های اسکریپت
اگر در اجرای اسکریپت با خطا مواجه شدید ، یکی یکی کامند هارا بررسی کنید.

```bash
composer install
php artisan module:enable Armedia
php artisan migrate --path=Modules/Armedia/Database/Migrations
php artisan module:publish Armedia
composer dump-autoload
```
