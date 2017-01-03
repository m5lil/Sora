<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

  // protected $dates = ['publish_at'];

  protected $fillable = [
      'title',
      'content',
      'category_id',
      'status',
      'seo_title',
      'seo_description'
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
