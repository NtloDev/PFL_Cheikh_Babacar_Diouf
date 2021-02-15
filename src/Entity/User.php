<?php

namespace App\Entity;

use App\Entity\Formateur;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;



/**
 * @ApiFilter(BooleanFilter::class, properties={"Archivage"})
 * @ApiResource(
 * attributes = {
 *
 *              "security" = "is_granted('ROLE_ADMIN')",
 *              "security_message" = "Accès refusé!"
 *       },
 * collectionOperations = {
 *     "getUsers" = {
 *              "method"= "GET",
 *              "path" = "/admin/users",
 *              "normalization_context"={"groups"={"users:read"}}
 *       },
 *      "create_user"={
 *              "method"="POST",
 *              "path"="/admin/users",
 *              "route_name" = "create_user",
 *              "deserialize" = false
 *       },
 * },
 * itemOperations={
 *      "getUserById"={
 *          "method"= "GET",
 *          "path"= "/admin/users/{id}",
 *          "normalization_context"={"groups"={"OneUser:read"}}
 *      },
 *      "editUser"={
 *          "method"= "PUT",
 *          "path"= "/admin/users/{id}"  
 *      },
 *      "archive_user" = {
 *          "method"= "DELETE",
 *          "path" = "/admin/users/{id}/archive"  
 *          
 *       },"putUserId"={
 *              "method"="PUT",
 *              "path"="api/admin/users/{id}",
 *              "route_name" = "putUserId",
 *              "deserialize"=false
 *       },
 * }
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="dtype", type="string")
 * @DiscriminatorMap({"formateur" = "Formateur", "apprenant" = "Apprenant","user"="User","cm"="CM","admin"="Admin"})
 */
class User implements UserInterface
{
    /**
     * @ORM\Id.
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"users:read","OneUser:read","OnePromoPrincipal:read"})
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"OneUser:read","ProfilUsers:read","profilUser:read","users:read","Promos:read","OnePromo:read"})
     */
    private $username;

    
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"OneUser:read","OnePromoFormateursgroupeApprenants:read","OnePromogroupeApprenants:read","OnePromoApprenantAAttente:read","OnePromoPrincipal:read","ProfilUsers:read","profilUser:read","users:read","profilsdesortieapprenants:read","Promos:read","OnePromo:read"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"OneUser:read","OnePromoFormateursgroupeApprenants:read","OnePromogroupeApprenants:read","OnePromoApprenantAAttente:read","OnePromoPrincipal:read","ProfilUsers:read","profilUser:read","users:read","profilsdesortieapprenants:read","OnePromo:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"OnePromoPrincipal:read","OneUser:read","users:read","profilUser:read"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"OnePromoPrincipal:read","OneUser:read","users:read"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"OneUser:read","users:read"})
     */
    private $genre;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="Users")
     * @ORM\JoinColumn(nullable=true)
     */
    private $profil;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $avatar;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Archivage;


    public function __construct()
    {
        $this->formateurs = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getDtype(): string
    {
        return (string) $this->Dtype;
    }

    public function setDtype(string $Dtype): self
    {
        $this->Dtype = $Dtype;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this->profil->getLibelle();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getArchivage(): ?bool
    {
        return $this->Archivage;
    }

    public function setArchivage(bool $Archivage): self
    {
        $this->Archivage = $Archivage;

        return $this;
    }

   
}
