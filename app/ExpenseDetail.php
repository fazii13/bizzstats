<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseDetail extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the transaction that owns the expense detail.
     */
    public function transaction()
    {
        return $this->belongsTo(\App\Transaction::class, 'transaction_id');
    }

    /**
     * Get the location for the expense detail.
     */
    public function location()
    {
        return $this->belongsTo(\App\BusinessLocation::class, 'location_id');
    }

    /**
     * Get the tax rate for the expense detail.
     */
    public function tax()
    {
        return $this->belongsTo(\App\TaxRate::class, 'tax_id');
    }
}
