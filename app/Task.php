<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable= [
      'texto',
    ];

    public  function  user() {
      return  $this->belongsTo ('App\User');
    }
}
