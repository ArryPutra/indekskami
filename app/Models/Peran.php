<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peran extends Model
{
    protected $table = 'peran';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Peran
    const PERAN_SUPERADMIN = 'Superadmin';
    const PERAN_ADMIN = 'Admin';
    const PERAN_RESPONDEN = 'Responden';
    const PERAN_VERIFIKATOR = 'Verifikator';
    const PERAN_MANAJEMEN = 'Manajemen';

    const PERAN_SUPERADMIN_ID = 1;
    const PERAN_ADMIN_ID = 2;
    const PERAN_RESPONDEN_ID = 3;
    const PERAN_VERIFIKATOR_ID = 4;
    const PERAN_MANAJEMEN_ID = 5;

    public static function getPeranOptions()
    {
        return [
            self::PERAN_SUPERADMIN,
            self::PERAN_ADMIN,
            self::PERAN_RESPONDEN,
            self::PERAN_VERIFIKATOR,
            self::PERAN_MANAJEMEN,
        ];
    }
}
