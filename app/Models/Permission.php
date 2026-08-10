<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
    // 🔥 Normaliza SIEMPRE a minúscula
    //public function setNameAttribute($value)
    //{
     //   $this->attributes['name'] = strtolower($value);
    //}
}
