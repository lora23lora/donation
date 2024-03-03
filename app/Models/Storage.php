<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use HasFactory;

    protected $primaryKey = "item_id";


    protected $fillable = [
        'item_name',
        'qty',
        'price',
        'total',
        'date'
    ];


    protected $casts = [
        'date' => 'date',

    ];

    public function category()
    {
        return $this->belongsTo(ItemCategory::class, 'id','item_category');
    }
}
