<?php
namespace LaravelJwt\Service;

use Illuminate\Http\Request;
use Auth;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Builder;

class JwtAuth
{
    public function authenticate(Request $request)
    {
        $credentials = $request->json()->all();

        if (!$user = Auth::attempt($credentials, $request->has('remember')))
            return false;

        $user = Auth::user();

        $key = config('jwt.key');
        $signer = new Sha256();
        $builder = (new Builder())->setIssuer(config('jwt.host'))
            ->set('uid', $user->id);

        if (config('jwt.payload')['aud'])
            $builder->setAudience($request->server('REMOTE_ADDR'));

        if (config('jwt.payload')['iss'])
            $builder->setIssuedAt(time());

        if (config('jwt.payload')['nbf'])
            $builder->setNotBefore(time() + config('jwt.not_before_time'));

        if (config('jwt.payload')['exp'])
            $builder->setExpiration(time() + config('jwt.expires'));

        $token = $builder->sign($signer, $key)
            ->getToken();

        return $token->__toString();
    }
}