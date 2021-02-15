<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EtatLivrableRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=EtatLivrableRepository::class)
 */
class EtatLivrable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Etat;

    /**
     * @ORM\OneToOne(targetEntity=LivrableAttendu::class, cascade={"persist", "remove"})
     */
    private $LivrableAttendu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?bool
    {
        return $this->Etat;
    }

    public function setEtat(bool $Etat): self
    {
        $this->Etat = $Etat;

        return $this;
    }

    public function getLivrableAttendu(): ?LivrableAttendu
    {
        return $this->LivrableAttendu;
    }

    public function setLivrableAttendu(?LivrableAttendu $LivrableAttendu): self
    {
        $this->LivrableAttendu = $LivrableAttendu;

        return $this;
    }
}
