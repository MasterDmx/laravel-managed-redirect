<?php

namespace MasterDmx\LaravelManagedRedirect;

use Closure;
use Illuminate\Http\Request;

class RedirectMiddleware
{
    private RedirectManager $manager;

    /**
     * RedirectMiddleware constructor.
     *
     * @param RedirectManager $manager
     */
    public function __construct(RedirectManager $manager)
    {
        $this->manager = $manager;
    }

    public function handle(Request $request, Closure $next)
    {
        $redirect = $this->manager->findRedirect($request->path());

        if (!isset($redirect)) {
            return $next($request);
        }

        return redirect($redirect->to_url, $redirect->status);
    }
}
