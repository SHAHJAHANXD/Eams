<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table="notification";
    protected $fillable=['subject','body','notification_to','notification_by'];


    public function notificationTo() {
        return $this->belongsTo('App\Users');
    }

    public function notificationBy() {
        return $this->belongsTo('App\Users');
    }

}
