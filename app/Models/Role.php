<?php

namespace App\Models;

use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    
   // public function setNameAttribute($value)
   // {
  //      $this->attributes['name'] = strtolower($value);
   // }// Guardamos siempre en minúscula internamente
}