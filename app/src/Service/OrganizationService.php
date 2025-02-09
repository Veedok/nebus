<?php

namespace App\Service;

use App\DTO\CoordinatesDTO;
use App\DTO\IdDTO;
use App\DTO\TreeDTO;
use App\Entity\Activity;
use App\Entity\Organization;
use App\Repository\ActivityRepository;
use App\Repository\Address\BuildingRepository;
use App\Repository\OrganizationRepository;

/** Сервис для работы с организациями */
readonly class OrganizationService
{

    /**
     * Определение зависимостей
     * @param OrganizationRepository $orgRepository
     * @param ActivityRepository $activityRepository
     * @param BuildingRepository $buildingRepository
     */
    public function __construct(
        private OrganizationRepository $orgRepository,
        private ActivityRepository     $activityRepository,
        private BuildingRepository     $buildingRepository,
    )
    {
    }

    /**
     * Возвращает список организаций по идентификатору здания
     * @param IdDTO $idDTO
     * @return array
     */
    public function getOrgInBuilding(IdDTO $idDTO): array
    {
        return array_map(function (Organization $organization) {
            return $organization->getName();
        }, $this->orgRepository->findBy(['address' => $idDTO->id]));
    }

    /**
     * Возвращает список организаций по идентификатору вида деятельности
     * @param IdDTO $idDTO
     * @return array
     */
    public function getOrgByActivity(IdDTO $idDTO): array
    {
        return array_map(function (Organization $organization) {
            return $organization->getName();
        }, $this->activityRepository->find($idDTO->id)->getOrganizations()->toArray());
    }

    /**
     * Получает список зданий и организаций в них в радиусе (примерно 11 км от указанной точки)
     * @param CoordinatesDTO $coordinates
     * @return array
     */
    public function getOrgByRadius(CoordinatesDTO $coordinates): array
    {
        $buildings = $this->buildingRepository->createQueryBuilder('b')
            ->where('b.latitude BETWEEN :minLat AND :maxLat AND b.longitude BETWEEN :minLug AND :maxLug')
            ->setParameter('minLat', $coordinates->latitude - 0.1)
            ->setParameter('maxLat', $coordinates->latitude + 0.1)
            ->setParameter('minLug', $coordinates->longitude - 0.1)
            ->setParameter('maxLug', $coordinates->longitude + 0.1)
            ->getQuery()
            ->getResult();
        $result = [];
        foreach ($buildings as $building) {
            $street = $building->getStreetId();
            $city = $street->getCityId();
            $result[] = [
                'address' => sprintf("%s, %s №%s", $city->getName(), $street->getName(), $building->getNum()),
                'organisations' => array_map(function (Organization $organization) {
                    return $organization->getName();
                }, $building->getOrganizations()->toArray())
            ];
        }
        return $result ?: [];
    }

    /**
     * Возвращает информацию об организации
     * @param IdDTO $idDTO
     * @return array
     */
    public function getInfo(IdDTO $idDTO): array
    {
        $organization = $this->orgRepository->find($idDTO->id);
        if (empty($organization)) {
            return [];
        }
        return $this->orgInfo($organization);
    }

    /**
     * Формирует строку вида деятельности с учетом родительских видов
     * @param Activity $activity
     * @return string
     */
    private function activityString(Activity $activity): string
    {
        $parent = $activity->getParent();
        if (!empty($parent)) {
            return sprintf("%s--->%s", $this->activityString($this->activityRepository->find($parent)), $activity->getName());
        }
        return $activity->getName();
    }

    /**
     * Возвращает все организации относящиеся к переданному виду деятельности и его дочерним видам деятельности
     * @param TreeDTO $treeDTO
     * @return array
     */
    public function getOrgActivityTree(TreeDTO $treeDTO): array
    {
        $activity = $this->activityRepository->find($treeDTO->id);
        $org = $this->getOrgs($activity, $treeDTO->count);
        return array_map(function ($el) use ($treeDTO) {
            return $this->orgInfo($el);
        }, $org);
    }

    /**
     * Возвращает массив организаций относящиеся к виду деятельности и его дочерним видам деятельности
     * @param Activity $activity
     * @param null $max
     * @param int $count
     * @return array
     */
    private function getOrgs(Activity $activity, $max = null, int $count = 1): array
    {
        $org = $activity->getOrganizations()->toArray();
        $child = $this->activityRepository->getChildren($activity->getId());
        if (!empty($child) && !(!empty($max) && $max == $count)) {
            foreach ($child as $el) {
                    $org = array_merge($org, $this->getOrgs($el, $max, ($count + 1)));
            }
        }
        return $org;
    }

    /**
     * Возвращает массив с информацией о переданной организации
     * @param Organization $organization
     * @return array
     */
    private function orgInfo(Organization $organization): array
    {
        $building = $organization->getAddress();
        $street = $building->getStreetId();
        $city = $street->getCityId();
        $activity = $organization->getActivity();
        return [
            'name' => $organization->getName(),
            'phones' => $organization->getPhones(),
            'addresses' => sprintf("%s, %s №%s", $city->getName(), $street->getName(), $building->getNum()),
            'activities' => array_map(function (Activity $activity) {
                return $this->activityString($activity);
            }, $activity->toArray())
        ];
    }

}