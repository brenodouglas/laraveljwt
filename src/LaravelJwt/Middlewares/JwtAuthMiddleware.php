<?php
namespace LaravelJwt\Middlewares;

use Closure;

use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Builder;

class JwtAuthMiddleware
{
    /**
     * Handle an incoming reques And verify if token exists and is valid
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('access-token');

        $token = isset($token) ? $request->header('access-token') : $request->get('access-token');

        if (!$token)
            return response('Unauthorized.', 403);

        $key = config('jwt.key');

        $signer = new Sha256();
        $data = new ValidationData(); // It will use the current time to validate (iat, nbf and exp)
        $data->setIssuer(config('jwt.host'));
        $data->setAudience($request->server('REMOTE_ADDR'));

        try {
            $token = (new Parser())->parse((string)$token);

            if (!$token->validate($data))
                return response('Unauthorized data', 401);

            if (!$token->verify($signer, $key))
                return response('Unauthorized sign', 401);

            putenv("USER=" . $token->getClaim('uid'));

            return $next($request);
        } catch (\Exception $e) {
            return response('Unauthorized: ' . $e->getMessage(), 403);
        }
    }

    public function terminate($request, $response)
    {
        $key = config('jwt.key');
        $signer = new Sha256();
        $token = (new Builder())->setIssuer(config('jwt.host'))
            ->setAudience($request->server('REMOTE_ADDR'))
            ->setIssuedAt(time())
            ->setNotBefore(time())
            ->setExpiration(time() + 3600)
            ->set('uid', getenv('USER'))
            ->sign($signer, $key)
            ->getToken();

        $response->withCookie(new Cookie("TOKEN", $token->__toString()));

        return $response;
    }
}
