<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExpanseTypeRepository")
 */
class ExpanseType
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
    private $tipas;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Expanse", mappedBy="tipas")
     */
    private $expanses;


    public function setId($id): void
    {
        $this->$id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->expanses = new ArrayCollection();
    }

    /**
     * @return Collection|Expanse[]
     */
    public function getExpanses(): Collection
    {
        return $this->expanses;
    }

    /**
     * @return mixed
     */
    public function getTipas()
    {
        return $this->tipas;
    }

    /**
     * @param mixed $username
     */
    public function setTipas($tipas): void
    {
        $this->tipas = $tipas;
    }
    public function __toString() {
        return $this->tipas;
    }


    public function showValues()
    {
        $expanses = $this->getExpanses();
        foreach ($expanses as $arr)
        {
            $pavadinimas = $arr->getPavadinimas();
            $suma = $arr->getSuma();
            $tipas = $arr->getTipas();

            echo "Pavadinimas :";
            echo "\n";
            echo $pavadinimas;
            echo "\n";
            echo "Suma :";
            echo "\n";
            echo $suma;
            echo "\n";
            echo "Tipas :";
            echo "\n";
            echo $tipas->getTipas();
            echo "\n";
            echo "\n";
        }
    }

}
