<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage_Donation extends Model
{
    use HasFactory;

    protected $casts = [
        'date' => 'date',
    ];

    protected $table = 'donation_storage';



    public function donation()
    {
        return $this->belongsTo(Donation::class, 'donation_id','id');
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class, 'storage_item_id','item_id');
    }
}
