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
 * @ORM\Entity(repositoryClass="App\Repository\IdeaRepository")
 * 
 * @ApiResource(
 *      collectionOperations={"get", "post"},
 *      itemOperations={"get", "patch", "delete"},
 *      normalizationContext={
 *          "groups"={"idea"}
 *      },
 *      attributes={
 *          "order"={"updatedAt": "DESC", "id": "ASC"}
 *      }
 * )
 */
class Idea implements TimestampableInterface
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
     * @Groups({"idea"})
     */
    protected $id;

    /** 
     * @var string The label of the gift
     * 
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank
     * @Groups({"idea"})
     */
    private $label;

    /** 
     * @var Price The price of the gift
     * 
     * @ORM\Embedded(class="App\Entity\ValueObject\Price")
     * 
     * @Assert\Type(type="App\Entity\ValueObject\Price")
     * @Groups({"idea"})
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity="Recipient")
     * @ORM\JoinTable(name="ideas_recipients",
     *      joinColumns={@ORM\JoinColumn(name="idea_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="recipient_id", referencedColumnName="id")}
     *      )
     * 
     * @Groups({"idea"})
     */
    private $recipients;

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
}
