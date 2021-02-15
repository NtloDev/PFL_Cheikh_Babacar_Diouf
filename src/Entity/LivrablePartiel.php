<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivrablePartielRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=LivrablePartielRepository::class)
 */
class LivrablePartiel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Libelle;

    /**
     * @ORM\Column(type="date")
     */
    private $Delai;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Type;

    /**
     * @ORM\ManyToOne(targetEntity=ApprenantLivrablePartiel::class, inversedBy="livrablePartiels")
     */
    private $ApprenantLivrablePartiel;

    /**
     * @ORM\ManyToOne(targetEntity=BriefMaPromo::class, inversedBy="livrablePartiels")
     */
    private $BriefMaPromo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->Libelle;
    }

    public function setLibelle(string $Libelle): self
    {
        $this->Libelle = $Libelle;

        return $this;
    }

    public function getDelai(): ?\DateTimeInterface
    {
        return $this->Delai;
    }

    public function setDelai(\DateTimeInterface $Delai): self
    {
        $this->Delai = $Delai;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): self
    {
        $this->Type = $Type;

        return $this;
    }

    public function getApprenantLivrablePartiel(): ?ApprenantLivrablePartiel
    {
        return $this->ApprenantLivrablePartiel;
    }

    public function setApprenantLivrablePartiel(?ApprenantLivrablePartiel $ApprenantLivrablePartiel): self
    {
        $this->ApprenantLivrablePartiel = $ApprenantLivrablePartiel;

        return $this;
    }

    public function getBriefMaPromo(): ?BriefMaPromo
    {
        return $this->BriefMaPromo;
    }

    public function setBriefMaPromo(?BriefMaPromo $BriefMaPromo): self
    {
        $this->BriefMaPromo = $BriefMaPromo;

        return $this;
    }
}
