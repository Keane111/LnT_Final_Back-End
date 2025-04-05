<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
        'name',
        'invoice_id',
        'item_id',
        'quantity',
        'price',

    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function items()
    {
        return $this->belongsTo(Items::class);
    }
}