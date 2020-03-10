<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;


class JwtAuthenticator extends AbstractGuardAuthenticator
{
    public function supports(Request $request)
    {
        return $request->cookies->get("jwt") ? true : false;
//        return $request->headers->has('Authorization')
//            && 0 === strpos($request->headers->get('Authorization'), 'Bearer ');

    }

    public function getCredentials(Request $request)
    {
        $cookie = $request->cookies->get("jwt");
        $error = "Unable to validate session.";
        try
        {
            $decodedJwt = JWT::decode($cookie, getenv("JWT_SECRET"), ['HS256']);

        }
        catch(ExpiredException $e)
        {
            $error = "Session has expired.";
        }
        catch(SignatureInvalidException $e)
        {
            $error = "Attempting access invalid session.";
        }
        catch(\Exception $e)
        {
        }
        throw new CustomUserMessageAuthenticationException($error);

//        $authorizationHeader = $request->headers->get('Authorization');
//        $test =  substr($authorizationHeader, 7);
//        $decodedJwt = JWT::decode($test, getenv("JWT_SECRET"), ['HS256']);
//            return [
//                'user_id' => $decodedJwt->user_id,
//                'email' => $decodedJwt->email
//            ];

    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials['email']);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return $user->getId() === $credentials['user_id'];
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse([
            'error' => $exception->getMessageKey()
        ], 400);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // todo
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        // todo
    }

    public function supportsRememberMe()
    {
        // todo
    }
}
