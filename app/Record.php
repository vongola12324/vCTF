<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Record
 *
 * @property int $id
 * @property int $quest_id
 * @property int $user_id
 * @property string $flag
 * @property int $correct
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Quest $quest
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereCorrect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereQuestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereUserId($value)
 * @mixin \Eloquent
 */
class Record extends Model
{
    protected $fillable = [
        'quest_id',
        'user_id',
        'flag',
        'correct',
    ];

    protected $casts = [
        'correct' => 'boolean'
    ];

    public function quest()
    {
        return $this->belongsTo('App\Quest');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
