<?php

namespace Mecado\Models;

use Illuminate\Database\Eloquent\Model;

class List extends Model
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
}
