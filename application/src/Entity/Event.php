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
 *          "order"={"date": "DESC", "id": "ASC"}
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
     * @ORM\Column(type="date")
     *
     * @Groups({
     *     "event:read",
     *     "gift:read",
     * })
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EventType")
     *
     * @Groups({
     *     "gift:read",
     * })
     */
    private $type;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getType(): ?EventType
    {
        return $this->type;
    }

    public function setType(?EventType $type): self
    {
        $this->type = $type;

        return $this;
    }
}
