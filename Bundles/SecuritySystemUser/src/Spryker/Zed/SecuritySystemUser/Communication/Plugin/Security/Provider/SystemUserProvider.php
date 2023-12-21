<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SecuritySystemUser\Communication\Plugin\Security\Provider;

use Generated\Shared\Transfer\UserTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\SecuritySystemUser\Communication\Security\SystemUser;
use Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @method \Spryker\Zed\SecuritySystemUser\Communication\SecuritySystemUserCommunicationFactory getFactory()
 * @method \Spryker\Zed\SecuritySystemUser\SecuritySystemUserConfig getConfig()
 * @method \Spryker\Zed\SecuritySystemUser\Business\SecuritySystemUserFacadeInterface getFacade()
 */
class SystemUserProvider extends AbstractPlugin implements UserProviderInterface
{
    /**
     * @param string $username Token.
     *
     * @return \Symfony\Component\Security\Core\User\UserInterface
     */
    public function loadUserByUsername($username)
    {
        return $this->loadUserByIdentifier($username);
    }

    /**
     * @param string $identifier
     *
     * @return \Symfony\Component\Security\Core\User\UserInterface
     */
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        return $this->getUserByToken($identifier);
    }

    /**
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     *
     * @return \Symfony\Component\Security\Core\User\UserInterface
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof SystemUser || !$user->getUsername()) {
            return $user;
        }

        /** @var string $username */
        $username = $user->getUsername();

        return $this->getUserByUsername($username);
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return is_a($class, SystemUser::class, true);
    }

    /**
     * @param string $token
     *
     * @throws \Symfony\Component\Security\Core\Exception\UsernameNotFoundException
     * @throws \Symfony\Component\Security\Core\Exception\UserNotFoundException
     *
     * @return \Symfony\Component\Security\Core\User\UserInterface
     */
    protected function getUserByToken(string $token): UserInterface
    {
        foreach ($this->getConfig()->getUsersCredentials() as $username => $credential) {
            if (!$credential['token']) {
                continue;
            }

            if ($this->isValidToken($credential['token'], $token)) {
                return $this->getFactory()->createSecurityUser(
                    (new UserTransfer())->setUsername($username)
                        ->setPassword($credential['token']),
                );
            }
        }

        throw $this->getUserNotFoundException();
    }

    /**
     * @param string $username
     *
     * @throws \Symfony\Component\Security\Core\Exception\UsernameNotFoundException
     * @throws \Symfony\Component\Security\Core\Exception\UserNotFoundException
     *
     * @return \Symfony\Component\Security\Core\User\UserInterface
     */
    protected function getUserByUsername(string $username): UserInterface
    {
        foreach ($this->getConfig()->getUsersCredentials() as $securityUserName => $credential) {
            if ($securityUserName === $username) {
                return $this->getFactory()->createSecurityUser(
                    (new UserTransfer())->setUsername($username)
                        ->setPassword($credential['token']),
                );
            }
        }

        throw $this->getUserNotFoundException();
    }

    /**
     * @param string $userToken
     * @param string $token
     *
     * @return bool
     */
    protected function isValidToken(string $userToken, string $token): bool
    {
        return password_verify($userToken, base64_decode($token));
    }

    /**
     * @return \Symfony\Component\Security\Core\Exception\AuthenticationException
     */
    protected function getUserNotFoundException(): AuthenticationException
    {
        if ($this->isSymfonyVersion5() === true) {
            /** @phpstan-ignore-next-line */
            return new UsernameNotFoundException();
        }

        return new UserNotFoundException();
    }

    /**
     * @deprecated Shim for Symfony Security Core 5.x, to be removed when Symfony Security Core dependency becomes 6.x+.
     *
     * @return bool
     */
    protected function isSymfonyVersion5(): bool
    {
        return class_exists(AuthenticationProviderManager::class);
    }
}
