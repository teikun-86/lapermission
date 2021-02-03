<?php

namespace AzizSama\LaPermission\Models;

use AzizSama\LaPermission\Traits\HasPermission;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasPermission;
    
    protected $table = "lapermission_roles";
    
    protected $fillable = [
        'name',
        'description',
    ];

    public $timestamps = false;
}
