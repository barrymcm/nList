<?php

namespace App;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'display_name', 'description', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
