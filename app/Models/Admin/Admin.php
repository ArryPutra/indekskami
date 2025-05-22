<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
