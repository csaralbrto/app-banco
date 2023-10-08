<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = ['origin_account_id', 'destination_account_id', 'valor'];

    /**
     * Define an inverse one-to-one or many relationship.
     *
     * @return BelongsTo
     */
    public function originUser()
    {
        return $this->belongsTo(Account::class, 'origin_account_id');
    }

}
