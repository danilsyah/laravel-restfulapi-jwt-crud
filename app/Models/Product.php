<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    // use HasFactory;
    use SoftDeletes;

    public $table = 'product';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'id',
        'product_category_id',
        'name',
        'price',
        'image',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // one to many table category
    public function category(){
        return $this->belongsTo('App\Models\Category', 'product_category_id','id');
    }
}
