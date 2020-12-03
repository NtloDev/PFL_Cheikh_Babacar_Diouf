<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeDeTagsRepository;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     collectionOperations={
 *           "getGroupeTags"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/admin/grptags",
 *              "normalization_context"={"groups"={"Grptags:read"}},
 *          },
 *          "POST"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="POST",
 *              "path"="/admin/grptags",
 *              "normalization_context"={"groups"={"Grptags:write"}},
 *              "denormalization_context"={"groups"={"Grptaggs:write"}},
 *          },
 *
 *      },
 * itemOperations={
 *
 *      "getOneGroupeTag"={
 *          "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *          "security_message"="ACCES REFUSE",
 *          "method"= "GET",
 *          "path"= "/admin/grptags/{id}",
 *          "normalization_context"={"groups"={"OneTag:read"}},
 *      },
 *     "getOneGroupeTagtag"={
 *          "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *          "security_message"="ACCES REFUSE",
 *          "method"= "GET",
 *          "path"= "/admin/grptags/{id}/tags",
 *          "normalization_context"={"groups"={"OnegrpTagtag:read"}},
 *      },
 *     "putgrptag"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="PUT",
 *              "path"="/admin/grptags/{id}",
 *              "denormalization_context"={"groups"={"Grptaggs:write"}},
 *          },
 *     "DeleteGroupeTag"={
 *          "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *          "security_message"="ACCES REFUSE",
 *          "method"= "DELETE",
 *          "path"= "/admin/grptags/{id}",
 *          "normalization_context"={"groups"={"OnegrpTag:write"}},
 *      },
 *     }
 * )
 * @ORM\Entity(repositoryClass=GroupeDeTagsRepository::class)
 */
class GroupeDeTags
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"tags:write","Grptaggs:write","taggs:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"tags:read","tags:write","OneTag:read","Grptags:read","OneTag:read","OnegrpTagtag:read","Grptaggs:write","taggs:write"})
     */
    private $Libelle;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, mappedBy="GroupeDeTags",cascade="persist")
     * @Groups({"Grptags:read","OnegrpTagtag:read","Grptaggs:write"})
     */
    private $tags;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"taggs:write"})
     */
    private $Archive=false;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
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
            $tag->addGroupeDeTag($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeGroupeDeTag($this);
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
}
