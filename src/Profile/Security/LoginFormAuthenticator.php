<?php

declare(strict_types=1);

namespace App\Profile\Security;

use App\Controller\ProfileController;
use App\Controller\RoomController;
use App\Profile\Entity\User;
use App\Profile\Service\RegisterUserServiceInterface;
use App\Profile\Service\UserSessionServiceInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{

    use TargetPathTrait;

    private RegisterUserServiceInterface $registerUserService;

    private UrlGeneratorInterface $urlGenerator;

    private CsrfTokenManagerInterface $csrfTokenManager;

    private UserSessionServiceInterface $userSessionService;

    private SessionInterface $session;

    public function __construct(
        RegisterUserServiceInterface $registerUserService,
        UserSessionServiceInterface $userSessionService,
        UrlGeneratorInterface $urlGenerator,
        CsrfTokenManagerInterface $csrfTokenManager,
        SessionInterface $session
    ) {
        $this->userSessionService = $userSessionService;
        $this->registerUserService = $registerUserService;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->session = $session;
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request)
    {
        return ProfileController::ROUTE_LOGIN === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    /**
     * @inheritDoc
     */
    public function getCredentials(Request $request)
    {
        return [
            'name' => $request->get('name'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);

        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        $name = $credentials['name'];

        try{
            $user = $userProvider->loadUserByUsername($name);
        } catch (UsernameNotFoundException $e) {
            $user = new User();
            $user->setName($name);

            $user = $this->registerUserService->register($user);
        }
        $lastVisit=$this->userSessionService->getLastVisit($user);

        $this->session->set('lastVisit', $lastVisit);
        $this->userSessionService->updateLastVisit($user);

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate(RoomController::ROUTE_MAIN));
    }

    /**
     * @inheritDoc
     */
    protected function getLoginUrl()
    {
        return $this->urlGenerator->generate(ProfileController::ROUTE_LOGIN);
    }
}