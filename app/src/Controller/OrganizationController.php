<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Repository\ActivityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class OrganizationController extends AbstractController
{
    #[Route('/organization', name: 'app_organization')]
    public function index(): Response
    {
        return $this->render('organization/index.html.twig', [
            'controller_name' => 'OrganizationController',
        ]);
    }

    #[Route('/test', name: 'test_organization')]
    public function show(EntityManagerInterface $entityManager): Response
    {
        $activityRepo = $entityManager->getRepository(Activity::class);
        /** @var ActivityRepository $activityRepo */
        $activity = $activityRepo->getLastChild();
        return $this->redirectToRoute('app_organization');
    }
}
