<?php

namespace App\Controller;

use App\Exception\WorkMachineNotFoundException;
use App\Model\ProcessListResponse;
use App\Service\ProcessService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

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
     */
    #[Route(path: '/api/v1/workmachine/{id}/processes', methods: ['GET'])]
    public function processByWorkMachine(int $id): Response
    {
        try {
            return $this->json($this->processService->getProcessesByWorkMachine($id));
        } catch (WorkMachineNotFoundException $exception) {
            throw new HttpException($exception->getCode(), $exception->getMessage());
        }
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
