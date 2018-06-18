<?php

namespace App;

use Bnb\Laravel\Attachments\HasAttachment;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Quest
 *
 * @property int $id
 * @property int $contest_id
 * @property string $category
 * @property string $title
 * @property string $content
 * @property string $flag
 * @property int $flag_type
 * @property int $point
 * @property int $seq
 * @property bool $hidden
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Bnb\Laravel\Attachments\Attachment[] $attachments
 * @property-read \App\Contest $contest
 * @property-read mixed $content_html
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Hint[] $hints
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Record[] $records
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereContestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereFlagType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest wherePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereSeq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Quest extends Model
{

    use HasAttachment;

    protected $fillable = [
        'contest_id',
        'category',
        'title',
        'content',
        'flag',
        'flag_type',
        'point',
        'seq',
        'hidden'
    ];

    protected $casts = [
        'hidden' => 'boolean'
    ];

    protected $appends = [
        'content_html'
    ];

    protected $hidden = [
        'content',
        'flag',
        'flag_type'
    ];

    public function contest()
    {
        return $this->belongsTo('App\Contest');
    }

    public function records()
    {
        return $this->hasMany('App\Record');
    }

    public function hints()
    {
        return $this->hasMany('App\Hint');
    }

    public function getContentHtmlAttribute()
    {
        return Markdown::convertToHtml($this->content);
    }
}
