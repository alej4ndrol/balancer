<?php

namespace App\Controller;

use App\Attribute\RequestBody;
use App\Model\CreateWorkMachineRequest;
use App\Model\ErrorResponse;
use App\Model\IdResponse;
use App\Model\WorkMachineListResponse;
use App\Service\BalancingService;
use App\Service\WorkMachineService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkMachineController extends AbstractController
{
    public function __construct(private WorkMachineService $workMachineService, private BalancingService $balancingService)
    {
    }

    /**
     * @OA\Tag(name="Work machine")
     * @OA\Response(
     *     response = 200,
     *     description = "Return work-machines",
     *     @Model(type=WorkMachineListResponse::class)
     * )
     */
    #[Route(path: '/api/v1/workmachine/get', methods: ['GET'])]
    public function getWorkMachines(): Response
    {
        // #TODO добавить отображение заргуженности каждой машины при выводе
        return $this->json($this->workMachineService->getWorkMachines());
    }

    /**
     * @OA\Tag(name="Work machine")
     * @OA\Response(
     *     response=200,
     *     description="Create a work-machine",
     *     @Model(type=IdResponse::class)
     * )
     * @OA\Response(
     *     response="400",
     *     description="Validation failed",
     *     @Model(type=ErrorResponse::class)
     * )
     *  @OA\Response(
     *     response = 409,
     *     description = "Work-machine already exists",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\RequestBody(@Model(type=CreateWorkMachineRequest::class))
     */
    #[Route(path: '/api/v1/workmachine/add', methods: ['POST'])]
    public function createWorkMachine(#[RequestBody] CreateWorkMachineRequest $request): Response
    {
        return $this->json($this->balancingService->createWorkMachine($request));
    }

    /**
     * @OA\Tag(name="Work machine")
     * @OA\Response(
     *     response=200,
     *     description="Remove a work-machine"
     * )
     * @OA\Response(
     *     response=404,
     *     description="work machine not found",
     *     @Model(type=ErrorResponse::class)
     * )
     */
    #[Route(path: '/api/v1/workmachine/{name}', methods: ['DELETE'])]
    public function deleteWorkMachine(string $name): Response
    {
        $this->balancingService->deleteWorkMachine($name);

        return $this->json(null);
    }

    /**
     * @OA\Tag(name="Work machine")
     * @OA\Response(
     *     response = 200,
     *     description = "Return work-machines load",
     * )
     */
    #[Route(path: '/api/v1/workmachine/load/get', methods: ['GET'])]
    public function getWorkMachinesLoad(): Response
    {
        return $this->json($this->balancingService->getAllWorkMachineLoad());
    }
}
