<?php

namespace App\Models\Verifikator;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Verifikator extends Model
{
    protected $table = 'verifikator';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
