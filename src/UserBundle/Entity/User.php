<?php
/**
 * Created by IntelliJ IDEA.
 * User: emreyilmaz
 * Date: 6.02.2016
 * Time: 00:30
 */

namespace UserBundle\Entity;

use CoreBundle\Entity\TimeStampableTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\AccessType;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 * @package UserBundle\Entity
 * @ORM\Table(name="members")
 * @ORM\Entity(repositoryClass="UserBundle\Entity\UserRepository")
 * @ExclusionPolicy("all")
 */
class User implements UserInterface
{
    public function __construct()
    {
        $this->refreshSalt();
    }

    use TimeStampableTrait;
    /**
     * @var string
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\Column(type="string")
     * @Expose
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(unique=true,nullable=false,type="string",length=255)
     * @Expose
     */
    protected $email;
    /**
     * @var string
     * @ORM\Column(type="string",nullable=true)
     * @Expose
     */
    protected $name;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $first_name;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $last_name;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     * @Expose
     */
    protected $password;

    /**
     * @var array
     * @ORM\Column(type="array", nullable=true)
     * @Expose
     */
    protected $roles;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    protected $salt;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     * @return User
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     * @return User
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function getUsername()
    {
        return $this->getEmail();
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function refreshSalt()
    {
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }


}