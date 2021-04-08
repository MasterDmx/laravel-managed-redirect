<?php

namespace MasterDmx\LaravelManagedRedirect;

use Illuminate\Support\Str;

class RedirectManager
{
    /**
     * Найти редирект
     *
     * @param string $requestPath
     *
     * @return Redirect|null
     */
    public function findRedirect(string $requestPath)
    {
        return Redirect::query()->findByUrl($requestPath);
    }

    /**
     * Получить все редиректы
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function getAll()
    {
        return Redirect::query()->orderBy('id', 'desc')->get();
    }

    /**
     * Создать редирект
     *
     * @param string      $from
     * @param string      $to
     * @param int|null    $status
     * @param string|null $mark
     *
     * @return Redirect
     */
    public function create(string $from, string $to, ?int $status = 301, ?string $mark = ''): Redirect
    {
        return Redirect::create([
            'from_url' => $this->removeDomainFromUrl($from),
            'to_url' => $this->removeDomainFromUrl($to),
            'status' => $status ?? 301,
            'mark' => $mark ?? '',
        ]);
    }

    /**
     * Изменить редирект
     *
     * @param Redirect    $redirect
     * @param string      $from
     * @param string      $to
     * @param int|null    $status
     * @param string|null $mark
     *
     * @return bool
     */
    public function update(Redirect $redirect, string $from, string $to, ?int $status = 301, ?string $mark = ''): bool
    {
        $redirect->from_url = $this->removeDomainFromUrl($from);
        $redirect->to_url = $this->removeDomainFromUrl($to);
        $redirect->status = $status ?? 301;
        $redirect->mark = $mark ?? '';

        return $redirect->save();
    }

    /**
     * Удалить редирект
     *
     * @param int|Redirect $entity
     *
     * @return mixed
     */
    public function remove($redirect)
    {
        return $redirect->delete();
    }

    /**
     * Проверить существование редиректа
     *
     * @param string   $url
     * @param int|null $except
     *
     * @return bool
     */
    public function checkExist(string $url, ?int $except = null): bool
    {
        $url = $this->removeDomainFromUrl($url);

        if (isset($except)) {
            return Redirect::query()->whereUrl($url)->except($except)->exists();
        }

        return Redirect::query()->whereUrl($url)->exists();
    }

    /**
     * Удалить текущий домен из урла
     *
     * @param string $url
     *
     * @return false|string
     */
    public function removeDomainFromUrl(string $url)
    {
        if (Str::contains($url, config('app.url'))) {
            $url = Str::replaceFirst(config('app.url'), '', $url);
        }

        if (substr($url, 0, 1) === '/' && strlen($url) > 1) {
            $url = substr($url, 1);
        }

        return $url;
    }
}
