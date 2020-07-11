<?php
declare(strict_types=1);

namespace App\Domain\Model\MarsTime\ValueObject;

class MarsSolDate
{
    private float $date;

    /**
     * MarsSolDate constructor.
     * @param float $date
     */
    public function __construct(float $date)
    {
        $this->date = $date;
    }

    /**
     * @return float
     */
    public function getDate(): float
    {
        return $this->date;
    }
}