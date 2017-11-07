<?php

namespace Mecado\Models;

use Illuminate\Database\Eloquent\Model;

class Liste extends Model
{
    protected $table = 'list';

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

    public function getComments()
    {
        return $this->hasMany(Comment::class, 'id_list');
    }

    public function getProducts()
    {
        return $this->belongsToMany(Product::class, 'list_products', 'id_list', 'id_prod');
    }
}
