<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;

    protected $fillable = ['balance_id', 'uuid', 'description', 'value'];

    /**
     * @param $value
     * @return string
     */
    public function getValueAttribute($value): string
    {
        return rtrim(rtrim(bcadd($value, 0, 18), "0"), ".");
    }

}
