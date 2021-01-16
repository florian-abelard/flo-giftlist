<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 *
 * @ApiResource(
 *      collectionOperations={"get", "post"},
 *      itemOperations={
 *          "get",
 *          "put",
 *          "delete"
 *      },
 *      normalizationContext={"groups"={"event:read"}},
 *      denormalizationContext={"groups"={"event:write"}},
 *      attributes={
 *          "order"={"year": "DESC", "id": "ASC"}
 *      }
 * )
 */
class Event
{
    /**
     * @var UuidInterface The internal primary identity key
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     *
     * @Groups({
     *     "event:read",
     *     "gift:read",
     * })
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({
     *     "event:read",
     *     "gift:read",
     * })
     */
    private $label;

    /**
     * @ORM\Column(type="integer")
     *
     * @Groups({
     *     "event:read",
     *     "gift:read",
     * })
     */
    private $year;

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }
}
