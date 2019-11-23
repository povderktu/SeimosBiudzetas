<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="`member`")
 * @ORM\Entity
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class Member implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $reason;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $dabartinisLimitas;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getDabartinisLimitas()
    {
        return $this->dabartinisLimitas;
    }

    /**
     * @param mixed $dabartinisLimitas
     */
    public function setDabartinisLimitas($dabartinisLimitas): void
    {
        $this->dabartinisLimitas = $dabartinisLimitas;
    }

    /**
     * @return mixed
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param mixed $reason
     */
    public function setReason($reason): void
    {
        $this->reason = $reason;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * @return mixed
     */
    public function getUsername()
    {
        return null;
    }

    /**
     * @param mixed $username
     */
    //public function setUsername($username): void
   // {
    //    $this->username = $username;
    //}

    /**
     * @return mixed
     */
   public function getPassword()
    {
        return null;
    }

    /**
     * @param mixed $password
     */
   // public function setPassword($password): void
   // {
   //     $this->password = $password;
    //}

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void
    {
        $this->role = $role;
    }

    public function getBusena()
    {
        return $this->busena;
    }


    public function setBusena($limitoBusena)
    {
        $this->busena= $limitoBusena;
    }


    public function getLimitas()
    {
        return $this->limitas;
    }

    /**
     * @param mixed $limitas
     */
    public function setLimitas($limitas): void
    {
        $this->limitas = $limitas;
    }

    /**
     * @ORM\Column(type="string", length=191, unique=true)
     * @Assert\NotBlank()
     */
    //private $username;
    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=64)
     */
   // private $password;
    /**
     * User = 0; Admin = 1;
     * @ORM\Column(type="integer", nullable=false)
     */
    private $role;
    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private $limitas;
    /**
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    private $busena;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Expanse", mappedBy="member")
     */
    private $expanse;

    public function __construct()
    {
        $this->expanse = new ArrayCollection();
    }
    /**
     * @return Collection|Expanse[]
     */
    public function getExpanses()
    {
        return $this->expanse;
    }

    public function getAllValues()
    {
        $out[0] = $this->id;
        //$out[1] = $this->username;
       // $out[2] = $this->getPassword();
        $out[3] = $this->role;
        $out[4] = $this->limitas;
        $out[5] = $this->dabartinisLimitas;
        $out[6] = $this->busena;
        if ($out[6] == "Užblokuotas")
        {
            $out[7] = $this->reason;
        }
        return $out;
    }

    public function fromArray($array)
    {
        foreach($array as $arr)
        {
            $arr->getAllValues();
        }
    }

    public function add($a, $b)
    {
        return $a + $b - 5;
    }


    public function getSalt()
    {
        return null;
    }
    public function getRoles()
    {
        return array('ROLE_USER');
    }
    public function eraseCredentials()
    {
        return null;
    }
}