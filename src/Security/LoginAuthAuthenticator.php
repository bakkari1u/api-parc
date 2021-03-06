<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Firebase\JWT\JWT;

class LoginAuthAuthenticator extends AbstractGuardAuthenticator
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports(Request $request)
    {
        return $request->get("_route") === "api_login" && $request->isMethod("POST");
    }

    public function getCredentials(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        return [
            'email' => $data["email"],
            'password' => $data["password"]
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials['email']);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse(
            "le compte spécifié n'existe pas"
        , 401);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $expireTime = time() + 3600;
        $tokenPayload = [
            'user_id' => $token->getUser()->getId(),
            'email'   => $token->getUser()->getEmail(),
            'exp'     => $expireTime
        ];
        $jwt = JWT::encode($tokenPayload, getenv("JWT_SECRET"));
        setcookie("jwt", $jwt, $expireTime, "/","jardin-parc.firebaseapp.com");
        return new JsonResponse([
            'id' => $token->getUser()->getId(),
            'email' => $token->getUser()->getEmail(),
            'role' => $token->getUser()->getRole(),
            'username' => $token->getUser()->getUsername(),
            'firstname' => $token->getUser()->getFirstname(),
            'lastname' => $token->getUser()->getLastname(),
            'token' => $jwt
        ],200);
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new JsonResponse([
            'error' => 'Access Denied'
        ]);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
