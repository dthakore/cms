<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Cases extends Authenticatable
{
    use Notifiable;

    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'cases';
    protected $fillable = array(
        'id',
        'case_number',
        'complainant_name',
        'complainant_details',
        'date_of_filing',
        'court',
        'stage',
        'next_date',
        'comments',
        'user_id',
        'created_at',
        'updated_at'
    );

    public $timestamps = false;




    public function entry() {
        return $this->hasMany('App\CaseEntries','case_id');
    }

    public function attachment() {
        return $this->hasMany('App\CaseAttachments', 'case_id');
    }

    public function client() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
