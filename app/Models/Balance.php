<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{

    protected $fillable = ['user_id', 'balance'];


    /**
     * @param $value
     * @return string
     */
    public function getBalanceAttribute($value): string
    {
        return rtrim(rtrim(bcadd($value, 0, 18), "0"), ".");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function operations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Operation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lastFiveOperations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Operation::class)->orderBy('id', 'desc')->limit(5);
    }
}
