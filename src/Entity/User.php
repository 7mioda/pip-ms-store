<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * UniqueEntity("email")
 */
class User implements UserInterface, Serializable
{
    STATIC $USER = "USER";
    STATIC $SELLER = "SELLER";
    STATIC $FIRST_CONNECTED= "FIRST_CONNECTED";
    STATIC $ACTIVE= "ACTIVE";

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = array();

    /**
     * @ORM\Column(type="text")
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255 ,nullable=true)
     */
    private $storeName;

    /**
     * @ORM\Column(type="string", length=255, options= {"default": "FIRST_CONNECTED"})
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255 ,nullable=true)
     */
    private $cardNumber;

    /**
     * @ORM\Column(name="coordinate_lat",type="float")
     */
    private $coordinateLat;

    /**
     * @ORM\Column(name="coordinate_Lng",type="float")
     */
    private $coordinateLng;

    public function __construct()
    {
        $this->roles[] = User::$USER;
        $this->status = User::$FIRST_CONNECTED;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): User
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): User
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(?string $cin): User
    {
        $this->cin = $cin;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): User
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): User
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }
    /**
     * @param array $roles
     * @return User
     */
    public function setRoles(array $roles):User
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): User
    {
        $this->address = $address;

        return $this;
    }

    public function getStoreName(): ?string
    {
        return $this->storeName;
    }

    public function setStoreName(?string $storeName): User
    {
        $this->storeName = $storeName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCoordinateLat()
    {
        return $this->coordinateLat;
    }

    /**
     * @param mixed $coordinateLat
     * @return User
     */
    public function setCoordinateLat($coordinateLat): User
    {
        $this->coordinateLat = $coordinateLat;
        return $this;

    }

    /**
     * @return mixed
     */
    public function getCoordinateLng()
    {
        return $this->coordinateLng;
    }

    /**
     * @param mixed $coordinateLng
     * @return User
     */
    public function setCoordinateLng($coordinateLng): User
    {
        $this->coordinateLng = $coordinateLng;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): User
    {
        $this->status = $status;

        return $this;
    }

    public function getCardNumber(): ?String
    {
        return $this->cardNumber;
    }

    public function setCardNumber(?String $cardNumber): User
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }
    /**
     * String representation of object
     * @link https://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->firstName,
            $this->cin,
            $this->email,
            $this->password
        ]);
    }

    /**
     * Constructs the object
     * @link https://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->firstName,
            $this->cin,
            $this->email,
            $this->password
            ) = unserialize($serialized,['allawed_classes' => false]);
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}
