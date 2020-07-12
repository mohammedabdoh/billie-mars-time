<?php
declare(strict_types=1);

namespace App\Resource\API\Controller;

use App\Application\Representation\Error\InvalidDateTimeValueRepresentation;
use App\Application\Representation\MarsTimeRepresentation;
use App\Application\Service\MarsTimeApplicationService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use DateTime;
use Exception;

class MarsTimeController extends AbstractFOSRestController
{
    private MarsTimeApplicationService $applicationService;

    /**
     * MarsTimeController constructor.
     * @param MarsTimeApplicationService $applicationService
     */
    public function __construct(MarsTimeApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    /**
     * @Rest\Get("/mars-time/convert/{earthUTCTime}")
     * @param string $earthUTCTime
     * @return JsonResponse
     */
    public function convert(string $earthUTCTime): Response
    {
        try {
            $earthUTCTimeDateObject = new DateTime($earthUTCTime);
            return $this->handleView(
                $this->view(
                    new MarsTimeRepresentation(
                        $this->applicationService->convertToMarsTime($earthUTCTimeDateObject)
                    ),
                    Response::HTTP_OK
                )->setFormat('json')
            );
        } catch (Exception $e) {
            return $this->handleView(
                $this->view(
                    new InvalidDateTimeValueRepresentation(),
                    Response::HTTP_BAD_REQUEST
                )->setFormat('json')
            );
        }
    }
}