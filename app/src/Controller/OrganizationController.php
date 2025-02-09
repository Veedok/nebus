<?php

namespace App\Controller;

use App\DTO\CoordinatesDTO;
use App\DTO\IdDTO;
use App\Service\OrganizationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

/** Контроллер для работы с организациями */
final class OrganizationController extends AbstractController
{

    /**
     * Определение зависимостей
     * @param OrganizationService $service
     */
    public function __construct(
        private readonly OrganizationService $service
    )
    {
    }

    /**
     * Возвращает организации по идентификатору здания
     * @param IdDTO $idDTO
     * @return JsonResponse
     */
    #[Route('/org/find_by_building', name: 'get_org_by_building', methods: ['POST'], format: 'json')]
    public function getOrgByBuilding(#[MapRequestPayload] IdDTO $idDTO): JsonResponse
    {
        return $this->json($this->service->getOrgInBuilding($idDTO));
    }

    /**
     * Возвращает организации по идентификатору вида деятельности
     * @param IdDTO $idDTO
     * @return JsonResponse
     */
    #[Route('/org/find_by_activity', name: 'get_org_by_activity', methods: ['POST'], format: 'json')]
    public function getOrgByActivity(#[MapRequestPayload] IdDTO $idDTO): JsonResponse
    {
        return $this->json($this->service->getOrgByActivity($idDTO));
    }

    /**
     * Возвращает список зданий и организаций в них в радиусе (примерно 11 км от указанной точки)
     * @param CoordinatesDTO $coordinatesDTO
     * @return JsonResponse
     */
    #[Route('/org/find_by_coordinates', name: 'get_org_by_coordinates', methods: ['POST'], format: 'json')]
    public function etOrgByBuildingRadius(#[MapRequestPayload] CoordinatesDTO $coordinatesDTO): JsonResponse
    {
        return $this->json($this->service->getOrgByRadius($coordinatesDTO));
    }

    /**
     * Возвращает информацию об организации
     * @param IdDTO $idDTO
     * @return JsonResponse
     */
    #[Route('/org/info', name: 'get_org_by_id', methods: ['POST'], format: 'json')]
    public function getOrgById(#[MapRequestPayload] IdDTO $idDTO): JsonResponse
    {
        return $this->json($this->service->getInfo($idDTO));
    }


    /**
     * Возвращает все организации относящиеся к переданному виду деятельности и его дочерним видам деятельности
     * @param IdDTO $idDTO
     * @return JsonResponse
     */
    #[Route('/org/tree', name: 'get_org_by_activity_tree', methods: ['POST'], format: 'json')]
    public function getOrgActivitiesTree(#[MapRequestPayload] IdDTO $idDTO): JsonResponse
    {
        return $this->json($this->service->getOrgActivityTree($idDTO));
    }
}
