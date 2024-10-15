<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name'];
    use HasFactory;

    public function roles(){
        return $this->belongsToMany(Role::class,'role_permissions');
    }
}
