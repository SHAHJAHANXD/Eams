<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    //
    protected $table="monitoring";

    public function employee() {
        return $this->belongsTo('App\Employee');
    }
}
