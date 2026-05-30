<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DimLocation extends Model
{
    use HasFactory;

    protected $table = 'dim_location';

public function sales()
{
    return $this->hasMany(FactSales::class, 'location_id');
}
}
