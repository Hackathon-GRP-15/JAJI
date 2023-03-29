<?php

namespace App\Entity;

use App\Repository\ContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContentRepository::class)]
class Content
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'content')]
    private ?ContentType $contentType = null;

    #[ORM\ManyToMany(targetEntity: Tag::class, mappedBy: 'content')]
    private Collection $tags;

    #[ORM\OneToMany(mappedBy: 'content', targetEntity: Media::class)]
    private Collection $media;

    #[ORM\OneToMany(mappedBy: 'content', targetEntity: ContentText::class)]
    private Collection $contentTexts;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->media = new ArrayCollection();
        $this->contentTexts = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getContentType(): ?ContentType
    {
        return $this->contentType;
    }

    public function setContentType(?ContentType $contentType): self
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
            $tag->addContent($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeContent($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedium(Media $medium): self
    {
        if (!$this->media->contains($medium)) {
            $this->media->add($medium);
            $medium->setContent($this);
        }

        return $this;
    }

    public function removeMedium(Media $medium): self
    {
        if ($this->media->removeElement($medium)) {
            // set the owning side to null (unless already changed)
            if ($medium->getContent() === $this) {
                $medium->setContent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ContentText>
     */
    public function getContentTexts(): Collection
    {
        return $this->contentTexts;
    }

    public function addContentText(ContentText $contentText): self
    {
        if (!$this->contentTexts->contains($contentText)) {
            $this->contentTexts->add($contentText);
            $contentText->setContent($this);
        }

        return $this;
    }

    public function removeContentText(ContentText $contentText): self
    {
        if ($this->contentTexts->removeElement($contentText)) {
            // set the owning side to null (unless already changed)
            if ($contentText->getContent() === $this) {
                $contentText->setContent(null);
            }
        }

        return $this;
    }
}
