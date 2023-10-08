<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'interes',
    ];

    /**
     * Get the users associated with this profile.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
