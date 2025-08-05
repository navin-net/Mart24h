<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $table = 'shop_infos';
    
    protected $fillable = [
        'name_shop', 'email', 'address', 'phone',
        'open_shop_time', 'close_shop', 'logo_shop',
        'description', 'facebook', 'x', 'instagram', 'youtube', 'linkedin',
    ];


}
