<?php

namespace App\Entity;

use App\Repository\StreetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/** Класс названия улиц */
#[ORM\Entity(repositoryClass: StreetRepository::class)]
class Street
{
    /** @var int|null Идентификатор улицы  */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /** @var string|null Название улицы  */
    #[ORM\Column(length: 100)]
    private ?string $name = null;

    /**
     * Связь улицы с городом
     * @var City|null
     */
    #[ORM\ManyToOne(inversedBy: 'streets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?City $cityId = null;

    /**
     * @var Collection<int, Building>
     */
    #[ORM\OneToMany(targetEntity: Building::class, mappedBy: 'streetId', orphanRemoval: true)]
    private Collection $buildings;

    /**
     * Определение зависимостей
     */
    public function __construct()
    {
        $this->buildings = new ArrayCollection();
    }

    /**
     * Получить Идентификатор улицы
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Получить название улицы
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Изменить название улицы
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Получить идентификатор города которому принадлежит улица
     * @return City|null
     */
    public function getCityId(): ?City
    {
        return $this->cityId;
    }

    /**
     * Изменить город, которому принадлежит улица
     * @param City|null $cityId
     * @return $this
     */
    public function setCityId(?City $cityId): static
    {
        $this->cityId = $cityId;

        return $this;
    }

    /**
     * Получить номера домов данной улицы
     * @return Collection<int, Building>
     */
    public function getBuildings(): Collection
    {
        return $this->buildings;
    }

    /**
     * Добавить здание на улицу
     * @param Building $building
     * @return $this
     */
    public function addBuilding(Building $building): static
    {
        if (!$this->buildings->contains($building)) {
            $this->buildings->add($building);
            $building->setStreetId($this);
        }

        return $this;
    }

    /**
     * Удалить здание с улицы
     * @param Building $building
     * @return $this
     */
    public function removeBuilding(Building $building): static
    {
        if ($this->buildings->removeElement($building)) {
            // set the owning side to null (unless already changed)
            if ($building->getStreetId() === $this) {
                $building->setStreetId(null);
            }
        }

        return $this;
    }
}
