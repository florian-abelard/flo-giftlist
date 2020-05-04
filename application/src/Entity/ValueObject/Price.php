<?php

namespace App\Entity\ValueObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
final class Price
{
    /**
     * @ORM\Column(type="float", nullable=true)
     * @var float
     */
    private $amount;

    public function __construct(float $amount = null)
    {
        $this->validate($amount);

        $this->amount = $amount;
    }

    public function value(): string
    {
        return $this->amount;
    }

    public function equals(Price $price): bool
    {
        return $this->value() === $price->value();
    }

    public function validate(float $amount): void
    {
        if (is_null($amount))
        {
            return;
        }
        if ($amount < 0)
        {
            throw new \InvalidArgumentException('The amount of the price must be bigger than 0. ' . $amount . ' given');
        }
    }

    public function __toString(): string
    {
        return $this->type;
    }
}
