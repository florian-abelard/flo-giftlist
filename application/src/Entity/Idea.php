<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IdeaRepository")
 * @ApiResource(
 *      collectionOperations={"get", "post"},
 *      itemOperations={"get", "patch"},
 *      normalizationContext={"groups"={"idea"}}
 * )
 */
class Idea
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
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
