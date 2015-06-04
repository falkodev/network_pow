<?php

namespace AppBundle\Security;

use AppBundle\Entity\User;
use AppBundle\Manager\UserManager;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class Neo4jUserProvider implements UserProviderInterface
{
    const NEO4J_USER_PROXY = 'neo4jProxyAppBundle_Entity_User';

    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @param UserManager $userManager
     * @param string $userEntityClass
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @param string $username
     * @return User|UserInterface
     * @throws \Symfony\Component\Security\Core\Exception\UsernameNotFoundException
     */
    public function loadUserByUsername($username)
    {
        $user = $this->userManager->findUserByEmail($username);
        if (!$user) {
            throw new UsernameNotFoundException(
                sprintf('Username "%s" does not exist.', $username)
            );
        }

        return $this->dehydrate($user);
    }

    /**
     * @param UserInterface $user
     * @return User|UserInterface
     * @throws \Symfony\Component\Security\Core\Exception\UnsupportedUserException
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );

        }

        return $this->loadUserByUsername($user);
    }

    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class === $this->userManager->getEntityClass();
    }

    /**
     * @param UserInterface $user
     * @return UserInterface|void
     */
    private function dehydrate(UserInterface $userProxy)
    {
        if (get_class($userProxy) !== self::NEO4J_USER_PROXY) {
            return $userProxy;
        }

        return $userProxy->getEntity();
    }
}
