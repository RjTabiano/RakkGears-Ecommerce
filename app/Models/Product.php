<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'stock_quantity',
        'image_path',
    ];

    public function orderItems() {
        return $this->hasMany(OrderItem::class); 
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
