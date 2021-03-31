<?php

namespace App\Dto;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Idea;
use App\Entity\Recipient;

/**
 * @ApiResource(
 *      collectionOperations={
 *          "post"={
 *              "method"="post",
 *              "path"="/gifts/create_from_idea",
 *              "messenger"=true,
 *              "output"=false,
 *              "status"=202,
 *          },
 *      },
 *      itemOperations={},
 * )
 */
final class CreateGiftFromIdeaCommand
{
    /**
     * @var Idea
     */
    private $idea;

    /**
     * @var string
     */
    private $eventYear;

    /**
     * @var Recipient[]
     */
    private $recipients;

    public function __construct()
    {
        $this->recipients = [];
    }

    public function getIdea(): ?Idea
    {
        return $this->idea;
    }

    public function setIdea(Idea $idea)
    {
        $this->idea = $idea;

        return $this;
    }

    public function getEventYear(): ?string
    {
        return $this->eventYear;
    }

    public function setEventYear(string $eventYear)
    {
        $this->eventYear = $eventYear;

        return $this;
    }

    public function getRecipients(): array
    {
        return $this->recipients;
    }

    public function addRecipient(Recipient $recipient): self
    {
        $this->recipients[] = $recipient;

        return $this;
    }

    public function removeRecipient(Recipient $recipient): self
    {
        /* $this->recipients->removeElement($recipient); */
        $key = array_search($recipient, $this->recipients);
        if ($key !== false) {
            unset($this->recipients[$key]);
        }

        return $this;
    }
}
