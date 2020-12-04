<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $table = 'roles';

    protected $fillable = ['name', 'display_name', 'description', 'created_at', 'updated_at'];

    public function role() 
    {
    	return $this->belongsTo(UserRole::class);
    }
}
