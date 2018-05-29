<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Contest
 *
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property \Carbon\Carbon|null $start_at
 * @property \Carbon\Carbon|null $end_at
 * @property bool $protect
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Quest[] $quests
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contest whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contest whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contest whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contest whereProtect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contest whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Contest extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'start_at',
        'end_at',
        'protect',
    ];

    protected $dates = [
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'protect' => 'boolean',
    ];

    public function quests()
    {
        return $this->hasMany('App\Quest');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_contest');
    }
}
