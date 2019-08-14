<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CaseAttachments extends Authenticatable
{
    use Notifiable;

    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'case_attachments';
    protected $fillable = array(
        'id',
        'attachment',
        'comments',
        'case_id',
        'created_at',
        'updated_at'
    );

    public $timestamps = false;




    public function case() {
        return $this->belongsTo('App\Cases','case_id');
    }
}
