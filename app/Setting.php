<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Setting
 *
 * @property string $key
 * @property string $type
 * @property string $data
 * @property-read mixed $value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereType($value)
 * @mixin \Eloquent
 */
class Setting extends Model
{
    protected $fillable = [
        'key',
        'type',
        'data',
    ];

    public $timestamps = false;
    protected $primaryKey = 'key';
    protected $keyType = 'string';
    protected $hidden = [
        'data'
    ];
    protected $appends = [
        'value'
    ];

    public function getValueAttribute()
    {
        $value = null;
        switch ($this->type) {
            case 'int':
                $value = intval($this->data);
                break;
            case 'float':
                $value = doubleval($this->data);
                break;
            case 'json':
                $value = json_decode($this->data);
                break;
            default:
                $value = $this->data;
        };
        return $value;
    }
}
