<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompetenceRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *collectionOperations={
 *                      "getcomp"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_Formateur')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/admin/competences",
 *              "normalization_context"={"groups"={"competencesEtNiveaux:read"}},
 *          },
 *      "postcomp"={
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="POST",
 *              "path"="/admin/competences",
 *              "denormalization_context"={"groups"={"compde:write"}},
 *          },
 *
 *
 *},
 *itemOperations={
 *     "getcompbyID"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_Formateur')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/admin/competences/{id}",
 *              "normalization_context"={"groups"={"compgetid:read"}},
 *          },
 * "putcompbyID"={
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="PUT",
 *              "path"="/admin/competences/{id}",
 *              "denormalization_context"={"groups"={"compde:write"}},
 *          },
 * "archive"={
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="DELETE",
 *              "path"="/admin/competences/{id}",
 *          },
 * },
 * )
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 */
class Competence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"postgroupecomp:write","grpcompde:write","compde:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"compde:write","grpcompde:write","grpco:read","competencesEtNiveaux:read","competencesEtNiveaux:write","compgetid:read","compgetid:write","groupecomp:read","postgroupecomp:write","groupecompcomp:read","groupecompid:read","groupecompidcomp:read","competence:read"})
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
     * @Groups({"compde:write","grpcompde:write","grpco:read","competencesEtNiveaux:read","competencesEtNiveaux:write","compgetid:read","compgetid:write","groupecomp:read","postgroupecomp:write","groupecompcomp:read","groupecompid:read","groupecompidcomp:read","competence:read"})
     * @Assert\NotBlank(message="La description ne doit pas être vide")
     * @Assert\Length(
     *      min = 8,
     *      max = 100,
     *      minMessage = "Le libelle doit avoir au moins {{ limit }} charactères",
     *      maxMessage = "Le libelle ne doit pas dépasser {{ limit }} charactères"
     * )
     */
    private $Description;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeDeCompetences::class, inversedBy="competences",cascade="persist")
     * @Groups({"compde:write"})
     *
     */
    private $GroupeDeCompetences;

    /**
     * @ORM\ManyToMany(targetEntity=NiveauDevaluation::class, mappedBy="Competences",cascade="persist")
     * @ApiSubresource
     * @Groups({"competencesEtNiveaux:read","competencesEtNiveaux:write","compgetid:read","compgetid:write","groupecomp:read","groupecompid:read","compde:write"})
     */
    private $niveauDevaluations;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Archive=false;

    public function __construct()
    {
        $this->GroupeDeCompetences = new ArrayCollection();
        $this->niveauDevaluations = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return Collection|GroupeDeCompetences[]
     */
    public function getGroupeDeCompetences(): Collection
    {
        return $this->GroupeDeCompetences;
    }

    public function addGroupeDeCompetence(GroupeDeCompetences $groupeDeCompetence): self
    {
        if (!$this->GroupeDeCompetences->contains($groupeDeCompetence)) {
            $this->GroupeDeCompetences[] = $groupeDeCompetence;
        }

        return $this;
    }

    public function removeGroupeDeCompetence(GroupeDeCompetences $groupeDeCompetence): self
    {
        $this->GroupeDeCompetences->removeElement($groupeDeCompetence);

        return $this;
    }

    /**
     * @return Collection|NiveauDevaluation[]
     */
    public function getNiveauDevaluations(): Collection
    {
        return $this->niveauDevaluations;
    }

    public function addNiveauDevaluation(NiveauDevaluation $niveauDevaluation): self
    {
        if (!$this->niveauDevaluations->contains($niveauDevaluation)) {
            $this->niveauDevaluations[] = $niveauDevaluation;
            $niveauDevaluation->addCompetence($this);
        }

        return $this;
    }

    public function removeNiveauDevaluation(NiveauDevaluation $niveauDevaluation): self
    {
        if ($this->niveauDevaluations->removeElement($niveauDevaluation)) {
            $niveauDevaluation->removeCompetence($this);
        }

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
}
