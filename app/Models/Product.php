<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'category_id',
        'title',
        'description',
        'price',
        'discount',
        'shipping_fee',
        'discount_start',
        'discount_end',
        'stock',
        'product_status',
        'created_at',
        'updated_at',
    ];

    public function images() {
        return $this->hasMany(ProductImage::class);
    }
    public function category() {
        return $this->belongsTo(Category::class)->withTrashed();
    }
}
