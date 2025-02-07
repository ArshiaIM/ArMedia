<?php

namespace Modules\ArMedia\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\ArMedia\Database\Factories\ArmediaFactory;

class Armedia extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['user_id','path','filename','type','size','related_type','related_id'];

    // protected static function newFactory(): ArmediaFactory
    // {
    //     // return ArmediaFactory::new();
    // }
}
