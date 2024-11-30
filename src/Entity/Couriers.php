<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CouriersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouriersRepository::class)]
#[ApiResource]
class Couriers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(type: 'string')]
    private ?string $name = null;

    // Геттер для name
    public function getName(): ?string
    {
        return $this->name;
    }

    // Сеттер для name
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    // Геттер для id
    public function getId(): ?int
    {
        return $this->id;
    }
}
