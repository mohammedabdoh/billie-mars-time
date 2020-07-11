<?php
declare(strict_types=1);

namespace App\Resource\API;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class SerializedResponseHandler
{
    private SerializerInterface $serializer;

    /**
     * SerializerWrapper constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function render($content, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize($content, 'json'),
            $statusCode,
            [],
            true
        );
    }
}