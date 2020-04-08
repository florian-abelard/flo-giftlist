<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IdeaRepository")
 * @ApiResource(
 *      collectionOperations={"get", "post"},
 *      itemOperations={"get", "patch", "delete"},
 *      normalizationContext={"groups"={"idea"}},
 *      attributes={"order"={"updatedAt": "DESC", "id": "ASC"}}
 * )
 */
class Idea implements TimestampableInterface
{
    use TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @Groups({"idea"})
     */
    private $id;

    /** 
     * @var string The label of the gift
     * 
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"idea"})
     */
    private $label;

    /**
     * @ORM\ManyToMany(targetEntity="Recipient")
     * @ORM\JoinTable(name="ideas_recipients",
     *      joinColumns={@ORM\JoinColumn(name="idea_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="recipient_id", referencedColumnName="id")}
     *      )
     * @Groups({"idea"})
     */
    private $recipients;

    public function __construct()
    {
        $this->recipients = new ArrayCollection();
    }

    public function getId(): ?int
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
