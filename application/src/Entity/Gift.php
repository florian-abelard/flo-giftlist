<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\ValueObject\Price;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GiftRepository")
 *
 * @ApiResource(
 *      collectionOperations={"get", "post"},
 *      itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"gift:read","gift:item:get"}},
 *          },
 *          "put",
 *          "delete"
 *      },
 *      normalizationContext={"groups"={"gift:read"}},
 *      denormalizationContext={"groups"={"gift:write"}},
 *      attributes={
 *          "order"={"updatedAt": "DESC", "id": "ASC"}
 *      }
 * )
 */
class Gift implements TimestampableInterface
{
    use TimestampableTrait;

    /**
     * @var UuidInterface The internal primary identity key
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     *
     * @Groups({
     *     "gift:read",
     *     "gift:item:get",
     * })
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({
     *     "gift:read",
     *     "gift:write",
     *     "gift:item:get",
     * })
     */
    private $label;

    /**
     * @var Price The price of the gift
     *
     * @ORM\Embedded(class="App\Entity\ValueObject\Price")
     *
     * @Assert\Type(type="App\Entity\ValueObject\Price")
     *
     * @Groups({
     *     "gift:write",
     *     "gift:item:get",
     * })
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity="Recipient")
     * @ORM\JoinTable(name="gifts_recipients",
     *      joinColumns={@ORM\JoinColumn(name="gift_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="recipient_id", referencedColumnName="id")}
     *      )
     *
     * @Groups({
     *     "gift:read",
     *     "gift:write",
     *     "gift:item:get",
     * })
     */
    private $recipients;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Event")
     *
     * @Groups({
     *     "gift:read",
     *     "gift:write",
     *     "gift:item:get",
     * })
     */
    private $event;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Length(255)
     *
     * @Groups({
     *     "gift:write",
     *     "gift:item:get",
     * })
     */
    private $note;

    /**
     * @ORM\Column(type="date", nullable=true)
     *
     * @Assert\Date
     *
     * @Groups({
     *     "gift:write",
     *     "gift:item:get",
     * })
     *
     * @var string A "Y-m-d" formatted value
     */
    private $giftDate;

    public function __construct()
    {
        $this->price = new Price();
        $this->recipients = new ArrayCollection();
    }

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

    public function getPrice(): ?Price
    {
        return $this->price;
    }

    public function setPrice(Price $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getRecipients(): Collection
    {
        return $this->recipients;
    }

    public function addRecipient(Recipient $recipient): self
    {
        $this->recipients->add($recipient);

        return $this;
    }

    public function removeRecipient(Recipient $recipient): self
    {
        $this->recipients->removeElement($recipient);

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getGiftDate(): ?\DateTimeInterface
    {
        return $this->giftDate;
    }

    public function setGiftDate(?\DateTimeInterface $giftDate): self
    {
        $this->giftDate = $giftDate;

        return $this;
    }
}
