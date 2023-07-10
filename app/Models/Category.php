<?php

namespace App\Models;

use App\Traits\EmployeeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, EmployeeTrait;
    protected $table = 'categories';
    // protected $fillable=['name','parent_id','cover','status'];
    protected $guarded = [];
    protected $casts = ['translation' => 'array'];
    protected $appends = ['image_path'];
    //attr ********************************************************************************************************
    public function getNameAttribute($value)
    {
        if (!is_null($this->translation)) {
            if (isset($this->translation['name'][app()->getLocale()])) {
                return $this->translation['name'][app()->getLocale()];
            }
            return $value;
        }
        return $value;
    }
    public function getImagePathAttribute()
    {
        if ($this->cover) {
            return  display_file($this->cover);
        }
        return asset('no-image.jpg');
    } // end of getImagePathAttribute
    //scopes ***********************************************************************************************************************
    public function status()
    {
        return $this->status ? 'Active' : 'Inactive';
    }
    public function parentName()
    {
        return $this->parent->name ?? null;
    }
    public function created_at()
    {
        return $this->created_at->format('Y-m-d');
    }
    //rel ***********************************************************************************************************************
    public function parent()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id');
    }

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public static function parents()
    {
        return self::whereNull('parent_id')->get();
    }
    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function last_employee()
    {
        return $this->belongsTo(User::class, 'last_update');
    }
    // public $timestamps = true;

    // use SoftDeletes;
    // protected $dates = ['deleted_at'];
    // protected $fillable = array('name', 'description');

    // public function class()
    // {
    //     return $this->belongsTo('Class\Class', 'class_id');
    // }

    // public function products()
    // {
    //     return $this->hasMany('Product\Product');
    // }

}
