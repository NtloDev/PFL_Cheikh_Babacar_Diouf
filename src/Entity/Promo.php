<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 * attributes = {
 *              "security" = "is_granted('ROLE_ADMIN')",
 *              "security_message" = "Accès refusé!"
 *       },
 * normalizationContext ={"groups"={"promo:read"}},
 * collectionOperations = {
 *      "getPromos" = {
 *              "method"= "GET",
 *              "path" = "/admin/promos"
 *       },
 *      "addPromo" = {
 *              "method"= "POST",
 *              "path" = "/admin/promos",
 *              "route_name" = "addPromo"
 *       }
 * },
 *
 * itemOperations = {
 *      "getApprenantsOfPromo" = {
 *              "method"= "GET",
 *              "path" = "/admin/promos/{id}/apprenants/"
 *
 *       },
 *      "getPromoById" = {
 *              "method"= "GET",
 *              "path" = "/admin/promos/{id}"
 *
 *       },
 *      "editPromo"={
 *          "method"= "PUT",
 *          "path"= "/admin/promos/{id}"
 *      },
 *      "archiverPromo" = {
 *          "method"= "PUT",
 *          "path" = "/admin/promos/{id}/archive",
 *          "controller" = ArchivagePromoController::class
 *       },
 *
 *      "getBriefsOfPromo"={
 *              "security"="is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/formateurs/promos/{id}/briefs",
 *              "normalization_context"={"groups"={"briefsofpromo:read"}},
 *          },
 *       "getBriefsOfApprenantsOfPromo"={
 *              "security"="is_granted('ROLE_Admin') or is_granted('ROLE_Apprenant') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/apprenants/promos/{id}/briefs",
 *              "normalization_context"={"groups"={"briefsofapprenantofpromo:read"}},
 *          },
 *
 *
 * },
 * )
 * @ORM\Entity(repositoryClass=PromoRepository::class)
 */
class Promo
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
    private $Langue;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Lieu;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Fabrique;

    /**
     * @ORM\Column(type="date")
     */
    private $DateDebut;

    /**
     * @ORM\Column(type="date")
     */
    private $DateFin;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archive;

    /**
     * @ORM\ManyToMany(targetEntity=ProfilDeSortie::class, inversedBy="promos")
     */
    private $ProfilsDeSorties;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, mappedBy="Promos",cascade={"persist"})
     */
    private $referentiels;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="Promo",cascade={"persist"})
     */
    private $groupes;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="promo")
     */
    private $Apprenants;

    public function __construct()
    {
        $this->ProfilsDeSorties = new ArrayCollection();
        $this->referentiels = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->Apprenants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLangue(): ?string
    {
        return $this->Langue;
    }

    public function setLangue(string $Langue): self
    {
        $this->Langue = $Langue;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): self
    {
        $this->Titre = $Titre;

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

    public function getLieu(): ?string
    {
        return $this->Lieu;
    }

    public function setLieu(string $Lieu): self
    {
        $this->Lieu = $Lieu;

        return $this;
    }

    public function getFabrique(): ?string
    {
        return $this->Fabrique;
    }

    public function setFabrique(string $Fabrique): self
    {
        $this->Fabrique = $Fabrique;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->DateDebut;
    }

    public function setDateDebut(\DateTimeInterface $DateDebut): self
    {
        $this->DateDebut = $DateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->DateFin;
    }

    public function setDateFin(\DateTimeInterface $DateFin): self
    {
        $this->DateFin = $DateFin;

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

    /**
     * @return Collection|ProfilDeSortie[]
     */
    public function getProfilsDeSorties(): Collection
    {
        return $this->ProfilsDeSorties;
    }

    public function addProfilsDeSorty(ProfilDeSortie $profilsDeSorty): self
    {
        if (!$this->ProfilsDeSorties->contains($profilsDeSorty)) {
            $this->ProfilsDeSorties[] = $profilsDeSorty;
        }

        return $this;
    }

    public function removeProfilsDeSorty(ProfilDeSortie $profilsDeSorty): self
    {
        $this->ProfilsDeSorties->removeElement($profilsDeSorty);

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
            $referentiel->addPromo($this);
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiels->removeElement($referentiel)) {
            $referentiel->removePromo($this);
        }

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
            $groupe->setPromo($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            // set the owning side to null (unless already changed)
            if ($groupe->getPromo() === $this) {
                $groupe->setPromo(null);
            }
        }

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
            $apprenant->setPromo($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->Apprenants->removeElement($apprenant)) {
            // set the owning side to null (unless already changed)
            if ($apprenant->getPromo() === $this) {
                $apprenant->setPromo(null);
            }
        }

        return $this;
    }
}
