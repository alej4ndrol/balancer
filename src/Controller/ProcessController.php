<?php

namespace App\Controller;

use App\Model\ProcessListResponse;
use App\Service\ProcessService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\ErrorResponse;

class ProcessController extends AbstractController
{
    public function __construct(private ProcessService $processService)
    {
    }

    /**
     * @OA\Response(
     *     response = 200,
     *     description = "Return processes by work-machine id",
     *     @Model(type=ProcessListResponse::class)
     * )
     * @OA\Response(
     *     response = 404,
     *     description = "Work-machine not found",
     *     @Model(type=ErrorResponse::class)
     * )
     */
    #[Route(path: '/api/v1/workmachine/{id}/processes', methods: ['GET'])]
    public function processByWorkMachine(int $id): Response
    {
        return $this->json($this->processService->getProcessesByWorkMachine($id));
    }

    /**
     * @OA\Response(
     *     response = 200,
     *     description = "Return processes",
     *     @Model(type=ProcessListResponse::class)
     * )
     */
    #[Route(path: '/api/v1/process/get', methods: ['GET'])]
    public function getProcessMachines(): Response
    {
        return $this->json($this->processService->getProcesses());
    }
}
