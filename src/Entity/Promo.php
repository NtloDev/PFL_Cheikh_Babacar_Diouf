<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
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
 * collectionOperations = {
 *      "getPromos" = {
 *              "method"= "GET",
 *              "path" = "/admin/promos",
 *              "normalization_context"={"groups"={"Promos:read"}},
 *       },
 *     "getPromoGroupePrincipal" = {
 *              "method"= "GET",
 *              "path" = "/admin/promos/principal",
 *              "normalization_context"={"groups"={"Promos:read"}},
 *       },
 *     "getPromoApprenantAttente" = {
 *              "method"= "GET",
 *              "path" = "/admin/promos/apprenants/attente",
 *              "normalization_context"={"groups"={"Promos:read"}},
 *       },
 *      "addPromo" = {
 *              "method"= "POST",
 *              "path" = "/admin/promos",
 *              "route_name" = "addPromo"
 *       }
 * },
 *
 * itemOperations = {
 *     "getPromo" = {
 *              "method"= "GET",
 *              "path" = "/admin/promos/{id}/",
 *              "normalization_context"={"groups"={"OnePromo:read"}},
 *
 *       },
 *      "getApprenantsOfPromo" = {
 *              "method"= "GET",
 *              "path" = "/admin/promos/{id}/principal/",
 *              "normalization_context"={"groups"={"OnePromoPrincipal:read"}},
 *
 *       },
 *      "getPromoReferentielCompetences" = {
 *              "method"= "GET",
 *              "path" = "/admin/promos/{id}/referentiels",
 *              "normalization_context"={"groups"={"OnePromoReferentiel:read"}},
 *
 *       },
 *     "getPromoApprenantsEnAttente" = {
 *              "method"= "GET",
 *              "path" = "/admin/promos/{id}/apprenants/attente",
 *              "normalization_context"={"groups"={"OnePromoApprenantAAttente:read"}},
 *
 *       },
 *     "getPromoGroupeApprenants" = {
 *              "method"= "GET",
 *              "path" = "/admin/promos/{id}/groupes/{id_g}/apprenants",
 *              "normalization_context"={"groups"={"OnePromogroupeApprenants:read"}},
 *
 *       },
 *     "getFormateursGroupeReferentiel" = {
 *              "method"= "GET",
 *              "path" = "/admin/promos/{id}/formateurs",
 *              "normalization_context"={"groups"={"OnePromoFormateursgroupeApprenants:read"}},
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
     * @Groups({"Promos:read","OnePromoPrincipal:read","OnePromoReferentiel:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"OnePromoFormateursgroupeApprenants:read","OnePromogroupeApprenants:read","OnePromoApprenantAAttente:read","Promos:read","OnePromo:read","OnePromoPrincipal:read","OnePromoReferentiel:read"})
     */
    private $Langue;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"OnePromoFormateursgroupeApprenants:read","OnePromogroupeApprenants:read","OnePromoApprenantAAttente:read","Promos:read","OnePromo:read","OnePromoPrincipal:read","OnePromoReferentiel:read"})
     */
    private $Titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"OnePromogroupeApprenants:read","OnePromoApprenantAAttente:read","Promos:read","OnePromo:read","OnePromoPrincipal:read","OnePromoReferentiel:read"})
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"OnePromoApprenantAAttente:read","Promos:read","OnePromo:read","OnePromoPrincipal:read","OnePromoReferentiel:read"})
     */
    private $Lieu;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"OnePromoApprenantAAttente:read","Promos:read","OnePromo:read","OnePromoPrincipal:read","OnePromoReferentiel:read"})
     */
    private $Fabrique;

    /**
     * @ORM\Column(type="date")
     * @Groups({"OnePromoApprenantAAttente:read","Promos:read","OnePromo:read","OnePromoPrincipal:read","OnePromoReferentiel:read"})
     */
    private $DateDebut;

    /**
     * @ORM\Column(type="date")
     * @Groups({"OnePromoApprenantAAttente:read","Promos:read","OnePromo:read","OnePromoPrincipal:read","OnePromoReferentiel:read"})
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
     * @Groups({"OnePromoFormateursgroupeApprenants:read","OnePromoApprenantAAttente:read","Promos:read","OnePromo:read","OnePromoPrincipal:read","OnePromoReferentiel:read"})
     */
    private $referentiels;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="Promo",cascade={"persist"})
     * @Groups({"OnePromoFormateursgroupeApprenants:read","OnePromogroupeApprenants:read","Promos:read","OnePromo:read"})
     */
    private $groupes;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="promo")
     * @Groups({"OnePromoApprenantAAttente:read","Promos:read","OnePromoPrincipal:read"})
     */
    private $Apprenants;

    /**
     * @ORM\OneToMany(targetEntity=BriefMaPromo::class, mappedBy="Promo")
     */
    private $briefMaPromos;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="promos")
     *@Groups({"Promos:read","OnePromo:read","OnePromoPrincipal:read"})
     */
    private $Formateurs;

    public function __construct()
    {
        $this->ProfilsDeSorties = new ArrayCollection();
        $this->referentiels = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->Apprenants = new ArrayCollection();
        $this->briefMaPromos = new ArrayCollection();
        $this->Formateurs = new ArrayCollection();
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

    /**
     * @return Collection|BriefMaPromo[]
     */
    public function getBriefMaPromos(): Collection
    {
        return $this->briefMaPromos;
    }

    public function addBriefMaPromo(BriefMaPromo $briefMaPromo): self
    {
        if (!$this->briefMaPromos->contains($briefMaPromo)) {
            $this->briefMaPromos[] = $briefMaPromo;
            $briefMaPromo->setPromo($this);
        }

        return $this;
    }

    public function removeBriefMaPromo(BriefMaPromo $briefMaPromo): self
    {
        if ($this->briefMaPromos->removeElement($briefMaPromo)) {
            // set the owning side to null (unless already changed)
            if ($briefMaPromo->getPromo() === $this) {
                $briefMaPromo->setPromo(null);
            }
        }

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
