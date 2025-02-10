<?php

namespace Modules\ArMedia\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

// use Modules\ArMedia\Database\Factories\ArmediaFactory;

class Armedia extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['user_id', 'path', 'filename', 'type', 'size', 'related_type', 'related_id'];

    // protected static function newFactory(): ArmediaFactory
    // {
    //     // return ArmediaFactory::new();
    // }

    public static array $models = [
        // 'profile' => \App\Models\Users::class,
        // 'post'    => \App\Models\Post::class,
        'product' => \App\Models\Product::class,
        // 'banner'  => \App\Models\Banner::class,
    ];

    public function uploadable(): MorphTo
    {
        return $this->morphTo();
    }

    // تابعی که مسیر کامل فایل را برمی‌گرداند
    public function getUrlAttribute(): string
    {
        return asset($this->file_path);
    }

    public static function getImageFor($model, $modelId)
    {
        if (array_key_exists($model, self::$models)) {
            $upload = self::where('related_type', $model)
                ->where('related_id', $modelId)
                ->first();
        }


        return $upload ? $upload->path : public_path('default.png');
    }
}
