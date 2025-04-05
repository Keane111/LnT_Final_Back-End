<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'price',
        'quantity',
        'photo',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
