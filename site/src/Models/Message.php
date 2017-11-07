<?php

namespace Mecado\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_list_product',
        'author',
        'msg'

    ];

    public $timestamps = true;
}
