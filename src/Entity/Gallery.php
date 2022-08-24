<?php

namespace App\Entity;

use App\Repository\GalleryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GalleryRepository::class)
 */
class Gallery
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_real;


    /**
     * @ORM\OneToMany(targetEntity=GalleryItem::class, mappedBy="gallery", orphanRemoval=true)
     */
    private $galleryItems;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="galleries")
     */
    private $user;

    public function __construct()
    {
        $this->galleryItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isIsReal(): ?bool
    {
        return $this->is_real;
    }

    public function setIsReal(bool $is_real): self
    {
        $this->is_real = $is_real;

        return $this;
    }

    /**
     * @return Collection<int, GalleryItem>
     */
    public function getGalleryItems(): Collection
    {
        return $this->galleryItems;
    }

    public function addGalleryItem(GalleryItem $galleryItem): self
    {
        if (!$this->galleryItems->contains($galleryItem)) {
            $this->galleryItems[] = $galleryItem;
            $galleryItem->setGallery($this);
        }

        return $this;
    }

    public function removeGalleryItem(GalleryItem $galleryItem): self
    {
        if ($this->galleryItems->removeElement($galleryItem)) {
            // set the owning side to null (unless already changed)
            if ($galleryItem->getGallery() === $this) {
                $galleryItem->setGallery(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUserID(): ?int
    {
        return $this->user->getId();
    }
}
