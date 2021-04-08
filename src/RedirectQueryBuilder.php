<?php

namespace MasterDmx\LaravelManagedRedirect;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

/**
 * @method static $this whereOrganizationId($value)
 * @method static EloquentCollection|Collection get()
 * @method static Redirect|null first()
 */
class RedirectQueryBuilder extends Builder
{
    /**
     * Найти по урлу
     *
     * @param string $url
     *
     * @return Redirect|null
     */
    public function findByUrl(string $url): ?Redirect
    {
        return $this->whereUrl($url)->first();
    }

    /**
     * Поиск по урлу "откуда" (from_url)
     *
     * @param string $url
     *
     * @return RedirectQueryBuilder
     */
    public function whereUrl(string $url): RedirectQueryBuilder
    {
        return $this->where('from_url', $url);
    }

    public function except(int $id)
    {
        return $this->where('id', '<>', $id);
    }
}
