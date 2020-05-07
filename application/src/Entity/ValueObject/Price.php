<?php

namespace App\Entity\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Embeddable()
 */
final class Price
{
    /**
     * @var float
     * 
     * @ORM\Column(type="float", nullable=true)
     * 
     * @Groups({"idea"})
     */
    private $value;
    
    public function __construct(float $value = null)
    {
        if (!is_null($value)) {
            $this->validate($value);
        }

        $this->value = $value;
    }

    public function value(): ?float
    {
        return $this->value;
    }

    public function equals(Price $price): bool
    {
        return $this->value() === $price->value();
    }

    public function validate(float $value): void
    {
        if ($value < 0)
        {
            throw new \InvalidArgumentException('The amount of the price must be bigger than 0. ' . $value . ' given');
        }
    }
}
