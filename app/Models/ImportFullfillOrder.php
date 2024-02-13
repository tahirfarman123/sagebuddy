<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportFullfillOrder extends Model
{
    use HasFactory;
    // protected $fillables = ['order_number'];
    protected $fillable = ['barcode', 'trackingid', 'tracking_url'];
}
