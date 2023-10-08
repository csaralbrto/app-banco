<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['tipo', 'monto', 'id_account', 'saldo'];

    /**
     * Define an inverse one-to-one or many relationship.
     *
     * @return BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'id_account');
    }


    /**
     * Method to filter by date range
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $startDate
     * @param string $endDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Method to filter reports by client name.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $clientName
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByClientName($query, $clientName)
    {
        return $query->whereHas('account', function ($subquery) use ($clientName) {
            $subquery->where('nombre', 'like', '%' . $clientName . '%');
        });
    }

    /**
     * Method to filter reports by account ID.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $accountId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByAccountId($query, $accountId)
    {
        return $query->where('id_account',$accountId);
    }
}
