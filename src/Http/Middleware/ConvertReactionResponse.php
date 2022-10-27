<?php

namespace Firefly\Http\Middleware;


use Closure;
use Firefly\Features;
use Firefly\Models\Reaction;
use Illuminate\Http\Request;

class ConvertReactionResponse
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
        /**
         * @var \Illuminate\Http\Response $response
         */
        $response = $next($request);

        if ( Features::option('reactions','convert') ) {
            $emojis = json_decode($response->getContent());
            $converted = Reaction::convertReactions($emojis);

            $response->setContent($converted);
        }

        return $response;
    }
}
