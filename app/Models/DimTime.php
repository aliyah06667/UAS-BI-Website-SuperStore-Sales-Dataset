<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DimTime extends Model
{
    use HasFactory;

    protected $table = 'dim_time';

public function sales()
{
    return $this->hasMany(FactSales::class, 'time_id');
}
}
