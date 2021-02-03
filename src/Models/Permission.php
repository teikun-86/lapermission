<?php

namespace AzizSama\LaPermission\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'lapermission_permissions';
    
    protected $fillable = [
        'name',
        'description',
    ];

    public $timestamps = false;
}