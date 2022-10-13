<?php

namespace App\Entity;

use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ContentRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ContentRepository::class)]
#[Vich\Uploadable]
class Content
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'text')]
    private string $body;

    #[ORM\Column(type: 'string', length: 150)]
    private string $summary;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $image = '';

    #[Vich\UploadableField(mapping: 'contents', fileNameProperty: 'image')]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $updatedAt = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $title;

    #[ORM\Column(type: 'datetime_immutable')]
    private null|DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $position;

    #[ORM\ManyToOne(targetEntity: Page::class, inversedBy: 'contents')]
    #[ORM\JoinColumn(nullable: false)]
    private Page $page;

    #[ORM\ManyToMany(targetEntity: Hook::class, inversedBy: 'contents', cascade: ['persist'])]
    private Collection $hook;

    public function __construct()
    {
        $this->hook = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): self|null
    {
        if ($page === null) {
            return null;
        }

        $this->page = $page;

        return $this;
    }
    /**
     * @return Collection<int, Hook>
     */
    public function getHook(): Collection
    {
        return $this->hook;
    }

    public function addHook(Hook $hook): self
    {
        if (!$this->hook->contains($hook)) {
            $this->hook[] = $hook;
        }

        return $this;
    }

    public function removeHook(Hook $hook): self
    {
        $this->hook->removeElement($hook);

        return $this;
    }

    /**
     * Get the value of imageFile
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * Set the value of imageFile
     *
     * @return  self
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }


    /**
     * Get the value of updatedAt
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
