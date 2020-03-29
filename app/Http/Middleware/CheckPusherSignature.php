<?php


namespace App\Http\Middleware;


class CheckPusherSignature
{
    /**
     * Handle an incoming request
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $secret = config(‘pusher . secret’);
        $signature = $request->header(‘X_PUSHER_SIGNATURE’);

        $signature = new Signature($secret, $signature, $request->all());

        if (!$signature->isValid()) {
            throw new PreconditionFailedException(‘invalid_webhook_signature’);
        }

        return $next($request);
    }
}
