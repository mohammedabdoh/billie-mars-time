<?php
declare(strict_types=1);

namespace App\Domain\Model\MarsTime\Service;

use App\Domain\Model\MarsTime\ValueObject\MarsSolDate;
use App\Domain\Model\MarsTime\ValueObject\MarsTime;
use App\Domain\Model\MarsTime\ValueObject\MartianCoordinatedTime;
use DateTime;
use Exception;

class MarsTimeDomainService
{
    /**
     * @param DateTime $earthUTCTime
     * @return MarsTime
     * @throws Exception
     */
    public function getMarsTime(DateTime $earthUTCTime): MarsTime
    {
        $marsSolDate = $this->createMarsSolDateObject($earthUTCTime);
        return new MarsTime(
            $marsSolDate,
            $this->createMartianCoordinatedTimeObject($marsSolDate)
        );
    }

    /**
     * Converts the Earth UTC time and created a new MarsSolDate our of it
     * using the formula MSD = (t + (TAI−UTC)) / 88775.244147 + 34127.2954262 @see https://en.wikipedia.org/wiki/Timekeeping_on_Mars#cite_note-giss1-1
     * @param DateTime $earthUTCTime
     * @return MarsSolDate
     */
    private function createMarsSolDateObject(DateTime $earthUTCTime): MarsSolDate
    {
        $secondsPerSol = 88775.244147;
        $currentLeapSeconds = 37;
        $marsSolDate = ($earthUTCTime->getTimestamp() + $currentLeapSeconds) / $secondsPerSol + 34127.2954262;
        return new MarsSolDate($marsSolDate);
    }

    /**
     * Calculate the MTC from the MSD using fractions
     * using the formula MTC = (MSD mod 1) × 24 h @see https://en.wikipedia.org/wiki/Timekeeping_on_Mars#cite_note-giss1-1
     * @param MarsSolDate $marsSolDate
     * @return MartianCoordinatedTime
     * @throws Exception
     */
    private function createMartianCoordinatedTimeObject(MarsSolDate $marsSolDate): MartianCoordinatedTime
    {
        $numberOfSecondsInADay = 86400;
        $martianCoordinatedTime = (int) round(fmod($marsSolDate->getDate(), 1) * $numberOfSecondsInADay);
        return new MartianCoordinatedTime(gmdate("H:i:s", $martianCoordinatedTime));
    }
}