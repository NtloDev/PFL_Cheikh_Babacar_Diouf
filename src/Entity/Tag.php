<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TagRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 * collectionOperations={
 *          "getTags"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/admin/tags",
 *              "normalization_context"={"groups"={"tags:read"}},
 *          },
 *          "post"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="ACCES REFUSE",
 *              "path"="/admin/tags",
 *              "denormalization_context"={"groups"={"taggs:write"}},
 *          },
 *
 *      },
 * itemOperations={
 *
 *      "getOneTag"={
 *          "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *          "security_message"="ACCES REFUSE",
 *          "method"= "GET",
 *          "path"= "/admin/tags/{id}",
 *          "normalization_context"={"groups"={"OneTag:read"}},
 *      },
 *     "putTag"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="PUT",
 *              "path"="/admin/tags/{id}",
 *              "denormalization_context"={"groups"={"taggs:write"}},
 *          },
 *     "DeleteTag"={
 *          "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *          "security_message"="ACCES REFUSE",
 *          "method"= "DELETE",
 *          "path"= "/admin/tags/{id}",
 *          "normalization_context"={"groups"={"OneTag:write"}},
 *      },
 * },
 * )
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"Grptaggs:write","taggs:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"tags:read","OneTag:read","Grptags:read","OnegrpTagtag:read","Grptaggs:write","taggs:write"})
     */
    private $Libelle;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeDeTags::class, inversedBy="tags",cascade="persist")
     * @ApiSubresource
     * @Groups({"tags:read","OneTag:read","taggs:write"})
     */
    private $GroupeDeTags;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"taggs:write"})
     */
    private $Archive=false;

    public function __construct()
    {
        $this->GroupeDeTags = new ArrayCollection();
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

    /**
     * @return Collection|GroupeDeTags[]
     */
    public function getGroupeDeTags(): Collection
    {
        return $this->GroupeDeTags;
    }

    public function addGroupeDeTag(GroupeDeTags $groupeDeTag): self
    {
        if (!$this->GroupeDeTags->contains($groupeDeTag)) {
            $this->GroupeDeTags[] = $groupeDeTag;
        }

        return $this;
    }

    public function removeGroupeDeTag(GroupeDeTags $groupeDeTag): self
    {
        $this->GroupeDeTags->removeElement($groupeDeTag);

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
