<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerContactDetails extends Model
{
    use SoftDeletes;

    protected $fillable = ['customer_id','phone', 'address_1',
        'address_2', 'address_3', 'city', 'county', 'post_code', 'country', 'created_at'
    ];

    protected $dates = ['deleted_at'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
