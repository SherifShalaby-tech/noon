<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model 
{

    protected $table = 'brands';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name','deleted_by','edited_by','created_by');

    public function products()
    {
        return $this->hasMany('Product\Product');
    }

}