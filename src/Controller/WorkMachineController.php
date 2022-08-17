<?php

namespace App\Controller;

use App\Model\WorkMachineListResponse;
use App\Service\WorkMachineService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkMachineController extends AbstractController
{
    public function __construct(private WorkMachineService $workMachineService)
    {
    }

    /**
     * @OA\Response(
     *     response = 200,
     *     description = "Return work-machines",
     *     @Model(type=WorkMachineListResponse::class)
     * )
     */
    #[Route(path: '/api/v1/workmachine/get', methods: ['GET'])]
    public function getWorkMachines(): Response
    {
        return $this->json($this->workMachineService->getWorkMachines());
    }

}
