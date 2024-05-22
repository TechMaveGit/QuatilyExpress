<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            $guard = $this->getGuard($request);
            switch ($guard) {
                case 'admin':
                    return route('admin');
                    break;
                default:
                    return route('admin');
                    break;
            }

            return route('admin');

            // return route('login');

        }
    }

    protected function getGuard(Request $request)
    {

        if ($request->is('admin/*')) {
            return 'admin';
        }

        if ($request->is('api/*')) {
            abort(response()->json(['status'=>false, 'error' => 'Unauthenticated.'], 401));
        }

        return 'admin';
    }
}
