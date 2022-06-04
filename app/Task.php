<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $fillable=['title','description','assignee','status','deadline','is_active','created_by'];

    public function employee(){
        return $this->belongsTo(Employee::class,'assignee');
    }
}
