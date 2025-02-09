<?php

namespace App\Entity;

use App\Entity\Address\Building;
use App\Repository\OrganizationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/** Класс организации */
#[ORM\Entity(repositoryClass: OrganizationRepository::class)]
class Organization
{
    /** @var int|null Идентификатор организации     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    /** @var string|null Название организации     */
    #[ORM\Column(length: 150)]
    private ?string $name = null;

    /** @var array|null Телефоны организации     */
    #[ORM\Column(nullable: true)]
    private ?array $phones = null;

    /** @var Building|null Адрес организации    */
    #[ORM\ManyToOne(inversedBy: 'organizations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Building $address = null;

    /** @var Collection<int, Activity> Виды деятельности организации     */
    #[ORM\ManyToMany(targetEntity: Activity::class, inversedBy: 'organizations')]
    private Collection $activity;

    /**
     * Определение зависимостей
     */
    public function __construct()
    {
        $this->activity = new ArrayCollection();
    }

    /**
     * Получить идентификатор организации
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Получить название организации
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Изменить название организации
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Получить телефоны организации
     * @return array|null
     */
    public function getPhones(): ?array
    {
        return $this->phones;
    }


    /**
     * Изменить телефоны организации
     * @param array|null $phones
     * @return $this
     */
    public function setPhones(?array $phones): static
    {
        $this->phones = $phones;

        return $this;
    }

    /**
     * Получить адрес организации
     * @return Building|null
     */
    public function getAddress(): ?Building
    {
        return $this->address;
    }

    /**
     * Изменить адрес организации
     * @param Building|null $address
     * @return $this
     */
    public function setAddress(?Building $address): static
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Получить виды деятельности организации
     * @return Collection<int, Activity>
     */
    public function getActivity(): Collection
    {
        return $this->activity;
    }

    /**
     * Добавить вид деятельности организации
     * @param Activity $activity
     * @return $this
     */
    public function addActivity(Activity $activity): static
    {
        if (!$this->activity->contains($activity)) {
            $this->activity->add($activity);
        }

        return $this;
    }

    /**
     * Удалить вид деятельности у организации
     * @param Activity $activity
     * @return $this
     */
    public function removeActivity(Activity $activity): static
    {
        $this->activity->removeElement($activity);

        return $this;
    }
}
