<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfilRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

/**
 * @ApiResource(
 * attributes = {
 *              "security" = "is_granted('ROLE_ADMIN')",
 *              "security_message" = "Accès refusé!"
 *       },
 * collectionOperations = {
 *      "getProfils" = {
 *              "method"= "GET",
 *              "path" = "/admin/profils",
 *              "normalization_context" ={"groups"={"profil:read"}},
 *              
 *       },
 *      "showProfilUsers" = {
 *              "method"= "GET",
 *              "path" = "admin/profils/{id}/users",
 *              "normalization_context"={"groups"={"ProfilUsers:read"}}   
 *       },
 *       
 *       "addProfil" = {
 *              "method"= "POST",
 *              "path" = "/admin/profils",
 *              "normalization_context"={"groups"={"profil:write"}}   
 *       },
 * },
 * 
 * itemOperations = {
 *      "getUsersOfProfil" = {
 *              "method"= "GET",
 *              "path" = "/admin/profil/{id}/users/",
 *              "normalization_context"={"groups"={"profilUser:read"}}
 *              
 *       },
 *      "getProfilById" = {
 *              "method"= "GET",
 *              "path" = "/admin/profils/{id}",
 *              "normalization_context"={"groups"={"Oneprofil:read"}}
 *              
 *       },
 *      "editProfil"={
 *          "method"= "PUT",
 *          "path"= "/admin/profils/{id}",
 *          "normalization_context"={"groups"={"Oneprofil:write"}}
 *      },
 *      "deleteProfil"={
 *          "method"= "DELETE",
 *          "path"= "/admin/profils/{id}",
 *          "normalization_context"={"groups"={"Oneprofil:write"}}
 *      },
 * 
 * },
 * )
 * @ORM\Entity(repositoryClass=ProfilRepository::class)
 */
class Profil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le libelle ne doit pas être vide")
     * @Assert\Length(
     *      min = 3,
     *      max = 100,
     *      minMessage = "Le libelle ne doit avoir au moins {{ limit }} charactères",
     *      maxMessage = "Le libelle ne doit pas dépasser {{ limit }} charactères"
     * )
     * @Groups({"profil:read","ProfilUsers:read","profilUser:read","Oneprofil:read","Oneprofil:write"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profil")
     * @Groups({"ProfilUsers:read","profilUser:read"})
     */
    private $Users;

    public function __construct()
    {
        $this->Users = new ArrayCollection();
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
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->Users;
    }

    public function addUser(User $user): self
    {
        if (!$this->Users->contains($user)) {
            $this->Users[] = $user;
            $user->setProfil($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->Users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProfil() === $this) {
                $user->setProfil(null);
            }
        }

        return $this;
    }
}
