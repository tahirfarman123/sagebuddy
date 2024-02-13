<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    use HasFactory;
    protected $primaryKey = 'table_id';
    protected $fillable = ['name', 'key', 'image', 'status'];
    public function courierSettings()
    {
        return $this->hasMany(CourierSetting::class, 'courier_id', 'table_id');
    }
    public function courierIndex()
    {
        return $this->hasMany(CourierIndex::class, 'courier_id', 'table_id');
    }
}
