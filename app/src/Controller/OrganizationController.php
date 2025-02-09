<?php

namespace App\Controller;

use App\DTO\CoordinatesDTO;
use App\DTO\IdDTO;
use App\DTO\TreeDTO;
use App\Service\OrganizationService;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\RequestBody;
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
    #[Parameter(parameter: 'id', name: 'id', description: 'Идентификатор здания. Если ищем все организации в здании то петрологам что данные ID есть у пользователя', in: 'query', example: '52')]
    #[RequestBody(content: new JsonContent(type: 'object', example: '{"id" : 52}'))]
    #[Route('/org/building', name: 'building', methods: ['POST'], format: 'json')]
    public function getOrgByBuilding(#[MapRequestPayload] IdDTO $idDTO): JsonResponse
    {
        return $this->json($this->service->getOrgInBuilding($idDTO));
    }

    /**
     * Возвращает организации по идентификатору вида деятельности
     * @param IdDTO $idDTO
     * @return JsonResponse
     */
    #[Parameter(parameter: 'id', name: 'id', description: 'Идентификатор вида деятельности', in: 'query', example: '11')]
    #[RequestBody(content: new JsonContent(type: 'object', example: '{"id" : 11}'))]
    #[Route('/org/activity', name: 'activity', methods: ['POST'], format: 'json')]
    public function getOrgByActivity(#[MapRequestPayload] IdDTO $idDTO): JsonResponse
    {
        return $this->json($this->service->getOrgByActivity($idDTO));
    }

    /**
     * Возвращает список зданий и организаций в них в радиусе (примерно 11 км от указанной точки)
     * @param CoordinatesDTO $coordinatesDTO
     * @return JsonResponse
     */
    #[Parameter(parameter: 'latitude', name: 'latitude', description: 'Широта точки центра от которого ищем', in: 'query', example: '55.8')]
    #[Parameter(parameter: 'longitude', name: 'longitude', description: 'Долгота точки центра от которого ищем', in: 'query', example: '37.4')]
    #[RequestBody(content: new JsonContent(type: 'object', example: '{"latitude" : 55.8, "longitude": 37.4}'))]
    #[Route('/org/coordinates', name: 'coordinates', methods: ['POST'], format: 'json')]
    public function etOrgByBuildingRadius(#[MapRequestPayload] CoordinatesDTO $coordinatesDTO): JsonResponse
    {
        return $this->json($this->service->getOrgByRadius($coordinatesDTO));
    }

    /**
     * Возвращает информацию об организации
     * @param IdDTO $idDTO
     * @return JsonResponse
     */
    #[Parameter(parameter: 'id', name: 'id', description: 'Идентификатор организации', in: 'query', example: '75')]
    #[RequestBody(content: new JsonContent(type: 'object', example: '{"id" : 75}'))]
    #[Route('/org/info', name: 'get_org_by_id', methods: ['POST'], format: 'json')]
    public function getOrgById(#[MapRequestPayload] IdDTO $idDTO): JsonResponse
    {
        return $this->json($this->service->getInfo($idDTO));
    }


    /**
     * Возвращает все организации относящиеся к переданному виду деятельности и его дочерним видам деятельности
     * @param TreeDTO $treeDTO
     * @return JsonResponse
     */
    #[Parameter(parameter: 'id', name: 'id', description: 'Идентификатор вида деятельности', in: 'query', example: '9')]
    #[Parameter(parameter: 'count', name: 'count', description: 'Как глубоко от переданного вида деятельности строить древо', in: 'query', example: 'null')]
    #[RequestBody(content: new JsonContent(type: 'object', example: '{"id" : 9, "count" : null}'))]
    #[Route('/org/tree', name: 'get_org_by_activity_tree', methods: ['POST'], format: 'json')]
    public function getOrgActivitiesTree(#[MapRequestPayload] TreeDTO $treeDTO): JsonResponse
    {
        return $this->json($this->service->getOrgActivityTree($treeDTO));
    }
}
