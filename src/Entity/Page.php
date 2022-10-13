<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageRepository::class)]
class Page
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'string', length: 100)]
    private string $slug;

    #[ORM\Column(type: 'string', length: 255)]
    private string $titleH1;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $type;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $template;

    #[ORM\OneToMany(mappedBy: 'page', targetEntity: Content::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $contents;

    #[ORM\Column(type: 'string', length: 50)]
    private string $color;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private bool $isNavLinkOk;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private string $linkNameNav;

    public function __construct()
    {
        $this->contents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getTitleH1(): ?string
    {
        return $this->titleH1;
    }

    public function setTitleH1(string $titleH1): self
    {
        $this->titleH1 = $titleH1;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(?string $template): self
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return Collection<int, Content>
     */
    public function getContents(): Collection
    {
        return $this->contents;
    }

    public function addContent(Content $content): self
    {
        if (!$this->contents->contains($content)) {
            $this->contents[] = $content;
            $content->setPage($this);
        }

        return $this;
    }

    public function removeContent(Content $content): self
    {
        if ($this->contents->removeElement($content)) {
            // set the owning side to null (unless already changed)
            if ($content->getPage() === $this) {
                $content->setPage(null);
            }
        }

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function isIsNavLinkOk(): ?bool
    {
        return $this->isNavLinkOk;
    }

    public function setIsNavLinkOk(?bool $isNavLinkOk): self
    {
        $this->isNavLinkOk = $isNavLinkOk;

        return $this;
    }

    public function getLinkNameNav(): ?string
    {
        return $this->linkNameNav;
    }

    public function setLinkNameNav(?string $linkNameNav): self
    {
        $this->linkNameNav = $linkNameNav;

        return $this;
    }
}
