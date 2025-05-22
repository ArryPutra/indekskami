<?php

namespace App\Models\Manajemen;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Manajemen extends Model
{
    protected $table = 'manajemen';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
