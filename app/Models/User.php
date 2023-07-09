<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function modulePermissionArray()
    {
        return [
            'dashboard' => __('lang.dashboard'),
            'product_module' => __('lang.product_module'),
            'stock_module' => __('lang.stock_module'),
            'cashier_module' => __('lang.cashier_module'),
            'return_module' => __('lang.return_module'),
            'employee_module' => __('lang.employee_module'),
            'customer_module' => __('lang.customer_module'),
            'supplier_module' => __('lang.supplier_module'),
            'settings_module' => __('lang.settings_module'),
            'reports_module' => __('lang.reports_module'),
        ];
    }
}
