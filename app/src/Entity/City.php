<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/** Класс города */
#[ORM\Entity(repositoryClass: CityRepository::class)]
class City
{
    /** @var int|null Идентификатор города    */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /** @var string|null Название города     */
    #[ORM\Column(length: 50)]
    private ?string $name = null;

    /**
     * Улицы находящиеся в данном городе
     * @var Collection<int, Street>
     */
    #[ORM\OneToMany(targetEntity: Street::class, mappedBy: 'cityId', orphanRemoval: true)]
    private Collection $streets;

    /**
     * Определение зависимостей
     */
    public function __construct()
    {
        $this->streets = new ArrayCollection();
    }

    /**
     * Получить идентификатор города
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Получить название города
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Изменить название города
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Получить улицы города
     * @return Collection<int, Street>
     */
    public function getStreets(): Collection
    {
        return $this->streets;
    }

    /**
     * Добавить улицу городу
     * @param Street $street
     * @return $this
     */
    public function addStreet(Street $street): static
    {
        if (!$this->streets->contains($street)) {
            $this->streets->add($street);
            $street->setCityId($this);
        }

        return $this;
    }

    /**
     * Удалить улицу у города
     * @param Street $street
     * @return $this
     */
    public function removeStreet(Street $street): static
    {
        if ($this->streets->removeElement($street)) {
            // set the owning side to null (unless already changed)
            if ($street->getCityId() === $this) {
                $street->setCityId(null);
            }
        }

        return $this;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }
}
