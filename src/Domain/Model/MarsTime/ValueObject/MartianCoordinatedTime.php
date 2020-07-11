<?php
declare(strict_types=1);

namespace App\Domain\Model\MarsTime\ValueObject;

class MartianCoordinatedTime
{
    private string $time;

    /**
     * MarsSolDate constructor.
     * @param string $time
     */
    public function __construct(string $time)
    {
        $this->time = $time;
    }

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }
}