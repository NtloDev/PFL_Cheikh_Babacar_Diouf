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
 * @ApiFilter(BooleanFilter::class, properties={"archive"})
 * @ApiResource(
 * attributes = {
 *              
 *              "security" = "is_granted('ROLE_ADMIN')",
 *              "security_message" = "Accès refusé!"
 *       },
 * collectionOperations = {
 *      "create_user"={
 *              "method"="POST",
 *              "path"="/admin/users",
 *              "route_name" = "create_user",
 *              "deserialize"=false   
 *       },
 *       "getUsers" = {
 *              "method"= "GET",
 *              "path" = "/admin/users",
 *              "normalization_context"={"groups"={"users:read"}} 
 *       },
 * },
 * itemOperations={
 *      "getUserById"={
 *          "method"= "GET",
 *          "path"= "/admin/users/{id}"  
 *      },
 *      "editUser"={
 *          "method"= "PUT",
 *          "path"= "/admin/users/{id}"  
 *      },
 *      "archiverUser" = {
 *          "method"= "PUT",
 *          "path" = "/admin/users/{id}/archive",
 *          "controller" = ArchivageUserController::class   
 *       }
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
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"ProfilUsers:read","profilUser:read","users:read"})
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
     * @Groups({"ProfilUsers:read","profilUser:read","users:read"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"ProfilUsers:read","profilUser:read","users:read"})
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"users:read"})
     */
    private $Email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"users:read"})
     */
    private $Telephone;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archive;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"users:read"})
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
        return $this->Nom;
    }

    public function setNom(?string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->Telephone;
    }

    public function setTelephone(string $Telephone): self
    {
        $this->Telephone = $Telephone;

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

   
}
