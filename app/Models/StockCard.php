<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockCard extends Model
{
    protected $fillable = [
        'item_id',
        'qty',
        'note',
        'description',
    ];
}
