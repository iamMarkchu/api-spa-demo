<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'order', 'status', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
