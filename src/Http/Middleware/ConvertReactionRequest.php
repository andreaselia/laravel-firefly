<?php

namespace Firefly\Http\Middleware;

use Closure;
use Firefly\Features;
use Firefly\Models\Reaction;
use Illuminate\Http\Request;

class ConvertReactionRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Features::option('reactions', 'convert')) {
            $values = $request->all();

            if (array_key_exists('reaction', $values) && is_string($values['reaction'])) {
                $values['reaction'] = Reaction::encode($values['reaction']);
            }

            $request->replace($values);
        }

        return $next($request);
    }
}
