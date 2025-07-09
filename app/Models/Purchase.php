<?php

namespace App\Models;

use App\Models\PurchaseItem;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['supplier_id', 'total_amount', 'date','status'];

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
