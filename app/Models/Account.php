<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['cedula', 'nombre', 'saldo', 'profile_id'];


    /**
     * Define a one-to-many relationship.
     *
     * @return HasMany
     */
    public function transfers()
    {
        return $this->hasMany(Transfer::class, 'origin_account_id');
    }

    /**
     * Define an inverse one-to-one or many relationship.
     *
     * @return BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    /**
     * Define a one-to-many relationship.
     *
     * @return HasMany
     */
    public function reports()
    {
        return $this->hasMany(Report::class, 'id_user');
    }

    /**
     * Find the user's ID by their cedula.
     *
     * @param  string $cedula The cedula to search for.
     * @return int|null       The user's ID or null if not found.
     */
    public static function findIdByCedula($cedula)
    {
        return self::where('cedula', $cedula)->value('id');
    }
}
