<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DimProduct extends Model
{
    use HasFactory;

    protected $table = 'dim_product';

    protected $fillable = [
        'product_name',
        'category',
        'sub_category'
    ];

    public function sales()
    {
        return $this->hasMany(FactSales::class, 'product_id');
    }
}