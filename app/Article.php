<?php

namespace App;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Filterable;
    //
    const STATUS_REPUBLISH = 2;
    const STATUS_OK = 1;
    const STATUS_DELETED = 0;

    protected $fillable = [
        'title', 'cover', 'content', 'order', 'status', 'user_id',
    ];

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
