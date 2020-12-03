<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\GroupeDeCompetencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 * collectionOperations={
 *          "getgrpcompetences"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/admin/grpecompetences",
 *              "normalization_context"={"groups"={"groupecomp:read"}},
 *          },
 *      "getGrpcompCompetences"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/admin/grpecompetences/competences",
 *              "normalization_context"={"groups"={"groupecompcomp:read"}},
 *
 *          },
 *        "pstGrpCompetences"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="POST",
 *              "path"="admin/grpecompetences",
 *              "denormalization_context"={"groups"={"grpcompde:write"}},
 *
 *          },
 *},
 *itemOperations={
 *     "getcompetencebyID"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/admin/grpecompetences/{id}",
 *              "normalization_context"={"groups"={"groupecompid:read"}},
 *          },
 * "getgrpcompetencescompetencebyID"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/admin/grpecompetences/{id}/competences ",
 *              "normalization_context"={"groups"={"groupecompidcomp:read"}},
 *          },
 * "putcompetencebyID"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="PUT",
 *              "path"="/admin/grpecompetences/{id}",
 *              "denormalization_context"={"groups"={"grpcompde:write"}},
 *          },
 *  "archive_grpecompetence"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="DELETE",
 *              "path"="/admin/grpecompetences/{id}",
 *              "normalization_context"={"groups"={"putcompetence:write"}},
 *          },
 * },
 * )
 * @ORM\Entity(repositoryClass=GroupeDeCompetencesRepository::class)
 */
class GroupeDeCompetences
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"postref:write","grpcom:write","grpcompde:write","compde:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"compde:write","grpcompde:write","grpcom:write","grpco:read","afficherGr:read","postref:write","groupecomp:read","postgroupecomp:write","groupecompcomp:read","groupecompid:read","groupecompidcomp:read","putcompetence:write","ref_grpe:read","competence:read"})
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
     * @Groups({"compde:write","grpcompde:write","grpcom:write","grpco:read","afficherGr:read","postref:write","groupecomp:read","postgroupecomp:write","groupecompcomp:read","groupecompid:read","groupecompidcomp:read","putcompetence:write","ref_grpe:read","competence:read"})
     * @Assert\NotBlank(message="La description ne doit pas être vide")
     * @Assert\Length(
     *      min = 8,
     *      max = 100,
     *      minMessage = "La description doit avoir au moins {{ limit }} charactères",
     *      maxMessage = "Le description ne doit pas dépasser {{ limit }} charactères"
     * )
     */
    private $Description;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, mappedBy="GroupeDeCompetences",cascade="persist")
     * @Groups({"grpcompde:write","grpco:read","groupecomp:read","postgroupecomp:write","groupecompcomp:read","groupecompid:read","groupecompidcomp:read","competence:read"})
     */
    private $competences;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Archive=false;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, mappedBy="GroupeDeCompetences")
     */
    private $referentiels;

    public function __construct()
    {
        $this->competences = new ArrayCollection();
        $this->referentiels = new ArrayCollection();
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
     * @return Collection|Competence[]
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
            $competence->addGroupeDeCompetence($this);
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        if ($this->competences->removeElement($competence)) {
            $competence->removeGroupeDeCompetence($this);
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

    /**
     * @return Collection|Referentiel[]
     */
    public function getReferentiels(): Collection
    {
        return $this->referentiels;
    }

    public function addReferentiel(Referentiel $referentiel): self
    {
        if (!$this->referentiels->contains($referentiel)) {
            $this->referentiels[] = $referentiel;
            $referentiel->addGroupeDeCompetence($this);
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiels->removeElement($referentiel)) {
            $referentiel->removeGroupeDeCompetence($this);
        }

        return $this;
    }
}
