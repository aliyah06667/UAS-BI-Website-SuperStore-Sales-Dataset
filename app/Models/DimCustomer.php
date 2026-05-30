<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DimCustomer extends Model
{
    use HasFactory;

    protected $table = 'dim_customer';

public function sales()
{
    return $this->hasMany(FactSales::class, 'customer_id');
}
}
