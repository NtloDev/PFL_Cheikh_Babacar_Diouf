<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 */
class Groupe
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
     * @ORM\Column(type="boolean")
     */
    private $Archive;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="groupes",cascade={"persist"})
     */
    private $Promo;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, inversedBy="groupes")
     */
    private $Apprenants;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="groupes")
     */
    private $Formateurs;

    public function __construct()
    {
        $this->Apprenants = new ArrayCollection();
        $this->Formateurs = new ArrayCollection();
    }

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

    public function getArchive(): ?bool
    {
        return $this->Archive;
    }

    public function setArchive(bool $Archive): self
    {
        $this->Archive = $Archive;

        return $this;
    }

    public function getPromo(): ?Promo
    {
        return $this->Promo;
    }

    public function setPromo(?Promo $Promo): self
    {
        $this->Promo = $Promo;

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenants(): Collection
    {
        return $this->Apprenants;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->Apprenants->contains($apprenant)) {
            $this->Apprenants[] = $apprenant;
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        $this->Apprenants->removeElement($apprenant);

        return $this;
    }

    /**
     * @return Collection|Formateur[]
     */
    public function getFormateurs(): Collection
    {
        return $this->Formateurs;
    }

    public function addFormateur(Formateur $formateur): self
    {
        if (!$this->Formateurs->contains($formateur)) {
            $this->Formateurs[] = $formateur;
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        $this->Formateurs->removeElement($formateur);

        return $this;
    }
}
