<?php

namespace Mecado\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'descr',
        'url',
        'price',
        'reserve',
        'user_reserve',
        'custom_product'


    ];

    public $timestamps = true;
}
