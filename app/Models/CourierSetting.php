<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierSetting extends Model
{
    use HasFactory;
    protected $primaryKey = 'table_id';

    protected $fillable = ['user_id', 'value', 'courier_id', 'store_id'];
    public function courier()
    {
        return $this->belongsTo(Courier::class, 'courier_id', 'table_id');
    }
}
