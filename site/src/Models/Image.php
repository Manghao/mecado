<?php

namespace Mecado\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'image';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_prod',
        'name'
    ];

    public $timestamps = true;
}
