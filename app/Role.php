<?php

namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
  protected $fillable = [
      'name', 'display_name', 'display_name'
  ];
}
