<?php

namespace App\Controller;

use App\Attribute\RequestBody;
use App\Model\ProcessListResponse;
use App\Service\BalancingService;
use App\Service\ProcessService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\ErrorResponse;
use App\Model\IdResponse;
use App\Model\CreateProcessRequest;

class ProcessController extends AbstractController
{
    public function __construct(private ProcessService $processService, private BalancingService $balancingService)
    {
    }

    /**
     * @OA\Tag(name="Process")
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
     * @OA\Tag(name="Process")
     * @OA\Response(
     *     response = 200,
     *     description = "Return processes",
     *     @Model(type=ProcessListResponse::class)
     * )
     */
    #[Route(path: '/api/v1/process/get', methods: ['GET'])]
    public function getProcesses(): Response
    {
        return $this->json($this->processService->getProcesses());
    }

    /**
     * @OA\Tag(name="Process")
     * @OA\Response(
     *     response=200,
     *     description="Create a process",
     *     @Model(type=IdResponse::class)
     * )
     * @OA\Response(
     *     response="400",
     *     description="Validation failed",
     *     @Model(type=ErrorResponse::class)
     * )
     *  @OA\Response(
     *     response = 409,
     *     description = "Process already exists",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\RequestBody(@Model(type=CreateProcessRequest::class))
     */
    #[Route(path: '/api/v1/process/add', methods: ['POST'])]
    public function createProcess(#[RequestBody] CreateProcessRequest $request): Response
    {
        return $this->json($this->balancingService->createProcess($request));
    }

    /**
     * @OA\Tag(name="Process")
     * @OA\Response(
     *     response=200,
     *     description="Remove a process"
     * )
     * @OA\Response(
     *     response=404,
     *     description="process not found",
     *     @Model(type=ErrorResponse::class)
     * )
     */
    #[Route(path: '/api/v1/process/{id}', methods: ['DELETE'])]
    public function deleteProcess(string $name): Response
    {
        $this->balancingService->deleteProcess($name);

        return $this->json(null);
    }
}
