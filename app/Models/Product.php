<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'currency',
        'inventory',
        'store_id',
        'import_at'
    ];

    public function store()
    {
        return $this->hasOne(Store::class, 'id', 'store_id');
    }
}
