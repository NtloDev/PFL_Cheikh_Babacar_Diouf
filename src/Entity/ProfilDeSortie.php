<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use App\Repository\ProfilDeSortieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
/**
 * @ApiFilter(BooleanFilter::class, properties={"archive"})
 * @ApiResource(
 * attributes = {
 *              "security" = "is_granted('ROLE_ADMIN')",
 *              "security_message" = "Accès refusé!"
 *       },
 * normalizationContext ={"groups"={"profilsdesortie:read"}},
 * collectionOperations = {
 *      "getProfilsDeSortie" = {
 *              "method"= "GET",
 *              "path" = "/admin/profilsorties",
 *              "normalization_context"={"groups"={"profilsdesortie:read"}}
 *
 *       },
 *
 *       "addProfilsDeSortie" = {
 *              "method"= "POST",
 *              "path" = "/admin/profilsorties",
 *              "normalization_context"={"groups"={"profilsdesortie:write"}}
 *       },
 * },
 * itemOperations = {
 *      "getUsersOfProfilDeSortie" = {
 *              "method"= "GET",
 *              "path" = "/admin/profilsdesortie/{id}/apprenants/",
 *              "normalization_context"={"groups"={"profilsdesortieapprenants:read"}}
 *
 *       },
 *      "getProfilDeSortieById" = {
 *              "method"= "GET",
 *              "path" = "/admin/profilsdesortie/{id}"
 *
 *       },
 *      "editProfilDeSortie"={
 *          "method"= "PUT",
 *          "path"= "/admin/profilsdesortie/{id}"
 *      },
 *      "deleteProfilDeSortie"={
 *          "method"= "DELETE",
 *          "path"= "/admin/profilsdesortie/{id}"
 *      },
 *
 * },
 * )
 * @ORM\Entity(repositoryClass=ProfilDeSortieRepository::class)
 */
class ProfilDeSortie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"profilsdesortie:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * Assert\NotBlank(message="Le libelle ne doit pas être vide")
     * @Assert\Length(
     *      min = 3,
     *      max = 100,
     *      minMessage = "Le libelle doit avoir au moins {{ limit }} charactères",
     *      maxMessage = "Le libelle ne doit pas dépasser {{ limit }} charactères"
     * )
     * @Groups({"profilsdesortieapprenants:read","profilsdesortie:read"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="profilDeSortie")
     * @ApiSubresource
     * @Groups({"profilsdesortieapprenants:read"})
     */
    private $Apprenants;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, mappedBy="ProfilsDeSorties")
     * @ApiSubresource
     */
    private $promos;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archive;

    public function __construct()
    {
        $this->Apprenants = new ArrayCollection();
        $this->promos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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
            $apprenant->setProfilDeSortie($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->Apprenants->removeElement($apprenant)) {
            // set the owning side to null (unless already changed)
            if ($apprenant->getProfilDeSortie() === $this) {
                $apprenant->setProfilDeSortie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Promo[]
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promos->contains($promo)) {
            $this->promos[] = $promo;
            $promo->addProfilsDeSorty($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->removeElement($promo)) {
            $promo->removeProfilsDeSorty($this);
        }

        return $this;
    }

    public function getArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }
}
