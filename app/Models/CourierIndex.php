<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierIndex extends Model
{
    use HasFactory;
    protected $primaryKey = 'table_id';
    protected $fillable = ['courier_id', 'name'];
    public function courier()
    {
        return $this->belongsTo(Courier::class, 'courier_id', 'table_id');
    }
}
