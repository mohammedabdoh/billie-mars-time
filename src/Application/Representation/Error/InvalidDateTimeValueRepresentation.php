<?php
declare(strict_types=1);

namespace App\Application\Representation\Error;

class InvalidDateTimeValueRepresentation
{
    private string $error;

    /**
     * InvalidDateTimeValueRepresentation constructor.
     * @param string $error
     */
    public function __construct(string $error = 'Invalid earth time stamp in UTC format')
    {
        $this->error = $error;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }
}
