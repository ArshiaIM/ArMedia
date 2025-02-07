<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('armedia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // کاربر مالک فایل
            $table->string('filename'); // نام فایل ذخیره‌شده
            $table->string('path'); // مسیر فایل
            $table->string('type'); // نوع MIME فایل
            $table->bigInteger('size'); // اندازه فایل
            $table->string('related_type')->nullable();
            $table->string('related_id')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('armedia');
    }
};
