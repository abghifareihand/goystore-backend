<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'transaction_id',
        'quantity',

    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }

    // relasi ke table product satu
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
