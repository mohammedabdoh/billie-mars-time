<?php
declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model\Service;

use App\Domain\Model\MarsTime\ValueObject\MarsTime;
use PHPUnit\Framework\TestCase;
use App\Domain\Model\MarsTime\Service\MarsTimeDomainService;
use DateTime;
use Exception;

class MarsTimeDomainServiceTest extends TestCase
{
    private MarsTimeDomainService $domainService;

    public function setUp(): void
    {
        parent::setUp();
        $this->domainService = new MarsTimeDomainService();
    }

    /**
     * @throws Exception
     */
    public function testGetMarsTime()
    {
        $earthUTCTime = '2020-07-11T16:34:40+00:00';
        $dateInstance = new DateTime($earthUTCTime);

        $marsSolDate = $this->domainService->getMarsTime($dateInstance);

        $this->assertInstanceOf(MarsTime::class, $marsSolDate);
        $this->assertSame($marsSolDate->getMarsSolDate()->getDate(), 52088.21834250023);
        $this->assertEquals(52088.21834250023, $marsSolDate->getMarsSolDate()->getDate());

        $this->assertSame($marsSolDate->getMartianCoordinatedTime()->getTime(), "05:14:25");
        $this->assertEquals("05:14:25", $marsSolDate->getMartianCoordinatedTime()->getTime());
    }
}