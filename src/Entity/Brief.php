<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BriefRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(* collectionOperations = {
 *      "ajoutBrief"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_Formateur')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="POST",
 *              "path"="/formateurs/briefs",
 *              "denormalization_context"={"groups"={"brief:write"}},
 *          },
 *          "dupliquerBrief"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_Formateur')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="POST",
 *              "path"="/formateurs/briefs/{id}",
 *              "normalization_context"={"groups"={"briefe:write"}},
 *           },
 *      "getBriefs" = {
 *              "security" = "is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM')",
 *              "security_message" = "Accès refusé!",
 *              "method"= "GET",
 *              "path" = "/formateurs/briefs"
 *       },
 *
 *       "getBriefsOfGroupeOfPromo"={
 *              "security"="is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/formateurs/promos/{idP}/groupes/{idG}/briefs",
 *              "normalization_context"={"groups"={"briefsofgroupeofpromo:read"}},
 *        },
 *
 *        "getBriefsBrouillonsOfformateur" = {
 *        "security"="is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM')",
 *        "security_message"="ACCES REFUSE",
 *        "method" = "GET",
 *        "path" = "/formateurs/{id}/briefs/brouillons",
 *        "normalization_context"={"groups"={"briefsbrouillonsofformateur:read"}},
 *        },
 *        "getBriefsValidesOfformateur" = {
 *        "security"="is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM')",
 *        "security_message"="ACCES REFUSE",
 *        "method" = "GET",
 *        "path" = "/formateurs/{id}/briefs/valide",
 *        "normalization_context"={"groups"={"briefsvalidesofformateur:read"}},
 *        },
 * },)
 * @ORM\Entity(repositoryClass=BriefRepository::class)
 */
class Brief
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"brief:write"})
     */
    private $Titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"brief:write"})
     */
    private $Enonce;

    /**
     * @ORM\Column(type="date")
     * @Groups({"brief:write"})
     */
    private $DateDePoste;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"brief:write"})
     */
    private $DateEtHeureDecheance;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="briefs")
     *@Groups({"brief:write"})
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, inversedBy="briefs")
     * @Groups({"brief:write"})
     */
    private $Competences;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"brief:write"})
     */
    private $ListeAcquis;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"brief:write"})
     */
    private $Contraintes;

    /**
     * @ORM\ManyToMany(targetEntity=LivrableAttendu::class, inversedBy="briefs")
     */
    private $LivrableAttendus;

    /**
     * @ORM\ManyToMany(targetEntity=NiveauDevaluation::class, inversedBy="briefs")
     * @Groups({"brief:write"})
     */
    private $Niveaux;

    /**
     * @ORM\OneToMany(targetEntity=Ressource::class, mappedBy="Brief")
     * @Groups({"brief:write"})
     */
    private $ressources;

    /**
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="briefs")
     */
    private $Formateur;

    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, inversedBy="briefs")
     */
    private $Groupes;

    /**
     * @ORM\OneToMany(targetEntity=BriefMaPromo::class, mappedBy="Brief")
     */
    private $briefMaPromos;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->Competences = new ArrayCollection();
        $this->LivrableAttendus = new ArrayCollection();
        $this->Niveaux = new ArrayCollection();
        $this->ressources = new ArrayCollection();
        $this->Groupes = new ArrayCollection();
        $this->briefMaPromos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEnonce(): ?string
    {
        return $this->Enonce;
    }

    public function setEnonce(string $Enonce): self
    {
        $this->Enonce = $Enonce;

        return $this;
    }

    public function getDateDePoste(): ?\DateTimeInterface
    {
        return $this->DateDePoste;
    }

    public function setDateDePoste(\DateTimeInterface $DateDePoste): self
    {
        $this->DateDePoste = $DateDePoste;

        return $this;
    }

    public function getDateEtHeureDecheance(): ?\DateTimeInterface
    {
        return $this->DateEtHeureDecheance;
    }

    public function setDateEtHeureDecheance(\DateTimeInterface $DateEtHeureDecheance): self
    {
        $this->DateEtHeureDecheance = $DateEtHeureDecheance;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

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

    public function getListeAcquis(): ?string
    {
        return $this->ListeAcquis;
    }

    public function setListeAcquis(string $ListeAcquis): self
    {
        $this->ListeAcquis = $ListeAcquis;

        return $this;
    }

    public function getContraintes(): ?string
    {
        return $this->Contraintes;
    }

    public function setContraintes(string $Contraintes): self
    {
        $this->Contraintes = $Contraintes;

        return $this;
    }

    /**
     * @return Collection|LivrableAttendu[]
     */
    public function getLivrableAttendus(): Collection
    {
        return $this->LivrableAttendus;
    }

    public function addLivrableAttendu(LivrableAttendu $livrableAttendu): self
    {
        if (!$this->LivrableAttendus->contains($livrableAttendu)) {
            $this->LivrableAttendus[] = $livrableAttendu;
        }

        return $this;
    }

    public function removeLivrableAttendu(LivrableAttendu $livrableAttendu): self
    {
        $this->LivrableAttendus->removeElement($livrableAttendu);

        return $this;
    }

    /**
     * @return Collection|NiveauDevaluation[]
     */
    public function getNiveaux(): Collection
    {
        return $this->Niveaux;
    }

    public function addNiveau(NiveauDevaluation $niveau): self
    {
        if (!$this->Niveaux->contains($niveau)) {
            $this->Niveaux[] = $niveau;
        }

        return $this;
    }

    public function removeNiveau(NiveauDevaluation $niveau): self
    {
        $this->Niveaux->removeElement($niveau);

        return $this;
    }

    /**
     * @return Collection|Ressource[]
     */
    public function getRessources(): Collection
    {
        return $this->ressources;
    }

    public function addRessource(Ressource $ressource): self
    {
        if (!$this->ressources->contains($ressource)) {
            $this->ressources[] = $ressource;
            $ressource->setBrief($this);
        }

        return $this;
    }

    public function removeRessource(Ressource $ressource): self
    {
        if ($this->ressources->removeElement($ressource)) {
            // set the owning side to null (unless already changed)
            if ($ressource->getBrief() === $this) {
                $ressource->setBrief(null);
            }
        }

        return $this;
    }

    public function getFormateur(): ?Formateur
    {
        return $this->Formateur;
    }

    public function setFormateur(?Formateur $Formateur): self
    {
        $this->Formateur = $Formateur;

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->Groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->Groupes->contains($groupe)) {
            $this->Groupes[] = $groupe;
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        $this->Groupes->removeElement($groupe);

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
            $briefMaPromo->setBrief($this);
        }

        return $this;
    }

    public function removeBriefMaPromo(BriefMaPromo $briefMaPromo): self
    {
        if ($this->briefMaPromos->removeElement($briefMaPromo)) {
            // set the owning side to null (unless already changed)
            if ($briefMaPromo->getBrief() === $this) {
                $briefMaPromo->setBrief(null);
            }
        }

        return $this;
    }
}
