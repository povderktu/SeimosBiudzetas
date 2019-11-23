<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ExpanseRepository")
 */
class Expanse
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $pavadinimas;

    /**
     * @ORM\Column(type="float")
     */
    private $suma;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="expanse")
     */
    private $member;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ExpanseType", inversedBy="expanses")
     */
    private $tipas;

    public function getTipas(): ?ExpanseType
    {
        return $this->tipas;
    }

    public function setTipas(?ExpanseType $tipas): self
    {
        $this->tipas = $tipas;

        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPavadinimas()
    {
        return $this->pavadinimas;
    }

    /**
     * @param mixed $pavadinimas
     */
    public function setPavadinimas($pavadinimas): void
    {
        $this->pavadinimas = $pavadinimas;
    }

    /**
     * @return mixed
     */
    public function getSuma()
    {
        return $this->suma;
    }

    /**
     * @param mixed $suma
     */
    public function setSuma($suma): void
    {
        $this->suma = $suma;
    }

    /**
     * @return mixed
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * @param mixed $member
     */
    public function setMember($member): void
    {
        $this->member = $member;
    }

    public function getAllValues()
    {
        $out[0] = $this->id;
        $out[1] = $this->pavadinimas;
        $out[2] = $this->getTipas()->getTipas();
        $out[3] = $this->getMember();
        $out[4] = $this->suma;

        return $out;
    }
}
