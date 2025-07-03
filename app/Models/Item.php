<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'qty',
        'unit',
    ];

    public function stockCards()
    {
        return $this->hasMany(StockCard::class);
    }
}
