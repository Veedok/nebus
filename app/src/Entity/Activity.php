<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/** Класс вида деятельности */
#[ORM\Entity(repositoryClass: ActivityRepository::class)]
class Activity
{
    /** @var int|null Идентификатор вида деятельности     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /** @var string|null Название вида деятельности     */
    #[ORM\Column(length: 100)]
    private ?string $name = null;

    /** @var int|null Родитель если 0 то это верхняя группа */
    #[ORM\Column]
    private ?int $parent = null;

    /**
     * Организации относящиеся к виду деятельности
     * @var Collection<int, Organization>
     */
    #[ORM\ManyToMany(targetEntity: Organization::class, mappedBy: 'activity')]
    private Collection $organizations;

    /**
     * Определение зависимостей
     */
    public function __construct()
    {
        $this->organizations = new ArrayCollection();
    }

    /**
     * Получить идентификатор вида деятельности
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Получить название вида деятельности
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Изменить название вида деятельности
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Получить родительский идентификатор вида деятельности
     * @return int|null
     */
    public function getParent(): ?int
    {
        return $this->parent;
    }

    /**
     * Изменить родительский идентификатор вида деятельности
     * @param int $parent
     * @return $this
     */
    public function setParent(int $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, Organization>
     */
    public function getOrganizations(): Collection
    {
        return $this->organizations;
    }

    /**
     * Добавить организацию к виду деятельности
     * @param Organization $organization
     * @return $this
     */
    public function addOrganization(Organization $organization): static
    {
        if (!$this->organizations->contains($organization)) {
            $this->organizations->add($organization);
            $organization->addActivity($this);
        }

        return $this;
    }

    /**
     * Удалить организацию из вида деятельности
     * @param Organization $organization
     * @return $this
     */
    public function removeOrganization(Organization $organization): static
    {
        if ($this->organizations->removeElement($organization)) {
            $organization->removeActivity($this);
        }

        return $this;
    }
}
