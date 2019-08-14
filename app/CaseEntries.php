<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CaseEntries extends Authenticatable
{
    use Notifiable;

    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'case_entries';
    protected $fillable = array(
        'id',
        'date',
        'coram',
        'stage',
        'next_date',
        'comments',
        'attachment',
        'case_id',
        'created_at',
        'updated_at'
    );

    public $timestamps = false;



    public function cases() {
        return $this->belongsTo('App\Cases', 'case_id');
    }
}
