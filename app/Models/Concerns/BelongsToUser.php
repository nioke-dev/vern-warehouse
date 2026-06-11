<?php

namespace App\Models\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * Membuat sebuah model menjadi milik per-user (multi-tenant).
 *
 * - Saat menampilkan data: otomatis difilter `where user_id = user yang login`
 *   lewat Global Scope, jadi data user lain tidak akan ikut tampil.
 * - Saat membuat data: kolom `user_id` otomatis diisi dengan user yang login.
 *
 * Catatan: filter hanya aktif ketika ada user yang login (web request).
 * Saat seeding / console (tanpa auth) data tidak difilter agar seeder tetap jalan.
 */
trait BelongsToUser
{
    protected static function bootBelongsToUser(): void
    {
        // Filter otomatis semua query berdasarkan user yang sedang login.
        static::addGlobalScope('user', function (Builder $builder) {
            if (Auth::check()) {
                $builder->where($builder->getModel()->getTable() . '.user_id', Auth::id());
            }
        });

        // Isi user_id otomatis saat membuat record baru.
        static::creating(function ($model) {
            if (Auth::check() && empty($model->user_id)) {
                $model->user_id = Auth::id();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
