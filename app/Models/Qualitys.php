<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualitys extends Model
{
    use HasFactory;
    protected $fillable = ['name','description'];
}
