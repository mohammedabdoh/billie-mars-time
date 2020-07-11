<?php
declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Model\MarsTime\ValueObject\MarsTime;
use App\Domain\Model\MarsTime\Service\MarsTimeDomainService;
use DateTime;
use Exception;

class MarsTimeApplicationService
{
    private MarsTimeDomainService $domainService;

    /**
     * MarsTimeApplicationService constructor.
     * @param MarsTimeDomainService $domainService
     */
    public function __construct(MarsTimeDomainService $domainService)
    {
        $this->domainService = $domainService;
    }

    /**
     * @param DateTime $earthUTCTime
     * @return MarsTime
     * @throws Exception
     */
    public function convertToMarsTime(DateTime $earthUTCTime): MarsTime
    {
        return $this->domainService->getMarsTime($earthUTCTime);
    }
}