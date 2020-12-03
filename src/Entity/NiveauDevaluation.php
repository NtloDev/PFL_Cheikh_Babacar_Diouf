<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\NiveauDevaluationRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=NiveauDevaluationRepository::class)
 */
class NiveauDevaluation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"compde:write","competencesEtNiveaux:read","competencesEtNiveaux:write","compgetid:read","compgetid:write","groupecomp:read","groupecompid:read"})
     * @Assert\NotBlank(message="Le libelle ne doit pas être vide")
     * @Assert\Length(
     *      min = 3,
     *      max = 100,
     *      minMessage = "Le libelle doit avoir au moins {{ limit }} charactères",
     *      maxMessage = "Le libelle ne doit pas dépasser {{ limit }} charactères"
     * )
     */
    private $Libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"compde:write","competencesEtNiveaux:read","competencesEtNiveaux:write","compgetid:read","compgetid:write","groupecomp:read","groupecompid:read"})
     *@Assert\NotBlank(message="Ce champs est obligatoire")
     * @Assert\Length(
     *      min = 8,
     *      max = 100,
     *      minMessage = "Ce Champs doit avoir au moins {{ limit }} charactères",
     *      maxMessage = "Le libelle ne doit pas dépasser {{ limit }} charactères"
     * )
     */
    private $Actions;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"compde:write","competencesEtNiveaux:read","competencesEtNiveaux:write","compgetid:read","compgetid:write","groupecomp:read","groupecompid:read"})
     * *@Assert\NotBlank(message="Ce champs est obligatoire")
     * @Assert\Length(
     *      min = 8,
     *      max = 100,
     *      minMessage = "Ce Champs doit avoir au moins {{ limit }} charactères",
     *      maxMessage = "Le libelle ne doit pas dépasser {{ limit }} charactères"
     * )
     */
    private $Criteres;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, inversedBy="niveauDevaluations",cascade="persist")
     */
    private $Competences;

    public function __construct()
    {
        $this->Competences = new ArrayCollection();
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

    public function getActions(): ?string
    {
        return $this->Actions;
    }

    public function setActions(string $Actions): self
    {
        $this->Actions = $Actions;

        return $this;
    }

    public function getCriteres(): ?string
    {
        return $this->Criteres;
    }

    public function setCriteres(string $Criteres): self
    {
        $this->Criteres = $Criteres;

        return $this;
    }

    /**
     * @return Collection|Competence[]
     */
    public function getCompetences(): Collection
    {
        return $this->Competences;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->Competences->contains($competence)) {
            $this->Competences[] = $competence;
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        $this->Competences->removeElement($competence);

        return $this;
    }
}
