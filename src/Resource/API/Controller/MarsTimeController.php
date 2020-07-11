<?php
declare(strict_types=1);

namespace App\Resource\API\Controller;

use App\Application\Representation\Error\InvalidDateTimeValueRepresentation;
use App\Application\Representation\MarsTimeRepresentation;
use App\Application\Service\MarsTimeApplicationService;
use App\Resource\API\SerializedResponseHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use Exception;

class MarsTimeController extends AbstractController
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
     * @Route("/mars-time/convert/{earthUTCTime}", methods={"GET"}, name="mars-time-convert-route")
     * @param SerializedResponseHandler $responseHandler
     * @param string $earthUTCTime
     * @return JsonResponse
     */
    public function convert(SerializedResponseHandler $responseHandler, string $earthUTCTime): JsonResponse
    {
        try {
            $earthUTCTimeDateObject = new DateTime($earthUTCTime);
            return $responseHandler->render(
                new MarsTimeRepresentation(
                    $this->applicationService->convertToMarsTime($earthUTCTimeDateObject)
                )
            );
        } catch (Exception $e) {
            return $responseHandler->render(
                new InvalidDateTimeValueRepresentation(),
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}