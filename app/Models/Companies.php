<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Groups;
use App\Models\Warehouses;


class Companies extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'group_id', 'group_name', 
    'email', 'phone','city','number_of_houses','address','street',
    'warehouse_id','note','logo'];

    public function group(){
        return $this->belongsTo(Groups::class, 'group_id'); 
    }

    public function warehouse(){
        return $this->belongsTo(Warehouses::class, 'warehouse_id');
    }





}
