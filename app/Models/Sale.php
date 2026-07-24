<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'invoice_no', 'customer_name', 'customer_phone', 'sale_date', 'total_amount', 'payment_method', 'payment_reference'
    ];

    protected $casts = ['sale_date' => 'date'];

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
