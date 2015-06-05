<?php

namespace AppBundle\Entity;

use HireVoice\Neo4j\Annotation as OGM;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 *
 * @OGM\Entity(labels="User")
 * @Assert\GroupSequence({"User", "Strict"})
 */
class User implements UserInterface, EquatableInterface
{
    const STATUS_ENABLED  = 1;
    const STATUS_AWAITING = 0;
    const STATUS_BLOCKED  = -1;
    const STATUS_DISABLED = -2;

    /**
     * @OGM\Auto
     */
    protected $id;

    /**
     * @OGM\Property
     * @OGM\Index
     * @Assert\NotBlank(message="user.email.blank")
     * @Assert\Email(message="user.email.invalid", checkMX=true)
     */
    protected $email;

    /**
     * @OGM\Property
     * @OGM\Index
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="user.firstname.regex"
     * )
     */
    protected $firstname;

    /**
     * @OGM\Property
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="user.lastname.regex"
     * )
     */
    protected $lastname;

    /**
     * @OGM\Property
     */
    protected $address;

    /**
     * @OGM\Property
     */
    protected $status;

    /**
     * @OGM\Property
     */
    protected $salt;

    /**
     * @OGM\Property
     * @Assert\NotBlank(message="user.password.blank", groups={"registration"})
     * @Assert\Length(
     *      min="5",
     *      minMessage="user.password.short",
     *      groups={"registration"}
     * )
     */
    protected $password;

    /**
     * @OGM\Property(format="date")
     */
    protected $lastLogin;

    /**
     * @OGM\Property
     */
    protected $lastconnectedIp;

    /**
     * @OGM\Property
     * @OGM\Index
     */
    protected $confirmationToken;

    /**
     * @OGM\Property
     */
    protected $locked;

    /**
     * @OGM\Property
     */
    protected $expired;

    /**
     * @OGM\Property
     */
    protected $expiresAt;

    /**
     * @OGM\Property(format="array")
     */
    protected $roles;

    public function __toString()
    {
        return $this->getUsername();
    }

    /**
     * @param string|null $username
     * @param string|null $password
     * @param string|null $salt
     * @param array|null $roles
     */
    public function __construct($salt = null, $status = self::STATUS_AWAITING)
    {
        $this->roles           = array('ROLE_USER');
        $this->locked          = false;
        $this->expired         = false;
        $this->status          = $status;
        $this->salt            = $salt;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFullname()
    {
        return strtoupper($this->lastname). ' '. ucfirst($this->firstname);
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     *
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param mixed $lastLogin
     *
     * @return User
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastconnectedIp()
    {
        return $this->lastconnectedIp;
    }

    /**
     * @param mixed $lastconnectedIp
     *
     * @return User
     */
    public function setLastconnectedIp($lastconnectedIp)
    {
        $this->lastconnectedIp = $lastconnectedIp;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * @param mixed $confirmationToken
     *
     * @return User
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     *
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * @param mixed $locked
     *
     * @return User
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * @param mixed $expired
     *
     * @return User
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param mixed $expiresAt
     *
     * @return User
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * @param mixed $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @param mixed $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param mixed $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getRoles()
    {
        if (!is_array($this->roles)) {
            $this->roles = [$this->roles];
        }

        return $this->roles;
    }

    /**
     * @inheritdoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritdoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @inheritdoc
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @inheritdoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @param UserInterface $user
     * @return bool
     */
    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof User) {
            return false;
        }
        if ($this->password !== $user->getPassword()) {
            return false;
        }
        if ($this->getSalt() !== $user->getSalt()) {
            return false;
        }
        if ($this->email !== $user->getEmail()) {
            return false;
        }

        return true;
    }

    /**
     * @Assert\True(message="user.password.same_username", groups={"Strict"})
     */
    public function isPasswordLegal()
    {
        return ($this->email !== $this->password);
    }
}
