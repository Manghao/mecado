<?php

namespace Mecado\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_list',
        'author',
        'msg'

    ];

    public $timestamps = true;
}
