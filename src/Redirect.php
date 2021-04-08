<?php

namespace MasterDmx\LaravelManagedRedirect;

use Illuminate\Database\Eloquent\Model;

/**
 * MasterDmx\LaravelManagedRedirect
 *
 * @property int            $id
 * @property string         $from_url
 * @property string         $from_full_url
 * @property string         $to_url
 * @property string         $to_full_url
 * @property int            $status
 * @property string         $mark
 * @property string|null    $created_at
 * @property string|null    $updated_at
 * @method static RedirectQueryBuilder query()
 * @mixin \Eloquent
 */
class Redirect extends Model
{
    public const DB_TABLE = 'managed_redirect';

    protected $table = self::DB_TABLE;
    protected $guarded = [];

    public function getFromFullUrlAttribute()
    {
        return url($this->from_url);
    }

    public function getToFullUrlAttribute()
    {
        if (substr($this->to_url, 0, 4) !== 'http') {
            return url($this->to_url);
        }

        return $this->to_url;
    }

    public function newEloquentBuilder($query): RedirectQueryBuilder
    {
        return new RedirectQueryBuilder($query);
    }
}
