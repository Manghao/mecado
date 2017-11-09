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

    public function getImages()
    {
        return $this->hasMany(Image::class, 'id_prod');
    }

    public function getLists()
    {
        return $this->belongsToMany(Liste::class, 'list_products', 'id_prod', 'id_list');
    }

    public function getMessage() {
        return $this->belongsTo(ListProducts::class, 'message', 'id_list_products');
    }
}
