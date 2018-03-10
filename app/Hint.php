<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Hint
 *
 * @property int $id
 * @property int $quest_id
 * @property string $content
 * @property int $point
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Quest $quest
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hint whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hint whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hint whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hint wherePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hint whereQuestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hint whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Hint extends Model
{
    protected $fillable = [
        'quest_id',
        'content',
        'point',
    ];

    public function quest()
    {
        return $this->belongsTo('App\Quest');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'hint_user');
    }
}
