<?php

namespace Mecado\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';

    protected $primaryKey = 'id';

    protected $fillable = [
        'last_name',
        'first_name',
        'mail',
        'password',
        'token'
    ];

    public $timestamps = true;

    public function getLists()
    {
        return $this->hasMany(Liste::class, 'id_creator');
    }
}