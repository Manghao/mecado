<?php

namespace Mecado\Models;

use Illuminate\Database\Eloquent\Model;

class ListProducts extends Model
{
    protected $table = 'list_products';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'descr',
        'dateExp',
        'id_prod',
        'url_share',
        'id_creator',
        'other_dest'

    ];

    public $timestamps = true;

    public function getMessage()
    {
        return $this->belongsTo(Message::class, 'id_list_products');
    }

    public function getLists()
    {
        return $this->hasMany(Liste::class, 'id_list');
    }

    public function getProducts()
    {
        return $this->hasMany(Product::class, 'id_prod');
    }
}
