<?php
declare(strict_types=1);

namespace App\Application\Representation;

use App\Domain\Model\MarsTime\ValueObject\MarsTime;

class MarsTimeRepresentation
{
    private float $marsSolDate;

    private string $martianCoordinatedTime;

    /**
     * MarsTimeRepresentation constructor.
     * @param MarsTime $marsTime
     */
    public function __construct(MarsTime $marsTime)
    {
        $this->initializeFrom($marsTime);
    }

    /**
     * @return float
     */
    public function getMarsSolDate(): float
    {
        return $this->marsSolDate;
    }

    /**
     * @return string
     */
    public function getMartianCoordinatedTime(): string
    {
        return $this->martianCoordinatedTime;
    }

    private function initializeFrom(MarsTime $marsTime): void
    {
        $this->marsSolDate = $marsTime->getMarsSolDate()->getDate();
        $this->martianCoordinatedTime = $marsTime->getMartianCoordinatedTime()->getTime();
    }
}