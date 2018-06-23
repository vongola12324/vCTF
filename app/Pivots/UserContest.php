<?php

namespace App\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserContest extends Pivot
{
    protected $casts = [
        'is_admin'  => 'bool',
        'is_hidden' => 'bool',
    ];
}