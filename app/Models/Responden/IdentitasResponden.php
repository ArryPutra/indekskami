<?php

namespace App\Models\Responden;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class IdentitasResponden extends Model
{
    protected $table = 'identitas_responden';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
