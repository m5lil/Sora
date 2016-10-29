<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = array(
      'title',
      'content',
      'status',
      'seo_title',
      'seo_description'
    );

}
