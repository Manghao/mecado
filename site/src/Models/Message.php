<?php

namespace Mecado\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_list_products',
        'author',
        'msg'

    ];

    public $timestamps = true;

    public function getListProducts()
    {
        return $this->belongsTo(ListProducts::class, 'id_list_products');
    }
}
