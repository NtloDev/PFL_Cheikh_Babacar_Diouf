<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use App\Repository\ReferentielRepository;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiFilter(BooleanFilter::class, properties={"Archive"})
 * @ApiResource(
 * collectionOperations={
 *          "getReferentiel"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/admin/referentiels",
 *              "normalization_context"={"groups"={"ref_grpe:read"}},
 *          },
 *          "getGC"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/admin/referentiels/groupecompetences",
 *              "normalization_context"={"groups"={"competence:read"}},
 *
 *          },
 *         "create_referentiel"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="ACCES REFUSE",
 *              "method"= "POST",
 *              "route_name" = "create_referentiel",
 *              "path"="/admin/referentiels",
 *              "deserialize" = false,
 *              "normalization_context"={"groups"={"postref:write"}},
 *      },
 *
 *      },
 * itemOperations={
 *
 *      "getGroup"={
 *          "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *          "security_message"="ACCES REFUSE",
 *          "method"= "GET",
 *          "path"= "/admin/referentiels/{id}",
 *          "normalization_context"={"groups"={"afficherGr:read"}},
 *      },
 *      "getCompetenceGroupe"={
 *          "method"= "GET",
 *          "path"= "/admin/referentiels/{id}/groupecompetences/{id_g}",
 *          "normalization_context"={"groups"={"grpco:read"}},
 *      },
 *      "ajoutgrpeCompetence"={
 *             "method"="PUT",
 *             "path" = "/admin/referentiels/{id}",
 *             "normalization_context"={"groups"={"grpcom:write"}},
 *      },
 *      "archivage_referentiel"={
 *             "method"="DELETE",
 *             "path" = "/admin/referentiels/{id}",
 *
 *      },
 *
 * },
 * )
 * @ORM\Entity(repositoryClass=ReferentielRepository::class)
 */
class Referentiel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"ref_grpe:read","OnePromoReferentiel:read","afficherGr:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *@Groups({"OnePromoReferentiel:read","OnePromo:read","grpcom:write","ref_grpe:read","competence:read","postref:write","afficherGr:read","grpco:read"})
     * @Assert\NotBlank(message="Ce champs est obligatoire")
     * @Assert\Length(
     *      min = 3,
     *      max = 100,
     *      minMessage = "Ce champs doit avoir au moins {{ limit }} charactères",
     *      maxMessage = "Ce champs ne doit pas dépasser {{ limit }} charactères"
     * )
     * @Groups({"OnePromoFormateursgroupeApprenants:read","OnePromoApprenantAAttente:read","Promos:read"})
     */
    private $Presentation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"OnePromoReferentiel:read","OnePromoApprenantAAttente:read","OnePromoReferentiel:read","Promos:read","grpcom:write","ref_grpe:read","competence:read","postref:write","afficherGr:read","grpco:read"})
     */
    private $CriteresDevaluation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"OnePromoReferentiel:read","Promos:read","grpcom:write","ref_grpe:read","competence:read","postref:write","afficherGr:read","grpco:read"})
     */
    private $CriteresDadmission;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeDeCompetences::class, inversedBy="referentiels")
     * @ApiSubresource
     * @Groups({"OnePromoReferentiel:read","grpcom:write","ref_grpe:read","competence:read","postref:write","afficherGr:read","grpco:read"})
     */
    private $GroupeDeCompetences;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, inversedBy="referentiels",cascade={"persist"})
     */
    private $Promos;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Archive;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"OnePromoReferentiel:read","OnePromo:read","grpcom:write","ref_grpe:read","competence:read","postref:write","afficherGr:read","grpco:read"})
     */
    private $Libelle;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Groups({"OnePromo:read","competence:read","postref:write","grpco:read"})
     */
    private $Programme;

    public function __construct()
    {
        $this->GroupeDeCompetences = new ArrayCollection();
        $this->Promos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPresentation(): ?string
    {
        return $this->Presentation;
    }

    public function setPresentation(string $Presentation): self
    {
        $this->Presentation = $Presentation;

        return $this;
    }

    public function getCriteresDevaluation(): ?string
    {
        return $this->CriteresDevaluation;
    }

    public function setCriteresDevaluation(string $CriteresDevaluation): self
    {
        $this->CriteresDevaluation = $CriteresDevaluation;

        return $this;
    }

    public function getCriteresDadmission(): ?string
    {
        return $this->CriteresDadmission;
    }

    public function setCriteresDadmission(string $CriteresDadmission): self
    {
        $this->CriteresDadmission = $CriteresDadmission;

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
     * @return Collection|Promo[]
     */
    public function getPromos(): Collection
    {
        return $this->Promos;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->Promos->contains($promo)) {
            $this->Promos[] = $promo;
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        $this->Promos->removeElement($promo);

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

    public function getLibelle(): ?string
    {
        return $this->Libelle;
    }

    public function setLibelle(?string $Libelle): self
    {
        $this->Libelle = $Libelle;

        return $this;
    }

    public function getProgramme()
    {
        return $this->Programme;
    }

    public function setProgramme($Programme): self
    {
        $this->Programme = $Programme;

        return $this;
    }
}
