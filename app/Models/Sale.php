<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

        protected $fillable = ['customer_id', 'total_amount', 'status', 'date'];

     Public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
