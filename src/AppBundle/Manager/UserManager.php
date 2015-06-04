<?php

namespace AppBundle\Manager;

use AppBundle\Entity\User;
use AppBundle\Helper\CanonicalizerHelper;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserManager extends BaseManager
{
    private $encoder;

    private $graphManager;

    private $repository;

    private $userEntityClass;

    public function __construct(EncoderFactoryInterface $encoderFactory, GraphManager $graphManager, $userEntityClass)
    {
        $this->encoder         = $encoderFactory;
        $this->graphManager    = $graphManager;
        $this->repository      = $graphManager->getRepository($userEntityClass);
        $this->userEntityClass = $userEntityClass;
    }

    /**
     * Creates an empty user
     *
     * @return UserInterface|User
     */
    public function createUser()
    {
        $salt = $this->generateSalt();

        return new $this->userEntityClass($salt);
    }

    /**
     * Find user by id
     *
     * @param $id
     * @return bool|\Everyman\Neo4j\Node
     */
    public function findUserById($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Find user by criteria
     *
     * @param array $criteria
     * @return \Everyman\Neo4j\Node|null
     */
    public function findUserBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * Finds a user by email
     *
     * @param string $username
     *
     * @return UserInterface
     */
    public function findUserByEmail($email)
    {
        return $this->findUserBy(['email' => CanonicalizerHelper::canonicalize($email)]);
    }

    /**
     * Finds a user either by confirmation token
     *
     * @param string $token
     *
     * @return UserInterface
     */
    public function findUserByConfirmationToken($token)
    {
        return $this->findUserBy(['confirmationToken' => $token]);
    }

    /**
     * Updates a user.
     *
     * @param UserInterface $user
     * @param Boolean $andFlush Whether to flush the changes (default true)
     */
    public function updateUser(UserInterface $user, $andFlush = true, $encodePassword = false)
    {
        if ($encodePassword) {
            $this->updatePassword($user);
        }

        $this->graphManager->persist($user);
        if ($andFlush) {
            $this->graphManager->flush();
        }
    }

    /**
     * Updates a user user and encode his password
     *
     * @param $user UserInterface
     */
    public function updateUserAndEncodePassword(UserInterface $user)
    {
        return $this->updateUser($user, true, true);
    }

    /**
     * Get entity user class
     *
     * @return string
     */
    public function getEntityClass()
    {
        return $this->userEntityClass;
    }

    /**
     * Generates a unique password salt
     *
     * @return string
     */
    private function generateSalt()
    {
        return base64_encode(uniqid('', true).sha1(time()));
    }

    /**
     * Encode user password
     *
     * @param UserInterface $user
     */
    private function updatePassword(UserInterface $user)
    {
        $encoder = $this->encoder->getEncoder($user);
        $user->setPassword($encoder->encodePassword($user->getPassword(), $user->getSalt()));
    }
}
