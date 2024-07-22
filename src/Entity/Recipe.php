<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use App\Validator\BanWord;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints  as Assert;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]

#[UniqueEntity('title')]
class Recipe
{ 
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min:10)]
    #[BanWord(groups:['Extra'])]
    // #[Assert\Regex( message:"Ceci nes pas un titre valid!")]
    private ?string $title = null;
    
    #[ORM\Column]
    
    private ?\DateTimeImmutable $createdAt = null;
    

    #[ORM\Column]
   
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(min:1)]
    #[Assert\NotBlank()]
    #[Assert\Positive()]
    #[assert\LessThan(value:1440)]
    private ?string $duration = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length(min:50)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(?string $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

}
