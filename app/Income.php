<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'payment_date' => 'datetime',
    ];

    /**
     * Get the business location that owns the income.
     */
    public function location()
    {
        return $this->belongsTo(\App\BusinessLocation::class, 'location_id');
    }

    /**
     * Get the business that owns the income.
     */
    public function business()
    {
        return $this->belongsTo(\App\Business::class, 'business_id');
    }

    /**
     * Get the user who created the income.
     */
    public function createdBy()
    {
        return $this->belongsTo(\App\User::class, 'created_by');
    }

    /**
     * Get the tax rate for the income.
     */
    public function tax()
    {
        return $this->belongsTo(\App\TaxRate::class, 'tax_id');
    }

    /**
     * Get the income category for the income.
     */
    public function incomeCategory()
    {
        return $this->belongsTo(\App\IncomeCategory::class, 'income_category_id');
    }
}
