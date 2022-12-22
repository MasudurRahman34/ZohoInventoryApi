<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'portal_customers';

    protected $fillable = [
        'customer_number', 'copy_bill_address', 'customer_type', 'display_name', 'company_name', 'website', 'tax_rate', 'currency', 'image', 'payment_terms', 'account_id', 'created_by', 'modified_by'
    ];
}
