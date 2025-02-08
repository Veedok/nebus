<?php

namespace App\Entity\Address;

use App\Entity\Organization;
use App\Repository\Address\BuildingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/** Класс зданий и координат здания */
#[ORM\Entity(repositoryClass: BuildingRepository::class)]
class Building
{
    /** @var int|null Идентификатор здания */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /** @var string|null Номер дома (строкой потому что бывают подобные адреса "7а/2 стр 1") */
    #[ORM\Column(length: 20)]
    private ?string $num = null;

    /** @var Street|null Улица на которой находится дом */
    #[ORM\ManyToOne(inversedBy: 'buildings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Street $streetId = null;

    /** @var float|null Широта */
    #[ORM\Column]
    private ?float $latitude = null;

    /**  @var float|null Долгота */
    #[ORM\Column]
    private ?float $longitude = null;

    /** @var Collection<int, Organization> Организации */
    #[ORM\OneToMany(targetEntity: Organization::class, mappedBy: 'address')]
    private Collection $organizations;

    /**
     * Определение зависимостей
     */
    public function __construct()
    {
        $this->organizations = new ArrayCollection();
    }

    /**
     * Получить идентификатор здания
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Получить № здания
     * @return string|null
     */
    public function getNum(): ?string
    {
        return $this->num;
    }

    /**
     * Изменить номер здания
     * @param string $num
     * @return $this
     */
    public function setNum(string $num): static
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Получить идентификатор улицы на которой находится здание
     * @return Street|null
     */
    public function getStreetId(): ?Street
    {
        return $this->streetId;
    }

    /**
     * Изменить улицу на которой находится здание
     * @param Street|null $streetId
     * @return $this
     */
    public function setStreetId(?Street $streetId): static
    {
        $this->streetId = $streetId;

        return $this;
    }

    /**
     * Получить широту здания
     * @return float|null
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * Изменить широту здания
     * @param float $latitude
     * @return $this
     */
    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Получить долготу здания
     * @return float|null
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * Изменить долготу здания
     * @param float $longitude
     * @return $this
     */
    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return Collection<int, Organization>
     */
    public function getOrganizations(): Collection
    {
        return $this->organizations;
    }

    public function addOrganization(Organization $organization): static
    {
        if (!$this->organizations->contains($organization)) {
            $this->organizations->add($organization);
            $organization->setAddress($this);
        }

        return $this;
    }

    public function removeOrganization(Organization $organization): static
    {
        if ($this->organizations->removeElement($organization)) {
            // set the owning side to null (unless already changed)
            if ($organization->getAddress() === $this) {
                $organization->setAddress(null);
            }
        }

        return $this;
    }
}
