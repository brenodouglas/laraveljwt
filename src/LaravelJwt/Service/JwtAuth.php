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
        $token = (new Builder())->setIssuer(config('jwt.host'))
            ->setAudience($request->server('REMOTE_ADDR'))
            ->setIssuedAt(time())
            ->setNotBefore(time())
            ->setExpiration(time() + config('jwt.expires'))
            ->set('uid', $user->id)
            ->sign($signer, $key)
            ->getToken();

        return $token->__toString();
    }
}