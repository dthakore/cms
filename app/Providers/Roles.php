<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'roles';
    protected $fillable = array(
        'name',
        'guard_name',
        'created_at',
        'updated_at'

    );

}
