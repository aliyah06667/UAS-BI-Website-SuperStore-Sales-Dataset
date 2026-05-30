<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactSales extends Model
{
    use HasFactory;

    public function product()
{
    return $this->belongsTo(DimProduct::class, 'product_id');
}
}
