<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

  protected $dates = ['publish_at'];


      protected $sortable = [
          'id',
          'category_id',
          'title',
          'status',
          'created_at',
          'publish_at',
      ];

      public function category()
      {
          return $this->belongsTo('App\Category');
      }

      public function comments()
      {
          return $this->hasMany('App\Comments', 'post_id');
      }



}
