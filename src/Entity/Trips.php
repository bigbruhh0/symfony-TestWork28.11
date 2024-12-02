<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TripsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TripsRepository::class)]
#[ApiResource]
class Trips
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\ManyToOne(targetEntity: Couriers::class)]
    #[ORM\JoinColumn(name: 'courier_id', referencedColumnName: 'id', nullable: false)]
    private ?Couriers $courier = null;


    #[ORM\ManyToOne(targetEntity: Regions::class)]
    #[ORM\JoinColumn(name: 'region_id', referencedColumnName: 'id', nullable: false)]
    private ?Regions $region = null;


    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $beginDate = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $endDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourier(): ?Couriers
    {
        return $this->courier;
    }

    public function setCourier(?Couriers $courier): self
    {
        $this->courier = $courier;

        return $this;
    }

    public function getRegion(): ?Regions
    {
        return $this->region;
    }

    public function setRegion(?Regions $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getBeginDate(): ?\DateTimeInterface
    {
        return $this->beginDate;
    }
    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }
}
