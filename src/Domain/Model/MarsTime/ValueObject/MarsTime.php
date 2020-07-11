<?php
declare(strict_types=1);

namespace App\Domain\Model\MarsTime\ValueObject;

class MarsTime
{
    private MarsSolDate $marsSolDate;

    private MartianCoordinatedTime $martianCoordinatedTime;

    /**
     * TimeOnMars constructor.
     * @param MarsSolDate $marsSolDate
     * @param MartianCoordinatedTime $martianCoordinatedTime
     */
    public function __construct(MarsSolDate $marsSolDate, MartianCoordinatedTime $martianCoordinatedTime)
    {
        $this->marsSolDate = $marsSolDate;
        $this->martianCoordinatedTime = $martianCoordinatedTime;
    }

    /**
     * @return MarsSolDate
     */
    public function getMarsSolDate(): MarsSolDate
    {
        return $this->marsSolDate;
    }

    /**
     * @return MartianCoordinatedTime
     */
    public function getMartianCoordinatedTime(): MartianCoordinatedTime
    {
        return $this->martianCoordinatedTime;
    }
}