<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    // use HasFactory;
    use SoftDeletes;

    public $table = 'category';

    // this field must type date yyyy-mm-dd HH:mm:ss
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // one to many table product
    public function product()
    {
        return $this->hasMany('App\Models\Product', 'product_category_id');
    }
}
