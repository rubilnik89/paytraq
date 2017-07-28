<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type', 'status', 'reg_number', 'vat_number', 'address', 'zip', 'country', 'phone',
        'group_id', 'paytraq_id', 'contract_number', 'credit_limit', 'deposit', 'discount', 'pay_term_type', 'pay_term_days',
        'products_tax_key_id', 'services_tax_key_id', 'wrhID', 'price_group_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
